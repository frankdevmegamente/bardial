<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

$allServices = [
    'Alberca', 'Alberca Infinity', 'Vista al Mar', 'Seguridad 24h',
    'Estacionamiento Privado', 'Roof Garden', 'Gimnasio', 'Spa',
    'Jardín', 'Chimenea', 'Casa de Huéspedes', 'Cancha de Tenis',
    'Muelle Privado', 'Helipuerto', 'Bodega de Vinos', 'Palapa', 'Tinaja',
];

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

    $data = [
        'price'       => trim($_POST['price'] ?? ''),
        'price_value' => $_POST['price_value'] ?? '',
        'location'    => trim($_POST['location'] ?? ''),
        'type'        => trim($_POST['type'] ?? ''),
        'city'        => trim($_POST['city'] ?? ''),
        'bed'         => $_POST['bed'] ?? 0,
        'bath'        => $_POST['bath'] ?? 0,
        'sqm'         => $_POST['sqm'] ?? 0,
        'services'    => implode(', ', $selectedServices),
        'description' => trim($_POST['description'] ?? ''),
        'badge'       => trim($_POST['badge'] ?? ''),
        'sold'        => !empty($_POST['sold']),
        'video'       => $videoVal,
        'img'         => $mainImg,
        'images'      => $imagesStr ?: null,
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
<div class="col-md-3">
<label class="form-label" for="type">Tipo de propiedad</label>
<select class="form-select" id="type" name="type">
<option value="">Seleccionar...</option>
<option value="Casa Residencial" <?php echo ($data['type'] ?? '') === 'Casa Residencial' ? 'selected' : ''; ?>>Casa Residencial</option>
<option value="Villa" <?php echo ($data['type'] ?? '') === 'Villa' ? 'selected' : ''; ?>>Villa</option>
<option value="Mansión" <?php echo ($data['type'] ?? '') === 'Mansión' ? 'selected' : ''; ?>>Mansión</option>
<option value="Penthouse" <?php echo ($data['type'] ?? '') === 'Penthouse' ? 'selected' : ''; ?>>Penthouse</option>
<option value="Departamento Premium" <?php echo ($data['type'] ?? '') === 'Departamento Premium' ? 'selected' : ''; ?>>Departamento Premium</option>
<option value="Hacienda" <?php echo ($data['type'] ?? '') === 'Hacienda' ? 'selected' : ''; ?>>Hacienda</option>
<option value="Casona Colonial" <?php echo ($data['type'] ?? '') === 'Casona Colonial' ? 'selected' : ''; ?>>Casona Colonial</option>
<option value="Casa de Playa" <?php echo ($data['type'] ?? '') === 'Casa de Playa' ? 'selected' : ''; ?>>Casa de Playa</option>
</select>
</div>
<div class="col-md-3">
<label class="form-label" for="city">Ciudad</label>
<input class="form-control" id="city" name="city" type="text" value="<?php echo htmlspecialchars($data['city'] ?? ''); ?>" placeholder="Escribe una ciudad de México...">
<small class="text-muted">Comienza a escribir para ver sugerencias.</small>
</div>
<div class="col-md-6">
<label class="form-label" for="price">Texto del precio <span class="text-danger">*</span></label>
<input class="form-control" id="price" name="price" type="text" required value="<?php echo htmlspecialchars($data['price'] ?? ''); ?>" placeholder="Ej: $12,500,000 MXN">
</div>
<div class="col-md-6">
<label class="form-label" for="price_value">Precio numérico (para filtros)</label>
<input class="form-control" id="price_value" name="price_value" type="number" step="0.01" value="<?php echo htmlspecialchars($data['price_value'] ?? ''); ?>" placeholder="Ej: 12500000">
</div>

<!-- Services as checkboxes -->
<div class="col-12">
<label class="form-label">Servicios</label>
<div class="row g-2">
<?php $selectedServices = isset($_POST['services']) ? (array)$_POST['services'] : []; ?>
<?php foreach ($allServices as $svc): ?>
<div class="col-6 col-md-4 col-lg-3">
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
<div class="col-md-6">
<label class="form-label" for="img_files">Subir imágenes (puedes seleccionar varias)</label>
<input class="form-control form-control-sm" id="img_files" name="img_files[]" type="file" accept="image/*" multiple>
<small class="text-muted">Formatos: JPG, PNG, WebP, AVIF. La primera imagen se usará como portada.</small>
</div>
<div class="col-md-6">
<label class="form-label" for="img_url">O usar URL de imagen principal <span class="text-danger">*</span></label>
<input class="form-control" id="img_url" name="img_url" type="text" value="<?php echo htmlspecialchars($data['img'] ?? ''); ?>" placeholder="https://...">
<small class="text-muted">Si subes archivos, esta URL se ignora.</small>
</div>

<div class="col-md-4">
<label class="form-label" for="bed">Dormitorios</label>
<input class="form-control" id="bed" name="bed" type="number" min="0" value="<?php echo htmlspecialchars($data['bed'] ?? 0); ?>">
</div>
<div class="col-md-4">
<label class="form-label" for="bath">Baños</label>
<input class="form-control" id="bath" name="bath" type="number" min="0" value="<?php echo htmlspecialchars($data['bath'] ?? 0); ?>">
</div>
<div class="col-md-4">
<label class="form-label" for="sqm">Metros cuadrados</label>
<input class="form-control" id="sqm" name="sqm" type="text" inputmode="numeric" pattern="[0-9]*" value="<?php echo htmlspecialchars($data['sqm'] ?? 0); ?>" placeholder="Ej: 320">
</div>
<div class="col-md-6">
<label class="form-label" for="badge">Etiqueta (badge)</label>
<select class="form-select" id="badge" name="badge">
<option value="">Ninguna</option>
<option value="Exclusivo" <?php echo ($data['badge'] ?? '') === 'Exclusivo' ? 'selected' : ''; ?>>Exclusivo</option>
<option value="Nuevo" <?php echo ($data['badge'] ?? '') === 'Nuevo' ? 'selected' : ''; ?>>Nuevo</option>
<option value="Inversión" <?php echo ($data['badge'] ?? '') === 'Inversión' ? 'selected' : ''; ?>>Inversión</option>
<option value="Vendido" <?php echo ($data['badge'] ?? '') === 'Vendido' ? 'selected' : ''; ?>>Vendido</option>
<option value="Destacado" <?php echo ($data['badge'] ?? '') === 'Destacado' ? 'selected' : ''; ?>>Destacado</option>
<option value="Oportunidad" <?php echo ($data['badge'] ?? '') === 'Oportunidad' ? 'selected' : ''; ?>>Oportunidad</option>
<option value="Premium" <?php echo ($data['badge'] ?? '') === 'Premium' ? 'selected' : ''; ?>>Premium</option>
<option value="En Obra" <?php echo ($data['badge'] ?? '') === 'En Obra' ? 'selected' : ''; ?>>En Obra</option>
</select>
</div>
<div class="col-12">
<label class="form-label">Video</label>
<?php $currentVideo = $data['video'] ?? ''; include __DIR__ . '/../includes/upload-video-ui.php'; ?>
<small class="text-muted">Arrastra o haz clic para subir un video sin límite de tamaño.</small>
</div>
<div class="col-12">
<div class="form-check">
<input class="form-check-input" id="sold" name="sold" type="checkbox" value="1" <?php echo !empty($data['sold']) ? 'checked' : ''; ?>>
<label class="form-check-label small" for="sold">Marcar como vendida</label>
</div>
</div>
<div class="col-12 d-flex gap-2 pt-2">
<button class="btn btn-gold px-4" type="submit"><i class="bi bi-check-lg me-1"></i> Guardar propiedad</button>
<a class="btn btn-outline-modern px-4" href="index.php">Cancelar</a>
</div>
</div>
</form>

</div>
</div>

<?php include __DIR__ . '/../includes/autocomplete-location.php'; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
