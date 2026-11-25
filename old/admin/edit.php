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

$id = (int)($_GET['id'] ?? 0);
$property = getPropertyById($id);

if (!$property) {
    header('Location: index.php');
    exit;
}

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

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['CONTENT_LENGTH'] > 0 && empty($_POST) && empty($_FILES)) {
        $error = 'El archivo es demasiado grande. El máximo permitido es 200MB.';
    }
    $selectedServices = isset($_POST['services']) ? (array)$_POST['services'] : [];

    $uploadedImages = uploadFiles('img_files', ['jpg', 'jpeg', 'png', 'webp', 'avif']);
    if (!empty($uploadedImages)) {
        $mainImg = $uploadedImages[0];
        $imagesStr = implode(', ', $uploadedImages);
    } else {
        $mainImg = trim($_POST['img_url'] ?? '');
        $imagesStr = trim($_POST['existing_images'] ?? '');
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
        'img'         => $mainImg ?: $property['img'],
        'images'      => $imagesStr ?: $property['images'] ?? null,
    ];

    if ($data['price'] === '' || $data['location'] === '') {
        $error = 'Los campos Precio, Ubicación e Imagen son obligatorios.';
    } else {
        try {
            updateProperty($id, $data);
            $success = 'Propiedad actualizada correctamente.';
            $property = getPropertyById($id);
        } catch (PDOException $e) {
            $error = 'Error al actualizar: ' . $e->getMessage();
        }
    }
}

$existingServices = array_map('trim', explode(',', $property['services'] ?? ''));
$existingImages = !empty($property['images'])
    ? array_map('trim', explode(',', $property['images']))
    : (!empty($property['img']) ? [$property['img']] : []);

$pageTitle = 'Editar Propiedad #' . $id;
$activePage = 'properties';
include __DIR__ . '/includes/header.php';
?>

<div class="card form-card">
<div class="card-header d-flex align-items-center justify-content-between gap-2">
<div class="d-flex align-items-center gap-2">
<i class="bi bi-pencil" style="color:var(--gold);font-size:1.1rem;"></i>
<h5 class="mb-0">Editando: <?php echo htmlspecialchars($property['location']); ?></h5>
</div>
<a href="index.php" class="btn btn-outline-modern btn-sm"><i class="bi bi-arrow-left me-1"></i> Volver</a>
</div>
<div class="card-body p-4">

<?php if ($error): ?>
<div class="alert alert-danger border-0 rounded-3 py-2 small" style="background:#fef2f2;color:#991b1b;">
<i class="bi bi-exclamation-circle me-1"></i> <?php echo htmlspecialchars($error); ?>
</div>
<?php endif; ?>
<?php if ($success): ?>
<div class="alert alert-success border-0 rounded-3 py-2 small" style="background:#d1fae5;color:#065f46;">
<i class="bi bi-check-circle-fill me-1"></i> <?php echo htmlspecialchars($success); ?>
</div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data">
<input name="existing_images" type="hidden" value="<?php echo htmlspecialchars($property['images'] ?? $property['img'] ?? ''); ?>">

<div class="row g-3">
<div class="col-md-6">
<label class="form-label" for="location">Ubicación <span class="text-danger">*</span></label>
<input class="form-control" id="location" name="location" type="text" required value="<?php echo htmlspecialchars($property['location']); ?>" placeholder="Ej: Polanco, CDMX">
<small class="text-muted">Esta dirección se usará en el mapa de Google Maps en la página de la propiedad.</small>
</div>
<div class="col-md-3">
<label class="form-label" for="type">Tipo de propiedad</label>
<select class="form-select" id="type" name="type">
<option value="">Seleccionar...</option>
<option value="Casa Residencial" <?php echo ($property['type'] ?? '') === 'Casa Residencial' ? 'selected' : ''; ?>>Casa Residencial</option>
<option value="Villa" <?php echo ($property['type'] ?? '') === 'Villa' ? 'selected' : ''; ?>>Villa</option>
<option value="Mansión" <?php echo ($property['type'] ?? '') === 'Mansión' ? 'selected' : ''; ?>>Mansión</option>
<option value="Penthouse" <?php echo ($property['type'] ?? '') === 'Penthouse' ? 'selected' : ''; ?>>Penthouse</option>
<option value="Departamento Premium" <?php echo ($property['type'] ?? '') === 'Departamento Premium' ? 'selected' : ''; ?>>Departamento Premium</option>
<option value="Hacienda" <?php echo ($property['type'] ?? '') === 'Hacienda' ? 'selected' : ''; ?>>Hacienda</option>
<option value="Casona Colonial" <?php echo ($property['type'] ?? '') === 'Casona Colonial' ? 'selected' : ''; ?>>Casona Colonial</option>
<option value="Casa de Playa" <?php echo ($property['type'] ?? '') === 'Casa de Playa' ? 'selected' : ''; ?>>Casa de Playa</option>
</select>
</div>
<div class="col-md-3">
<label class="form-label" for="city">Ciudad</label>
<input class="form-control" id="city" name="city" type="text" value="<?php echo htmlspecialchars($property['city'] ?? ''); ?>" placeholder="Escribe una ciudad de México...">
<small class="text-muted">Comienza a escribir para ver sugerencias.</small>
</div>
<div class="col-md-6">
<label class="form-label" for="price">Texto del precio <span class="text-danger">*</span></label>
<input class="form-control" id="price" name="price" type="text" required value="<?php echo htmlspecialchars($property['price']); ?>" placeholder="Ej: $12,500,000 MXN">
</div>
<div class="col-md-6">
<label class="form-label" for="price_value">Precio numérico (para filtros)</label>
<input class="form-control" id="price_value" name="price_value" type="number" step="0.01" value="<?php echo htmlspecialchars($property['price_value'] ?? ''); ?>" placeholder="Ej: 12500000">
</div>

<!-- Services as checkboxes -->
<div class="col-12">
<label class="form-label">Servicios</label>
<div class="row g-2">
<?php foreach ($allServices as $svc): ?>
<div class="col-6 col-md-4 col-lg-3">
<div class="form-check">
<input class="form-check-input" id="svc_<?php echo md5($svc); ?>" name="services[]" type="checkbox" value="<?php echo htmlspecialchars($svc); ?>" <?php echo in_array($svc, $existingServices) ? 'checked' : ''; ?>>
<label class="form-check-label small" for="svc_<?php echo md5($svc); ?>"><?php echo htmlspecialchars($svc); ?></label>
</div>
</div>
<?php endforeach; ?>
</div>
</div>

<div class="col-12">
<label class="form-label" for="description">Descripción</label>
<textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe esta propiedad..."><?php echo htmlspecialchars($property['description'] ?? ''); ?></textarea>
</div>

<!-- Multiple image upload -->
<div class="col-md-6">
<label class="form-label">Imágenes actuales</label>
<div class="d-flex flex-wrap gap-2 mb-2">
<?php foreach ($existingImages as $ei): ?>
<div class="border rounded overflow-hidden" style="width:80px;height:60px;">
<img class="w-100 h-100 object-cover" src="/bardial/<?php echo htmlspecialchars($ei); ?>" style="object-fit:cover;">
</div>
<?php endforeach; ?>
</div>
<label class="form-label" for="img_files">Subir nuevas imágenes (reemplazan las actuales)</label>
<input class="form-control form-control-sm" id="img_files" name="img_files[]" type="file" accept="image/*" multiple>
<small class="text-muted">Formatos: JPG, PNG, WebP, AVIF. Si subes archivos reemplazarán todas las imágenes.</small>
</div>
<div class="col-md-6">
<label class="form-label" for="img_url">O usar URL de imagen principal <span class="text-danger">*</span></label>
<input class="form-control" id="img_url" name="img_url" type="text" value="<?php echo htmlspecialchars($property['img']); ?>" placeholder="https://... o uploads/archivo.jpg">
<small class="text-muted">La URL se usará si no subes archivos.</small>
</div>

<div class="col-md-4">
<label class="form-label" for="bed">Dormitorios</label>
<input class="form-control" id="bed" name="bed" type="number" min="0" value="<?php echo (int)$property['bed']; ?>">
</div>
<div class="col-md-4">
<label class="form-label" for="bath">Baños</label>
<input class="form-control" id="bath" name="bath" type="number" min="0" value="<?php echo (int)$property['bath']; ?>">
</div>
<div class="col-md-4">
<label class="form-label" for="sqm">Metros cuadrados</label>
<input class="form-control" id="sqm" name="sqm" type="text" inputmode="numeric" pattern="[0-9]*" value="<?php echo (int)$property['sqm']; ?>" placeholder="Ej: 320">
</div>
<div class="col-md-6">
<label class="form-label" for="badge">Etiqueta (badge)</label>
<select class="form-select" id="badge" name="badge">
<option value="">Ninguna</option>
<option value="Exclusivo" <?php echo ($property['badge'] ?? '') === 'Exclusivo' ? 'selected' : ''; ?>>Exclusivo</option>
<option value="Nuevo" <?php echo ($property['badge'] ?? '') === 'Nuevo' ? 'selected' : ''; ?>>Nuevo</option>
<option value="Inversión" <?php echo ($property['badge'] ?? '') === 'Inversión' ? 'selected' : ''; ?>>Inversión</option>
<option value="Vendido" <?php echo ($property['badge'] ?? '') === 'Vendido' ? 'selected' : ''; ?>>Vendido</option>
<option value="Destacado" <?php echo ($property['badge'] ?? '') === 'Destacado' ? 'selected' : ''; ?>>Destacado</option>
<option value="Oportunidad" <?php echo ($property['badge'] ?? '') === 'Oportunidad' ? 'selected' : ''; ?>>Oportunidad</option>
<option value="Premium" <?php echo ($property['badge'] ?? '') === 'Premium' ? 'selected' : ''; ?>>Premium</option>
<option value="En Obra" <?php echo ($property['badge'] ?? '') === 'En Obra' ? 'selected' : ''; ?>>En Obra</option>
</select>
</div>
<div class="col-12">
<label class="form-label">Video</label>
<?php $currentVideo = $property['video'] ?? ''; include __DIR__ . '/../includes/upload-video-ui.php'; ?>
<small class="text-muted">Arrastra o haz clic para subir un video sin límite de tamaño.</small>
</div>
<div class="col-12">
<div class="form-check">
<input class="form-check-input" id="sold" name="sold" type="checkbox" value="1" <?php echo !empty($property['sold']) ? 'checked' : ''; ?>>
<label class="form-check-label small" for="sold">Marcar como vendida</label>
</div>
</div>
<div class="col-12 d-flex gap-2 pt-2">
<button class="btn btn-gold px-4" type="submit"><i class="bi bi-check-lg me-1"></i> Guardar cambios</button>
<a class="btn btn-outline-modern px-4" href="index.php">Cancelar</a>
</div>
</div>
</form>

</div>
</div>

<?php include __DIR__ . '/../includes/autocomplete-location.php'; ?>
<?php include __DIR__ . '/includes/footer.php'; ?>
