<?php
require_once __DIR__ . '/../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($username === '' || $password === '') {
        $error = 'Completa todos los campos.';
    } else {
        try {
            $stmt = getDB()->prepare('SELECT * FROM usuarios WHERE username = ?');
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user'] = $user['username'];
                header('Location: index.php');
                exit;
            } else {
                $error = 'Usuario o contraseña incorrectos.';
            }
        } catch (PDOException $e) {
            $error = 'Error de conexión a la base de datos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar Sesión — Bardial Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
<style>
:root { --gold: #F8BE26; --navy: #081C27; }
* { box-sizing: border-box; }
body {
    font-family: 'Inter', system-ui, sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f0f2f5 0%, #e5e7eb 100%);
    padding: 1rem;
}
.login-wrap {
    width: 100%;
    max-width: 420px;
    position: relative;
}
.login-card {
    background: rgba(255,255,255,.85);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,.5);
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0,0,0,.08), 0 8px 20px rgba(0,0,0,.04);
    padding: 2.5rem 2rem;
}
.login-brand {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--navy);
    text-decoration: none;
}
.login-brand span { color: var(--gold); }
.login-sub {
    color: #9ca3af;
    font-size: .8rem;
    font-weight: 500;
    letter-spacing: .5px;
    text-transform: uppercase;
    margin-top: .25rem;
}
.form-control {
    border-radius: 12px;
    border: 1.5px solid #e5e7eb;
    padding: .7rem 1rem;
    font-size: .9rem;
    transition: all .2s;
}
.form-control:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(248,190,38,.15);
}
.input-group-text {
    border-radius: 12px 0 0 12px;
    border: 1.5px solid #e5e7eb;
    background: #f9fafb;
    color: #9ca3af;
}
.input-group .form-control { border-radius: 0 12px 12px 0; }
.btn-login {
    background: linear-gradient(135deg, var(--gold) 0%, #e0a81c 100%);
    color: var(--navy);
    font-weight: 700;
    border: none;
    border-radius: 12px;
    padding: .75rem;
    font-size: .9rem;
    transition: all .25s;
}
.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(248,190,38,.35);
    color: var(--navy);
}
</style>
</head>
<body>
<div class="login-wrap">
<div class="login-card">
<div class="text-center mb-4">
<a href="../index.php" class="login-brand">Bardial<span>.</span></a>
<p class="login-sub">Panel de Administración</p>
</div>

<?php if ($error): ?>
<div class="alert alert-danger py-2 small border-0 rounded-3" style="background:#fef2f2;color:#991b1b;">
<i class="bi bi-exclamation-circle me-1"></i> <?php echo htmlspecialchars($error); ?>
</div>
<?php endif; ?>

<form method="post">
<div class="mb-3">
<label class="form-label small fw-semibold" for="username">Usuario</label>
<div class="input-group">
<span class="input-group-text"><i class="bi bi-person"></i></span>
<input class="form-control" id="username" name="username" type="text" required autocomplete="username" placeholder="admin">
</div>
</div>
<div class="mb-4">
<label class="form-label small fw-semibold" for="password">Contraseña</label>
<div class="input-group">
<span class="input-group-text"><i class="bi bi-lock"></i></span>
<input class="form-control" id="password" name="password" type="password" required autocomplete="current-password" placeholder="••••••">
</div>
</div>
<button class="btn btn-login w-100" type="submit">
<i class="bi bi-arrow-right-circle me-2"></i> Entrar
</button>
</form>

<div class="text-center mt-4">
<a class="small text-decoration-none text-muted" href="../index.php">
<i class="bi bi-arrow-left me-1"></i> Volver al sitio
</a>
</div>
</div>
</div>
</body>
</html>
