<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

$serviceGroups = [
    'Casa residencial' => ['Alberca', 'Jardín', 'Terraza', 'Cocina integral', 'Seguridad 24h', 'Estacionamiento', 'Roof Garden', 'Chimenea', 'Cuarto de servicio', 'Aire acondicionado', 'Cisterna', 'Estudio'],
    'Bodega' => ['Acceso para trailers', 'Andén de carga', 'Energía trifásica', 'Oficinas', 'Seguridad 24h', 'Estacionamiento', 'Área de maniobras', 'Altura libre', 'Rampa de carga', 'Vigilancia', 'Montacargas', 'Patio de maniobras'],
    'local comercial' => ['Ubicación céntrica', 'Aire acondicionado', 'Estacionamiento', 'Seguridad', 'Área de carga', 'Fachada de cristal', 'Sanitarios', 'Bodega', 'Acceso peatonal', 'Acceso vehicular', 'Flujo peatonal', 'Uso de suelo comercial'],
    'Departamento' => ['Elevador', 'Seguridad 24h', 'Alberca', 'Gimnasio', 'Roof Garden', 'Estacionamiento', 'Balcón', 'Vista panorámica', 'Área de lavado', 'Portón eléctrico', 'Amenidades', 'Mantenimiento incluido', 'Cocina integral', 'Aire acondicionado'],
];
$allServices = [];
foreach ($serviceGroups as $g) {
    foreach ($g as $s) {
        if (!in_array($s, $allServices, true)) $allServices[] = $s;
    }
}
$serviceTypeMap = [];
foreach ($serviceGroups as $type => $services) {
    foreach ($services as $s) {
        $serviceTypeMap[$s][] = $type;
    }
}

$error = '';
$data = $_POST;

function uploadFiles(string $field, array $allowed, int $maxSize = 100 * 1024 * 1024): array {
    $uploaded = [];
    if (empty($_FILES[$field]['name'][0])) return $uploaded;
    $targetDir = __DIR__ . '/../uploads/';
    $total = count($_FILES[$field]['name']);
    for ($i = 0; $i < $total; $i++) {
        if ($_FILES[$field]['error'][$i] !== UPLOAD_ERR_OK) continue;
        if ($_FILES[$field]['error'][$i] === UPLOAD_ERR_INI_SIZE || $_FILES[$field]['size'][$i] > $maxSize) continue;
        $ext = strtolower(pathinfo($_FILES[$field]['name'][$i], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) continue;
        $filename = uniqid('prop_') . '.' . $ext;
        move_uploaded_file($_FILES[$field]['tmp_name'][$i], $targetDir . $filename);
        $uploaded[] = 'uploads/' . $filename;
    }
    return $uploaded;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['CONTENT_LENGTH'] > 0 && empty($_POST) && empty($_FILES)) {
        $error = 'El archivo es demasiado grande. El máximo permitido es 200MB.';
    }
    $selectedServices = isset($_POST['services']) ? (array)$_POST['services'] : [];

$uploadedImages = uploadFiles('img_files', ['jpg', 'jpeg', 'png', 'webp', 'avif']);
$mainImg = '';
$imagesStr = '';

if (!empty($uploadedImages)) {
    $mainImg = $uploadedImages[0];
    $imagesStr = implode(', ', $uploadedImages);
} else {
    $mainImg = trim($_POST['img_url'] ?? '');
}

$videoVal = trim($_POST['video'] ?? '');
$priceText = trim($_POST['price'] ?? '');
$priceValue = preg_replace('/[^\d.]/', '', $priceText);

$data = [
    'price'             => $priceText,
    'price_value'       => $priceValue,
    'location'          => trim($_POST['location'] ?? ''),
    'type'              => trim($_POST['type'] ?? ''),
    'operation'         => trim($_POST['operation'] ?? ''),
    'city'              => trim($_POST['city'] ?? ''),
    'bed'               => $_POST['bed'] ?? 0,
    'bath'              => $_POST['bath'] ?? 0,
    'sqm'               => $_POST['sqm'] ?? 0,
    'construction_sqm'  => $_POST['construction_sqm'] ?? 0,
    'services'          => implode(', ', $selectedServices),
    'description'       => trim($_POST['description'] ?? ''),
    'sold'              => !empty($_POST['sold']),
    'video'             => $videoVal,
    'img'               => $mainImg,
    'images'            => $imagesStr ?: null,
];

    if ($data['price'] === '' || $data['location'] === '' || $data['img'] === '') {
        $error = 'Los campos Precio, Ubicación e Imagen son obligatorios.';
    } else {
        try {
            $id = createProperty($data);
            $_SESSION['flash'] = 'Propiedad creada correctamente.';
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Error al guardar: ' . $e->getMessage();
        }
    }
}

$pageTitle = 'Añadir Propiedad';
$activePage = 'create';
include __DIR__ . '/includes/header.php';
?>

<div class="card form-card">
<div class="card-header d-flex align-items-center gap-2">
<i class="bi bi-plus-circle" style="color:var(--gold);font-size:1.1rem;"></i>
<h5 class="mb-0">Nueva propiedad</h5>
</div>
<div class="card-body p-4">

<?php if ($error): ?>
<div class="alert alert-danger border-0 rounded-3 py-2 small" style="background:#fef2f2;color:#991b1b;">
<i class="bi bi-exclamation-circle me-1"></i> <?php echo htmlspecialchars($error); ?>
</div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
<div class="row g-3">
<div class="col-md-6">
<label class="form-label" for="location">Ubicación <span class="text-danger">*</span></label>
<input class="form-control" id="location" name="location" type="text" required value="<?php echo htmlspecialchars($data['location'] ?? ''); ?>" placeholder="Ej: Polanco, CDMX">
<small class="text-muted">Esta dirección se usará en el mapa de Google Maps en la página de la propiedad.</small>
</div>
<div class="col-md-4">
<label class="form-label" for="type">Tipo de propiedad</label>
<select class="form-select" id="type" name="type">
<option value="">Seleccionar...</option>
<?php foreach (['Casa residencial', 'Bodega', 'local comercial', 'Departamento'] as $t): ?>
<option value="<?php echo htmlspecialchars($t); ?>" <?php echo ($data['type'] ?? '') === $t ? 'selected' : ''; ?>><?php echo htmlspecialchars($t); ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="col-md-4">
<label class="form-label" for="operation">Tipo de operación</label>
<select class="form-select" id="operation" name="operation">
<option value="">Seleccionar...</option>
<option value="Venta" <?php echo ($data['operation'] ?? '') === 'Venta' ? 'selected' : ''; ?>>Venta</option>
<option value="Renta" <?php echo ($data['operation'] ?? '') === 'Renta' ? 'selected' : ''; ?>>Renta</option>
</select>
</div>
<div class="col-md-4">
<label class="form-label" for="city">Ciudad</label>
<input class="form-control" id="city" name="city" type="text" value="<?php echo htmlspecialchars($data['city'] ?? ''); ?>" placeholder="Escribe una ciudad de México...">
<small class="text-muted">Comienza a escribir para ver sugerencias.</small>
</div>
<div class="col-md-6">
<label class="form-label" for="price">Precio <span class="text-danger">*</span></label>
<input class="form-control" id="price" name="price" type="text" required value="<?php echo htmlspecialchars($data['price'] ?? ''); ?>" placeholder="Ej: $12,500,000 MXN">
<small class="text-muted">Se extraerá el valor numérico automáticamente para filtros.</small>
</div>

<!-- Services as checkboxes -->
<div class="col-12">
<label class="form-label">Servicios</label>
<div class="row g-2">
<?php $selectedServices = isset($_POST['services']) ? (array)$_POST['services'] : []; ?>
<?php foreach ($allServices as $svc): ?>
<div class="col-6 col-md-4 col-lg-3 service-item" data-types="<?php echo htmlspecialchars(implode(',', $serviceTypeMap[$svc] ?? [])); ?>">
<div class="form-check">
<input class="form-check-input" id="svc_<?php echo md5($svc); ?>" name="services[]" type="checkbox" value="<?php echo htmlspecialchars($svc); ?>" <?php echo in_array($svc, $selectedServices) ? 'checked' : ''; ?>>
<label class="form-check-label small" for="svc_<?php echo md5($svc); ?>"><?php echo htmlspecialchars($svc); ?></label>
</div>
</div>
<?php endforeach; ?>
</div>
</div>

<div class="col-12">
<label class="form-label" for="description">Descripción</label>
<textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe esta propiedad..."><?php echo htmlspecialchars($data['description'] ?? ''); ?></textarea>
</div>

<!-- Multiple image upload -->
<div class="col-md-12">
<label class="form-label" for="img_files">Subir imágenes (puedes seleccionar varias) <span class="text-danger">*</span></label>
<input class="form-control form-control-sm" id="img_files" name="img_files[]" type="file" accept="image/*" multiple required>
<small class="text-muted">Formatos: JPG, PNG, WebP, AVIF. La primera imagen se usará como portada.</small>
<div id="imgPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
</div>

<div class="col-md-3">
<label class="form-label" for="bed">Dormitorios</label>
<input class="form-control" id="bed" name="bed" type="number" min="0" value="<?php echo htmlspecialchars($data['bed'] ?? 0); ?>">
</div>
<div class="col-md-3">
<label class="form-label" for="bath">Baños</label>
<input class="form-control" id="bath" name="bath" type="number" min="0" value="<?php echo htmlspecialchars($data['bath'] ?? 0); ?>">
</div>
<div class="col-md-3">
<label class="form-label" for="sqm">Metros cuadrados</label>
<input class="form-control" id="sqm" name="sqm" type="text" inputmode="numeric" pattern="[0-9]*" value="<?php echo htmlspecialchars($data['sqm'] ?? 0); ?>" placeholder="Ej: 320">
</div>
<div class="col-md-3">
<label class="form-label" for="construction_sqm">Metros de construcción</label>
<input class="form-control" id="construction_sqm" name="construction_sqm" type="text" inputmode="numeric" pattern="[0-9]*" value="<?php echo htmlspecialchars($data['construction_sqm'] ?? 0); ?>" placeholder="Ej: 280">
</div>

<div class="col-12">
<label class="form-label">Video</label>
<?php $currentVideo = $data['video'] ?? ''; include __DIR__ . '/../includes/upload-video-ui.php'; ?>
<small class="text-muted">Arrastra o haz clic para subir un video sin límite de tamaño.</small>
</div>

<div class="col-12 d-flex gap-2 pt-2">
<button class="btn btn-gold px-4" type="submit" title="Guardar propiedad" aria-label="Guardar propiedad"><i class="bi bi-check-lg me-1"></i> Guardar propiedad</button>
<a class="btn btn-outline-modern px-4" href="index.php" title="Cancelar" aria-label="Cancelar"><i class="bi bi-x-lg me-1"></i>Cancelar</a>
</div>
</div>
</form>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var typeSelect = document.getElementById('type');
    function filterServices() {
        var type = typeSelect ? typeSelect.value : '';
        document.querySelectorAll('.service-item').forEach(function(el) {
            var types = (el.getAttribute('data-types') || '').split(',').map(function(s){ return s.trim(); }).filter(Boolean);
            var show = !type || types.length === 0 || types.indexOf(type) !== -1;
            el.style.display = show ? '' : 'none';
            if (!show) {
                var cb = el.querySelector('input[type="checkbox"]');
                if (cb) cb.checked = false;
            }
        });
    }
    if (typeSelect) {
        typeSelect.addEventListener('change', filterServices);
        filterServices();
    }

    var fileInput = document.getElementById('img_files');
    var preview = document.getElementById('imgPreview');
    if (fileInput && preview) {
        fileInput.addEventListener('change', function() {
            preview.innerHTML = '';
            Array.from(fileInput.files || []).forEach(function(file) {
                if (!file.type || file.type.indexOf('image/') !== 0) return;
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '96px';
                    img.style.height = '72px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.border = '1px solid #e5e7eb';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    }
});
</script>
<?php include __DIR__ . '/../includes/autocomplete-location.php'; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
