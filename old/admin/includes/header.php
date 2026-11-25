<?php
$pageTitle = $pageTitle ?? 'Dashboard';
$activePage = $activePage ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($pageTitle); ?> — Bardial Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root {
    --sidebar-w: 272px;
    --gold: #F8BE26;
    --gold-soft: #fef3d6;
    --navy: #081C27;
    --navy-light: #0d2e3f;
    --surface: #ffffff;
    --bg: #f0f2f5;
    --text: #1a1c1b;
    --text-muted: #6b7280;
    --radius: 16px;
    --radius-sm: 10px;
    --shadow-card: 0 1px 3px rgba(0,0,0,.04), 0 4px 16px rgba(0,0,0,.04);
    --shadow-hover: 0 8px 30px rgba(0,0,0,.08);
    --transition: all .25s cubic-bezier(.4,0,.2,1);
}
* { box-sizing: border-box; }
body {
    font-family: 'Inter', 'Plus Jakarta Sans', system-ui, sans-serif;
    background: var(--bg);
    overflow-x: hidden;
    color: var(--text);
}
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

/* ─── SIDEBAR ─── */
.sidebar {
    position: fixed;
    top: 0; left: 0;
    width: var(--sidebar-w);
    height: 100vh;
    background: linear-gradient(160deg, #0a1e29 0%, #081C27 40%, #0d2e3f 100%);
    color: #fff;
    z-index: 1040;
    display: flex;
    flex-direction: column;
    transition: transform .35s cubic-bezier(.4,0,.2,1);
}
.sidebar::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 0% 100%, rgba(248,190,38,.06) 0%, transparent 60%);
    pointer-events: none;
}
.sidebar-brand {
    padding: 1.5rem 1.5rem 1.25rem;
    border-bottom: 1px solid rgba(255,255,255,.06);
    position: relative;
}
.sidebar-brand a {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.35rem;
    font-weight: 800;
    color: var(--gold);
    text-decoration: none;
    letter-spacing: -.5px;
}
.sidebar-brand small {
    display: block;
    color: rgba(255,255,255,.35);
    font-size: .65rem;
    text-transform: uppercase;
    letter-spacing: 2.5px;
    margin-top: 3px;
    font-weight: 500;
}
.sidebar-nav {
    flex: 1;
    padding: 1rem .75rem;
    overflow-y: auto;
}
.sidebar-nav .nav-section {
    padding: 1rem 1rem .35rem;
    font-size: .6rem;
    text-transform: uppercase;
    letter-spacing: 1.8px;
    color: rgba(255,255,255,.25);
    font-weight: 600;
}
.sidebar-nav .nav-link {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .6rem 1rem;
    color: rgba(255,255,255,.6);
    text-decoration: none;
    border-radius: var(--radius-sm);
    font-size: .85rem;
    font-weight: 500;
    transition: var(--transition);
    position: relative;
}
.sidebar-nav .nav-link i { font-size: 1.1rem; width: 1.25rem; text-align: center; }
.sidebar-nav .nav-link:hover { background: rgba(255,255,255,.07); color: #fff; }
.sidebar-nav .nav-link.active {
    background: linear-gradient(135deg, var(--gold) 0%, #e0a81c 100%);
    color: var(--navy);
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(248,190,38,.3);
}
.sidebar-footer {
    padding: 1rem 1rem 1.5rem;
    border-top: 1px solid rgba(255,255,255,.06);
    position: relative;
}
.sidebar-footer .nav-link {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .55rem 1rem;
    color: rgba(255,255,255,.5);
    text-decoration: none;
    border-radius: var(--radius-sm);
    font-size: .8rem;
    transition: var(--transition);
}
.sidebar-footer .nav-link:hover { background: rgba(255,255,255,.07); color: #fff; }

/* ─── TOPBAR ─── */
.topbar {
    background: rgba(255,255,255,.8);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(0,0,0,.05);
    padding: .75rem 1.75rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 1030;
}
.topbar h1 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--text);
    margin: 0;
}
.topbar-user {
    display: flex;
    align-items: center;
    gap: .75rem;
}
.topbar-user .avatar {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--gold), #e0a81c);
    display: flex; align-items: center; justify-content: center;
    color: var(--navy);
    font-weight: 700;
    font-size: .8rem;
}

/* ─── MAIN ─── */
.main-wrapper {
    margin-left: var(--sidebar-w);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}
.main-content {
    flex: 1;
    padding: 1.75rem;
}

/* ─── STAT CARDS ─── */
.stat-card {
    border: none;
    border-radius: var(--radius);
    box-shadow: var(--shadow-card);
    transition: var(--transition);
    overflow: hidden;
    position: relative;
}
.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 3px;
}
.stat-card:nth-child(1)::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
.stat-card:nth-child(2)::before { background: linear-gradient(90deg, #10b981, #34d399); }
.stat-card:nth-child(3)::before { background: linear-gradient(90deg, #ef4444, #f87171); }
.stat-card:nth-child(4)::before { background: linear-gradient(90deg, var(--gold), #fbbf24); }
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-hover);
}
.stat-card .icon-wrap {
    width: 48px; height: 48px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem;
}
.stat-card .stat-value {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.65rem;
    font-weight: 800;
    line-height: 1.2;
    color: var(--text);
}
.stat-card .stat-label {
    font-size: .78rem;
    color: var(--text-muted);
    font-weight: 500;
}

/* ─── TABLE ─── */
.table-card {
    border: none;
    border-radius: var(--radius);
    box-shadow: var(--shadow-card);
    overflow: hidden;
}
.table-card .card-header {
    background: var(--surface);
    border-bottom: 1px solid rgba(0,0,0,.04);
    padding: 1rem 1.5rem;
}
.table-card .card-header h5 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: .95rem;
}
.table-card .table { margin: 0; }
.table-card .table thead th {
    background: #f8fafc;
    font-size: .72rem;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: var(--text-muted);
    font-weight: 600;
    padding: .75rem 1rem;
    border-bottom: 1px solid #e9ecef;
}
.table-card .table tbody td {
    padding: .85rem 1rem;
    font-size: .85rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f5;
}
.table-card .table tbody tr:last-child td { border-bottom: none; }
.table-card .table tbody tr:hover { background: #fafbfc; }

/* ─── FORM CARD ─── */
.form-card {
    border: none;
    border-radius: var(--radius);
    box-shadow: var(--shadow-card);
    overflow: hidden;
}
.form-card .card-header {
    background: var(--surface);
    border-bottom: 1px solid rgba(0,0,0,.04);
    padding: 1rem 1.5rem;
}
.form-card .card-header h5 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: .95rem;
}
.form-card .form-control, .form-card .form-select {
    border-radius: var(--radius-sm);
    border: 1.5px solid #e5e7eb;
    padding: .6rem .85rem;
    font-size: .875rem;
    transition: var(--transition);
}
.form-card .form-control:focus, .form-card .form-select:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(248,190,38,.15);
}
.form-card .form-label {
    font-size: .78rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: .35rem;
}
.form-check-input:checked { background-color: var(--gold); border-color: var(--gold); }

/* ─── BUTTONS ─── */
.btn-gold {
    background: linear-gradient(135deg, var(--gold) 0%, #e0a81c 100%);
    color: var(--navy);
    font-weight: 600;
    border: none;
    border-radius: var(--radius-sm);
    padding: .55rem 1.5rem;
    font-size: .85rem;
    transition: var(--transition);
}
.btn-gold:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(248,190,38,.35); color: var(--navy); }
.btn-navy {
    background: var(--navy);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: var(--radius-sm);
    transition: var(--transition);
}
.btn-navy:hover { background: var(--navy-light); color: #fff; transform: translateY(-1px); }
.btn-outline-modern {
    border: 1.5px solid #e5e7eb;
    color: var(--text-muted);
    border-radius: var(--radius-sm);
    font-weight: 500;
    padding: .55rem 1.25rem;
    font-size: .85rem;
    transition: var(--transition);
    background: transparent;
}
.btn-outline-modern:hover { border-color: #d1d5db; background: #f9fafb; color: var(--text); }
.btn-danger-modern {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: var(--radius-sm);
    transition: var(--transition);
}
.btn-danger-modern:hover { transform: translateY(-1px); box-shadow: 0 4px 14px rgba(239,68,68,.3); color: #fff; }

/* ─── BADGES ─── */
.badge-gold { background: var(--gold-soft); color: #92400e; font-weight: 500; }
.badge-success-soft { background: #d1fae5; color: #065f46; font-weight: 500; }
.badge-danger-soft { background: #fce4ec; color: #b91c1c; font-weight: 500; }

/* ─── ALERTS ─── */
.alert-modern {
    border: none;
    border-radius: var(--radius-sm);
    font-size: .85rem;
}

/* ─── TOGGLE ─── */
.sidebar-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.35rem;
    color: var(--text-muted);
    cursor: pointer;
    padding: .25rem;
    line-height: 1;
}
.overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.4);
    backdrop-filter: blur(4px);
    z-index: 1039;
}

/* ─── RESPONSIVE ─── */
@media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); }
    .sidebar.open { transform: translateX(0); }
    .overlay.open { display: block; }
    .main-wrapper { margin-left: 0; }
    .sidebar-toggle { display: inline-block; }
    .main-content { padding: 1rem; }
}

/* ─── CONFIRM CARD ─── */
.confirm-card {
    border: none;
    border-radius: var(--radius);
    box-shadow: var(--shadow-card);
    overflow: hidden;
}
.confirm-card .card-header {
    padding: 1.25rem 1.5rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
}
</style>
</head>
<body>

<!-- Overlay -->
<div class="overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
<div class="sidebar-brand">
<a href="index.php">Bardial</a>
<small>Panel de Administración</small>
</div>
<nav class="sidebar-nav">
<div class="nav-section">Navegación</div>
<div class="nav-item">
<a class="nav-link <?php echo $activePage === 'dashboard' ? 'active' : ''; ?>" href="index.php">
<i class="bi bi-grid-1x2-fill"></i> Dashboard
</a>
</div>
<div class="nav-item">
<a class="nav-link <?php echo $activePage === 'properties' ? 'active' : ''; ?>" href="properties.php">
<i class="bi bi-building-fill"></i> Propiedades
</a>
</div>
<div class="nav-section">Gestión</div>
<div class="nav-item">
<a class="nav-link <?php echo $activePage === 'create' ? 'active' : ''; ?>" href="create.php">
<i class="bi bi-plus-circle-fill"></i> Añadir Propiedad
</a>
</div>
<div class="nav-item">
<a class="nav-link <?php echo $activePage === 'usuarios' ? 'active' : ''; ?>" href="usuarios.php">
<i class="bi bi-people-fill"></i> Usuarios
</a>
</div>
</nav>
<div class="sidebar-footer">
<a class="nav-link" href="../index.php" target="_blank">
<i class="bi bi-box-arrow-up-right"></i> Ver sitio web
</a>
<a class="nav-link" href="logout.php">
<i class="bi bi-box-arrow-left"></i> Cerrar sesión
</a>
</div>
</aside>

<!-- Main -->
<div class="main-wrapper">
<header class="topbar">
<div class="d-flex align-items-center gap-3">
<button class="sidebar-toggle" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
<h1><?php echo htmlspecialchars($pageTitle ?? 'Dashboard'); ?></h1>
</div>
<div class="topbar-user">
<span class="d-none d-md-inline text-muted small fw-medium"><?php echo htmlspecialchars($_SESSION['admin_user'] ?? 'Admin'); ?></span>
<div class="avatar"><?php echo strtoupper(($_SESSION['admin_user'] ?? 'A')[0]); ?></div>
<a href="logout.php" class="btn btn-outline-modern btn-sm px-3 d-none d-md-inline-flex">
<i class="bi bi-box-arrow-right me-1"></i> Salir
</a>
</div>
</header>

<div class="main-content">
