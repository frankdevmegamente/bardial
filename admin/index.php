<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

$properties = getAllProperties();
$total = count($properties);
$sold = count(array_filter($properties, fn($p) => !empty($p['sold'])));
$available = $total - $sold;
$recent = array_slice($properties, -3);

$prices = array_map(fn($p) => (float)($p['price_value'] ?? 0), $properties);
$avgPrice = $prices ? array_sum($prices) / count($prices) : 0;

$pageTitle = 'Dashboard';
$activePage = 'dashboard';

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

<!-- Welcome -->
<div class="d-flex align-items-start justify-content-between flex-wrap gap-3 mb-4">
<div>
<h2 class="fw-bold mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.4rem;">Bienvenido</h2>
<p class="text-muted small mb-0">Resumen general del portafolio de propiedades</p>
</div>
<a href="create.php" class="btn btn-gold btn-sm px-4" title="Añadir propiedad" aria-label="Añadir propiedad"><i class="bi bi-plus-lg me-1"></i> Añadir propiedad</a>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">

<div class="col-6 col-xl-3">
<div class="card stat-card">
<div class="card-body p-4">
<div class="d-flex align-items-start gap-3">
<div class="icon-wrap" style="background:#eff6ff;"><i class="bi bi-building" style="color:#2563eb;"></i></div>
<div class="flex-grow-1 min-w-0">
<div class="stat-value"><?php echo $total; ?></div>
<div class="stat-label">Total propiedades</div>
</div>
</div>
</div>
</div>
</div>

<div class="col-6 col-xl-3">
<div class="card stat-card">
<div class="card-body p-4">
<div class="d-flex align-items-start gap-3">
<div class="icon-wrap" style="background:#ecfdf5;"><i class="bi bi-check-circle" style="color:#059669;"></i></div>
<div class="flex-grow-1 min-w-0">
<div class="stat-value"><?php echo $available; ?></div>
<div class="stat-label">Disponibles</div>
</div>
</div>
</div>
</div>
</div>

<div class="col-6 col-xl-3">
<div class="card stat-card">
<div class="card-body p-4">
<div class="d-flex align-items-start gap-3">
<div class="icon-wrap" style="background:#fef2f2;"><i class="bi bi-x-circle" style="color:#dc2626;"></i></div>
<div class="flex-grow-1 min-w-0">
<div class="stat-value"><?php echo $sold; ?></div>
<div class="stat-label">Vendidas</div>
</div>
</div>
</div>
</div>
</div>

</div>

<!-- Bottom row: Recent + Quick info -->
<div class="row g-4">

<!-- Recent properties -->
<div class="col-12 col-xl-8">
<div class="card table-card h-100">
<div class="card-header d-flex align-items-center justify-content-between">
<h5 class="mb-0"><i class="bi bi-clock-history me-2" style="color:var(--gold);"></i>Últimas propiedades añadidas</h5>
<a href="properties.php" class="btn btn-outline-modern btn-sm" title="Ver todas las propiedades" aria-label="Ver todas las propiedades"><i class="bi bi-list-ul me-1"></i> Ver todas</a>
</div>
<div class="card-body p-0">
<?php if (empty($recent)): ?>
<div class="text-center py-5 text-muted small">No hay propiedades registradas.</div>
<?php else: ?>
<div class="table-responsive">
<table class="table mb-0">
<thead>
<tr>
<th>Ubicación</th>
<th class="text-center">Precio</th>
<th class="text-center">Estado</th>
<th class="text-end">Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach ($recent as $p): ?>
<tr>
<td class="fw-medium"><?php echo htmlspecialchars($p['location']); ?></td>
<td class="text-center fw-semibold"><?php echo htmlspecialchars($p['price']); ?></td>
<td class="text-center">
<?php if ($p['sold']): ?>
<span class="badge badge-danger-soft rounded-pill">Vendido</span>
<?php else: ?>
<span class="badge badge-success-soft rounded-pill">Disponible</span>
<?php endif; ?>
</td>
<td class="text-end">
<a href="edit.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-outline-modern" title="Editar"><i class="bi bi-pencil"></i></a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php endif; ?>
</div>
</div>
</div>

<!-- Quick info -->
<div class="col-12 col-xl-4">
<div class="card table-card h-100">
<div class="card-header">
<h5 class="mb-0"><i class="bi bi-info-circle me-2" style="color:var(--gold);"></i>Resumen rápido</h5>
</div>
<div class="card-body">
<div class="d-flex flex-column gap-3">
<div class="d-flex justify-content-between align-items-center pb-3" style="border-bottom:1px solid #f1f3f5;">
<span class="text-muted small">Precio promedio</span>
<span class="fw-bold"><?php echo number_format($avgPrice, 0, ',', '.'); ?> MXN</span>
</div>
<div class="d-flex justify-content-between align-items-center pb-3" style="border-bottom:1px solid #f1f3f5;">
<span class="text-muted small">Tasa de disponibilidad</span>
<span class="fw-bold"><?php echo $total > 0 ? round(($available / $total) * 100) : 0; ?>%</span>
</div>

</div>
</div>
<div class="card-footer bg-white border-0 pt-0 pb-3 px-3">
<a href="properties.php" class="btn btn-gold w-100 btn-sm" title="Gestionar propiedades" aria-label="Gestionar propiedades"><i class="bi bi-building me-1"></i> Gestionar propiedades</a>
</div>
</div>
</div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
