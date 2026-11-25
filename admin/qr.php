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

$pageTitle = 'Códigos QR';
$activePage = 'qr';

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
<h2 class="fw-bold mb-1" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:1.4rem;">Códigos QR</h2>
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
<a href="qr.php" class="btn btn-outline-modern btn-sm px-3" title="Limpiar filtros" aria-label="Limpiar filtros"><i class="bi bi-x me-1"></i> Limpiar</a>
</div>
</form>

<?php if (empty($properties)): ?>
<div class="text-center py-5">
<div class="mb-3"><i class="bi bi-search fs-1 text-muted"></i></div>
<p class="text-muted mb-2">No se encontraron propiedades.</p>
<a href="qr.php" class="btn btn-outline-modern btn-sm">Limpiar filtros</a>
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
<th class="text-end">QR</th>
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
<button type="button" class="btn btn-gold btn-sm" title="Ver código QR" aria-label="Ver código QR" data-bs-toggle="modal" data-bs-target="#qrModal" data-url="<?php echo htmlspecialchars(propertyAbsoluteUrl((int)$p['id'])); ?>" data-title="<?php echo htmlspecialchars($p['location']); ?>" data-id="<?php echo (int)$p['id']; ?>"><i class="bi bi-qr-code-scan me-1"></i> Ver QR</button>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</div>
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

<?php include __DIR__ . '/includes/footer.php'; ?>
