<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

$properties = getAllProperties();

$search = trim($_GET['search'] ?? '');
if ($search !== '') {
    $properties = array_filter($properties, fn($p) => stripos($p['location'], $search) !== false);
}
$filtered = count($properties);
$totalAll = count(getAllProperties());

$pageTitle = 'Lonas para impresión';
$activePage = 'lonas';

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

<div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-3">
<div>
<h2 class="fw-bold mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.4rem;">Lonas para impresión</h2>
<p class="text-muted small mb-0"><?php echo $filtered; ?> de <?php echo $totalAll; ?> propiedad(es)</p>
</div>
<a href="properties.php" class="btn btn-outline-modern btn-sm" title="Ver propiedades" aria-label="Ver propiedades"><i class="bi bi-building me-1"></i> Ver propiedades</a>
</div>

<form method="get" class="d-flex flex-wrap align-items-end gap-3 mb-4 p-3 bg-white rounded-3" style="box-shadow:var(--shadow-card);">
<div class="flex-grow-1" style="min-width:180px;">
<label class="form-label small fw-semibold text-muted mb-1" for="search">Buscar ubicación</label>
<div class="input-group input-group-sm">
<span class="input-group-text border-0" style="background:#f8fafc;"><i class="bi bi-search text-muted"></i></span>
<input class="form-control form-control-sm border-0" style="background:#f8fafc;" id="search" name="search" type="text" value="<?php echo htmlspecialchars($search); ?>" placeholder="Polanco, Los Cabos...">
</div>
</div>
<div class="d-flex gap-2">
<button class="btn btn-gold btn-sm px-3" type="submit" title="Filtrar" aria-label="Filtrar"><i class="bi bi-funnel me-1"></i> Filtrar</button>
<a href="lonas.php" class="btn btn-outline-modern btn-sm px-3" title="Limpiar filtros" aria-label="Limpiar filtros"><i class="bi bi-x me-1"></i> Limpiar</a>
</div>
</form>

<?php if (empty($properties)): ?>
<div class="text-center py-5">
<div class="mb-3"><i class="bi bi-search fs-1 text-muted"></i></div>
<p class="text-muted mb-2">No se encontraron propiedades.</p>
<a href="lonas.php" class="btn btn-outline-modern btn-sm">Limpiar filtros</a>
</div>
<?php else: ?>
<div class="card table-card">
<div class="card-body p-0">
<div class="table-responsive">
<table class="table mb-0">
<thead>
<tr>
<th>Propiedad</th>
<th>Precio</th>
<th>Estado</th>
<th class="text-end">Lona</th>
</tr>
</thead>
<tbody>
<?php foreach ($properties as $p): ?>
<tr>
<td>
<div class="d-flex align-items-center gap-2">
<?php if ($p['img']): ?>
<img src="<?php echo strpos($p['img'], 'uploads/') === 0 ? '/bardial/' . $p['img'] : htmlspecialchars($p['img']); ?>" alt="" style="width:48px;height:36px;object-fit:cover;border-radius:6px;">
<?php endif; ?>
<div>
<div class="fw-medium"><?php echo htmlspecialchars($p['location']); ?></div>
<?php if (!empty($p['type'])): ?>
<div class="small text-muted"><?php echo htmlspecialchars($p['type']); ?></div>
<?php endif; ?>
</div>
</div>
</td>
<td class="fw-semibold"><?php echo htmlspecialchars($p['price']); ?></td>
<td>
<?php if ($p['sold']): ?>
<span class="badge badge-danger-soft rounded-pill">Vendido</span>
<?php else: ?>
<span class="badge badge-success-soft rounded-pill">Disponible</span>
<?php endif; ?>
</td>
<td class="text-end">
<button type="button" class="btn btn-gold btn-sm" title="Generar lona para impresión" aria-label="Generar lona para impresión" data-bs-toggle="modal" data-bs-target="#lonaModal" data-id="<?php echo (int)$p['id']; ?>"><i class="bi bi-aspect-ratio me-1"></i> Generar lona</button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/../includes/lona-ui.php'; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>
