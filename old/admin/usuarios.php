<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();

$flash = $_SESSION['flash'] ?? '';
$flashType = $_SESSION['flash_type'] ?? 'success';
unset($_SESSION['flash']);
unset($_SESSION['flash_type']);

// Agregar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action_add'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
        $_SESSION['flash'] = 'Completa usuario y contraseña.';
        $_SESSION['flash_type'] = 'danger';
        header('Location: usuarios.php');
        exit;
    }
    try {
        $check = getDB()->prepare('SELECT COUNT(*) FROM usuarios WHERE username = ?');
        $check->execute([$username]);
        if ((int)$check->fetchColumn() > 0) {
            $_SESSION['flash'] = "El usuario '$username' ya existe.";
            $_SESSION['flash_type'] = 'danger';
        } else {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            getDB()->prepare('INSERT INTO usuarios (username, password) VALUES (?, ?)')->execute([$username, $hash]);
            $_SESSION['flash'] = "Usuario '$username' creado correctamente.";
            $_SESSION['flash_type'] = 'success';
        }
    } catch (PDOException $e) {
        $_SESSION['flash'] = 'Error al crear el usuario.';
        $_SESSION['flash_type'] = 'danger';
    }
    header('Location: usuarios.php');
    exit;
}

// Eliminar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['action_delete'])) {
    $deleteId = (int)($_POST['user_id'] ?? 0);
    $currentUser = $_SESSION['admin_user'] ?? '';
    if ($deleteId <= 0) {
        $_SESSION['flash'] = 'Usuario inválido.';
        $_SESSION['flash_type'] = 'danger';
    } else {
        try {
            $me = getDB()->prepare('SELECT id FROM usuarios WHERE username = ?');
            $me->execute([$currentUser]);
            $myId = (int)$me->fetchColumn();
            if ($deleteId === $myId) {
                $_SESSION['flash'] = 'No puedes eliminarte a ti mismo.';
                $_SESSION['flash_type'] = 'danger';
            } else {
                getDB()->prepare('DELETE FROM usuarios WHERE id = ?')->execute([$deleteId]);
                $_SESSION['flash'] = 'Usuario eliminado correctamente.';
                $_SESSION['flash_type'] = 'success';
            }
        } catch (PDOException $e) {
            $_SESSION['flash'] = 'Error al eliminar el usuario.';
            $_SESSION['flash_type'] = 'danger';
        }
    }
    header('Location: usuarios.php');
    exit;
}

$users = getDB()->query('SELECT id, username, created_at FROM usuarios ORDER BY id ASC')->fetchAll();

$pageTitle = 'Usuarios';
$activePage = 'usuarios';

include __DIR__ . '/includes/header.php';
?>

<?php if ($flash): ?>
<div class="alert alert-dismissible fade show border-0 rounded-3 py-2 small" role="alert" style="background:<?php echo $flashType === 'success' ? '#d1fae5' : '#fef2f2'; ?>;color:<?php echo $flashType === 'success' ? '#065f46' : '#991b1b'; ?>;">
    <i class="bi bi-<?php echo $flashType === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'; ?> me-1"></i>
    <?php echo htmlspecialchars($flash); ?>
    <button type="button" class="btn-close py-2" data-bs-dismiss="alert" style="font-size:.7rem;"></button>
</div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <div>
            <h5 class="mb-0 fw-bold" style="font-family:'Plus Jakarta Sans',sans-serif;">Usuarios del administrador</h5>
            <span class="text-muted small">Accesos para <i>admin/login.php</i></span>
        </div>
        <a href="index.php" class="btn btn-outline-modern btn-sm"><i class="bi bi-arrow-left me-1"></i> Volver al dashboard</a>
    </div>
    <div class="card-body pb-4">
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <form method="post" class="form-card p-3 rounded-3 border">
                    <div class="mb-3">
                        <label class="form-label">Nuevo usuario</label>
                        <input type="text" name="username" class="form-control" placeholder="Ej: usuario2" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres" required>
                    </div>
                    <button type="submit" name="action_add" value="1" class="btn btn-gold w-auto"><i class="bi bi-person-plus me-1"></i> Agregar usuario</button>
                </form>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <span class="badge bg-secondary rounded-pill px-3 py-2 text-uppercase small"><?php echo count($users); ?> usuario(s) registrado(s)</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?php echo (int)$u['id']; ?></td>
                        <td><?php echo htmlspecialchars($u['username']); ?></td>
                        <td><span class="text-muted small"><?php echo htmlspecialchars($u['created_at']); ?></span></td>
                        <td>
                            <?php if (($u['username'] ?? '') !== ($_SESSION['admin_user'] ?? '')): ?>
                                <form method="post" class="d-inline" onsubmit="return confirm('¿Eliminar usuario <?php echo htmlspecialchars($u['username']); ?>?');">
                                    <input type="hidden" name="user_id" value="<?php echo (int)$u['id']; ?>">
                                    <input type="hidden" name="action_delete" value="1">
                                    <button type="submit" class="btn btn-danger-modern btn-sm px-3"><i class="bi bi-trash"></i></button>
                                </form>
                            <?php else: ?>
                                <span class="text-muted small">(tú)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>