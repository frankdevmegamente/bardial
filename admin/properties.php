<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action_toggle_sold'])) {
    $toggleId = (int)($_POST['property_id'] ?? 0);
    if ($toggleId > 0) {
        togglePropertySold($toggleId);
        $_SESSION['flash'] = 'Estado de la propiedad actualizado.';
    }
    $qs = trim($_POST['qs'] ?? '');
    header('Location: properties.php' . ($qs !== '' ? '?' . $qs : ''));
    exit;
}

$properties = getAllProperties();

// Filtros
$search  = trim($_GET['search'] ?? '');
$status  = $_GET['status'] ?? '';
$beds    = $_GET['beds'] ?? '';
$filterType = $_GET['filter_type'] ?? '';
$filterCity = $_GET['filter_city'] ?? '';

if ($search !== '') {
    $properties = array_filter($properties, fn($p) => stripos($p['location'], $search) !== false);
}
if ($status === 'available') {
    $properties = array_filter($properties, fn($p) => empty($p['sold']));
} elseif ($status === 'sold') {
    $properties = array_filter($properties, fn($p) => !empty($p['sold']));
}
if ($beds !== '') {
    $minBeds = (int)$beds;
    $properties = array_filter($properties, fn($p) => (int)$p['bed'] >= $minBeds);
}
if ($filterType !== '') {
    $properties = array_filter($properties, fn($p) => ($p['type'] ?? '') === $filterType);
}
if ($filterCity !== '') {
    $properties = array_filter($properties, fn($p) => ($p['city'] ?? '') === $filterCity);
}

$filtered = count($properties);
$totalAll = count(getAllProperties());

$typesList = array_unique(array_filter(array_column(getAllProperties(), 'type'), fn($t) => !empty($t)));
sort($typesList);
$citiesList = array_unique(array_filter(array_column(getAllProperties(), 'city'), fn($c) => !empty($c)));
sort($citiesList);

$pageTitle = 'Gestión de Propiedades';
$activePage = 'properties';

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

include __DIR__ . '/includes/header.php';
?>

<?php if ($flash): ?>
<div class="alert alert-success alert-dismissible fade show border-0 rounded-3 py-2 small" style="background:#d1fae5;color:#065f46;" role="alert">
<i class="bi bi-check-circle-fill me-1"></i> <?php echo htmlspecialchars($flash); ?>
<button type="button" class="btn-close py-2" data-bs-dismiss="alert" style="font-size:.7rem;"></button>
</div>
<?php endif; ?>

<!-- Header -->
<div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-3">
<div>
<h2 class="fw-bold mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.4rem;">Propiedades</h2>
<p class="text-muted small mb-0"><?php echo $filtered; ?> de <?php echo $totalAll; ?> propiedad(es)</p>
</div>
<div class="d-flex gap-2">
<a href="index.php" class="btn btn-outline-modern btn-sm"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
<a href="create.php" class="btn btn-gold btn-sm px-4"><i class="bi bi-plus-lg me-1"></i> Añadir</a>
</div>
</div>

<!-- Filters -->
<form method="get" class="d-flex flex-wrap align-items-end gap-3 mb-4 p-3 bg-white rounded-3" style="box-shadow:var(--shadow-card);">
<div class="flex-grow-1" style="min-width:180px;">
<label class="form-label small fw-semibold text-muted mb-1" for="search">Buscar ubicación</label>
<div class="input-group input-group-sm">
<span class="input-group-text border-0" style="background:#f8fafc;"><i class="bi bi-search text-muted"></i></span>
<input class="form-control form-control-sm border-0" style="background:#f8fafc;" id="search" name="search" type="text" value="<?php echo htmlspecialchars($search); ?>" placeholder="Polanco, Los Cabos...">
</div>
</div>
<div style="min-width:130px;">
<label class="form-label small fw-semibold text-muted mb-1" for="status">Estado</label>
<select class="form-select form-select-sm" id="status" name="status">
<option value="">Todos</option>
<option value="available" <?php echo $status === 'available' ? 'selected' : ''; ?>>Disponibles</option>
<option value="sold" <?php echo $status === 'sold' ? 'selected' : ''; ?>>Vendidas</option>
</select>
</div>
<div style="min-width:100px;">
<label class="form-label small fw-semibold text-muted mb-1" for="beds">Dormitorios</label>
<select class="form-select form-select-sm" id="beds" name="beds">
<option value="">Cualquiera</option>
<option value="1" <?php echo $beds === '1' ? 'selected' : ''; ?>>1+</option>
<option value="2" <?php echo $beds === '2' ? 'selected' : ''; ?>>2+</option>
<option value="3" <?php echo $beds === '3' ? 'selected' : ''; ?>>3+</option>
<option value="4" <?php echo $beds === '4' ? 'selected' : ''; ?>>4+</option>
<option value="5" <?php echo $beds === '5' ? 'selected' : ''; ?>>5+</option>
</select>
</div>

<div style="min-width:140px;">
<label class="form-label small fw-semibold text-muted mb-1" for="filter_type">Tipo</label>
<select class="form-select form-select-sm" id="filter_type" name="filter_type">
<option value="">Todos</option>
<?php foreach ($typesList as $t): ?>
<option value="<?php echo htmlspecialchars($t); ?>" <?php echo $filterType === $t ? 'selected' : ''; ?>><?php echo htmlspecialchars($t); ?></option>
<?php endforeach; ?>
</select>
</div>
<div style="min-width:120px;">
<label class="form-label small fw-semibold text-muted mb-1" for="filter_city">Ciudad</label>
<select class="form-select form-select-sm" id="filter_city" name="filter_city">
<option value="">Todas</option>
<?php foreach ($citiesList as $c): ?>
<option value="<?php echo htmlspecialchars($c); ?>" <?php echo $filterCity === $c ? 'selected' : ''; ?>><?php echo htmlspecialchars($c); ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="d-flex gap-2">
<button class="btn btn-gold btn-sm px-3" type="submit" title="Filtrar" aria-label="Filtrar"><i class="bi bi-funnel me-1"></i> Filtrar</button>
<a href="properties.php" class="btn btn-outline-modern btn-sm px-3" title="Limpiar filtros" aria-label="Limpiar filtros"><i class="bi bi-x me-1"></i> Limpiar</a>
</div>
</form>

<!-- Property Cards Grid -->
<?php if (empty($properties)): ?>
<div class="text-center py-5">
<div class="mb-3"><i class="bi bi-search fs-1 text-muted"></i></div>
<p class="text-muted mb-2">No se encontraron propiedades con los filtros seleccionados.</p>
<a href="properties.php" class="btn btn-outline-modern btn-sm">Limpiar filtros</a>
</div>
<?php else: ?>
<div class="row g-4">

<?php foreach ($properties as $p): ?>
<div class="col-12 col-sm-6 col-xl-4">
<div class="card border-0 h-100" style="border-radius:var(--radius);box-shadow:var(--shadow-card);transition:var(--transition);overflow:hidden;">
<!-- Image -->
<div class="position-relative" style="height:200px;overflow:hidden;background:#f0f2f5;">
<?php if ($p['img']): ?>
<img src="<?php echo strpos($p['img'], 'uploads/') === 0 ? '/bardial/' . $p['img'] : htmlspecialchars($p['img']); ?>" alt="<?php echo htmlspecialchars($p['location']); ?>" class="w-100 h-100" style="object-fit:cover;transition:transform .3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
<?php else: ?>
<div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted"><i class="bi bi-image fs-1"></i></div>
<?php endif; ?>
<!-- Status -->
<div class="position-absolute top-0 end-0 p-3">
<?php if ($p['sold']): ?>
<span class="badge badge-danger-soft rounded-pill"><i class="bi bi-x me-1"></i>Vendido</span>
<?php else: ?>
<span class="badge badge-success-soft rounded-pill"><i class="bi bi-check me-1"></i>Disponible</span>
<?php endif; ?>
</div>
</div>
<!-- Body -->
<div class="card-body p-3">
<h6 class="fw-semibold mb-1" style="font-size:.9rem;"><?php echo htmlspecialchars($p['location']); ?></h6>
<?php if (!empty($p['type']) || !empty($p['city'])): ?>
<div class="small text-muted mb-2"><?php echo htmlspecialchars($p['type'] ?? ''); ?><?php echo (!empty($p['type']) && !empty($p['city'])) ? ' · ' : ''; ?><?php echo htmlspecialchars($p['city'] ?? ''); ?></div>
<?php endif; ?>
<div class="fw-bold mb-2" style="color:var(--gold);font-size:1.05rem;"><?php echo htmlspecialchars($p['price']); ?></div>
<div class="d-flex gap-3 small text-muted">
<span><i class="bi bi-house me-1"></i><?php echo $p['bed']; ?> dorm</span>
<span><i class="bi bi-droplet me-1"></i><?php echo $p['bath']; ?> baños</span>
<span><i class="bi bi-arrows-angle-expand me-1"></i><?php echo $p['sqm']; ?> m²</span>
</div>
</div>
<!-- Footer -->
<div class="card-footer bg-white border-0 px-3 pb-3 pt-0 d-flex gap-2">
<button type="button" class="btn btn-outline-modern btn-sm" title="Ver lona para impresión" aria-label="Ver lona para impresión" data-bs-toggle="modal" data-bs-target="#lonaModal" data-id="<?php echo (int)$p['id']; ?>"><i class="bi bi-aspect-ratio me-1"></i>Lona</button>
<button type="button" class="btn btn-outline-modern btn-sm" title="Ver código QR" aria-label="Ver código QR" data-bs-toggle="modal" data-bs-target="#qrModal" data-url="<?php echo htmlspecialchars(propertyAbsoluteUrl((int)$p['id'])); ?>" data-title="<?php echo htmlspecialchars($p['location']); ?>" data-id="<?php echo (int)$p['id']; ?>"><i class="bi bi-qr-code-scan me-1"></i>QR</button>
<a href="edit.php?id=<?php echo $p['id']; ?>" class="btn btn-gold btn-sm flex-fill"><i class="bi bi-pencil me-1"></i> Editar</a>
<form method="post" class="d-inline">
<input type="hidden" name="action_toggle_sold" value="1">
<input type="hidden" name="property_id" value="<?php echo (int)$p['id']; ?>">
<input type="hidden" name="qs" value="<?php echo htmlspecialchars(http_build_query($_GET)); ?>">
<button type="submit" class="btn btn-outline-modern btn-sm" title="<?php echo $p['sold'] ? 'Marcar como disponible' : 'Marcar como vendida'; ?>" aria-label="<?php echo $p['sold'] ? 'Marcar como disponible' : 'Marcar como vendida'; ?>" style="<?php echo $p['sold'] ? 'border-color:#bbf7d0;color:#059669;' : 'border-color:#fecaca;color:#dc2626;'; ?>">
<i class="bi <?php echo $p['sold'] ? 'bi-check-circle' : 'bi-x-circle'; ?> me-1"></i><?php echo $p['sold'] ? 'Disponible' : 'Vendido'; ?>
</button>
</form>
<a href="delete.php?id=<?php echo $p['id']; ?>" class="btn btn-outline-modern btn-sm" style="border-color:#fecaca;color:#dc2626;" title="Eliminar propiedad" aria-label="Eliminar propiedad"><i class="bi bi-trash me-1"></i>Eliminar</a>
</div>
</div>
</div>
<?php endforeach; ?>

</div>
<?php endif; ?>

<!-- QR Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content" style="border-radius:var(--radius);overflow:hidden;">
<div class="modal-header" style="border-bottom:1px solid rgba(0,0,0,.04);">
<h5 class="modal-title" id="qrModalLabel" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;"><i class="bi bi-qr-code-scan me-2" style="color:var(--gold);"></i>Código QR</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>
<div class="modal-body text-center p-4">
<div class="mx-auto d-inline-block p-3" style="background:#fff;border:1px solid #e5e7eb;border-radius:var(--radius-sm);">
<canvas id="qrCanvas" width="260" height="260"></canvas>
</div>
<p id="qrTitle" class="fw-semibold mt-3 mb-1" style="font-size:.95rem;"></p>
<p id="qrUrl" class="small text-muted mb-0" style="word-break:break-all;"></p>
</div>
<div class="modal-footer justify-content-center" style="border-top:1px solid rgba(0,0,0,.04);">
<a id="qrDownload" class="btn btn-gold" href="#" download><i class="bi bi-download me-1"></i> Descargar QR</a>
<button type="button" class="btn btn-outline-modern" data-bs-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('qrModal');
    if (!modal) return;
    modal.addEventListener('shown.bs.modal', function(e) {
        var btn = e.relatedTarget;
        if (!btn) return;
        var url = btn.getAttribute('data-url') || '';
        var title = btn.getAttribute('data-title') || '';
        var id = btn.getAttribute('data-id') || '0';
        var canvas = document.getElementById('qrCanvas');
        document.getElementById('qrTitle').textContent = title;
        document.getElementById('qrUrl').textContent = url;
        var dl = document.getElementById('qrDownload');
        dl.setAttribute('href', '#');
        dl.setAttribute('download', 'bardial-qr-prop-' + id + '.png');
        QRCode.toCanvas(canvas, url, {
            width: 260,
            margin: 1,
            errorCorrectionLevel: 'H',
            color: { dark: '#081C27FF', light: '#FFFFFFFF' }
        }, function(err) {
            if (err) { console.error(err); return; }
            dl.setAttribute('href', canvas.toDataURL('image/png'));
        });
    });
});
</script>

<?php include __DIR__ . '/../includes/lona-ui.php'; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
