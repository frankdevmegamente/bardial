<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

$id = (int)($_GET['id'] ?? 0);
$property = getPropertyById($id);

if (!$property) {
    header('Location: index.php');
    exit;
}

if (!empty($_GET['confirm'])) {
    try {
        deleteProperty($id);
        $_SESSION['flash'] = 'Propiedad eliminada correctamente.';
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Error al eliminar: ' . $e->getMessage();
    }
}

$pageTitle = 'Eliminar Propiedad';
$activePage = 'properties';

$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

include __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center">
<div class="col-12 col-md-7 col-lg-5">

<div class="confirm-card border border-danger" style="border-width:2px !important;">
<div class="card-header bg-white text-center py-4" style="border-bottom:1px solid rgba(0,0,0,.04);">
<div class="mx-auto mb-3" style="width:64px;height:64px;border-radius:50%;background:#fef2f2;display:flex;align-items:center;justify-content:center;">
<i class="bi bi-exclamation-triangle fs-3" style="color:#dc2626;"></i>
</div>
<h5 class="mb-1">¿Eliminar propiedad?</h5>
<p class="text-muted small mb-0">Esta acción no se puede deshacer</p>
</div>
<div class="card-body text-center py-4">

<?php if (!empty($error)): ?>
<div class="alert alert-danger border-0 rounded-3 py-2 small" style="background:#fef2f2;color:#991b1b;"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<p class="fw-semibold mb-1" style="font-size:1.05rem;"><?php echo htmlspecialchars($property['location']); ?></p>
<p class="text-muted mb-0"><?php echo htmlspecialchars($property['price']); ?></p>

<div class="d-flex justify-content-center gap-3 mt-4">
<a href="delete.php?id=<?php echo $id; ?>&confirm=1" class="btn btn-danger-modern px-4" title="Confirmar eliminación" aria-label="Confirmar eliminación">
<i class="bi bi-trash me-1"></i> Sí, eliminar
</a>
<a href="index.php" class="btn btn-outline-modern px-4" title="Cancelar" aria-label="Cancelar">
<i class="bi bi-x-lg me-1"></i> Cancelar
</a>
</div>

</div>
</div>

</div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
