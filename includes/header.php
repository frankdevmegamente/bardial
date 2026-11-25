<?php
$activePage = $activePage ?? '';
$navItems = [
    ['key' => 'catalogo',   'label' => 'Propiedades',   'href' => 'catalogo.php'],
    ['key' => 'servicios',  'label' => 'Servicios',     'href' => 'index.php#servicios'],
    ['key' => 'nosotros',   'label' => 'Quiénes somos', 'href' => 'about.php'],
    ['key' => 'contacto',   'label' => 'Contacto',      'href' => 'contacto.php'],
];
?>
<header class="site-header fixed top-0 left-0 w-full z-30" aria-label="Cabecera principal">
  <div class="container-bardial h-24 flex items-center justify-between">
    <a href="index.php#inicio" class="flex items-center" aria-label="Bardial — inicio">
      <img class="site-logo site-logo--light" src="assets/images/logo.png" alt="Bardial"/>
      <img class="site-logo site-logo--dark" src="assets/images/logo-curvas-01.png" alt="Bardial"/>
    </a>

    <nav class="hidden lg:flex items-center gap-9" aria-label="Navegación principal">
      <?php foreach ($navItems as $item): ?>
        <a href="<?php echo $item['href']; ?>"
           class="nav-link <?php echo $activePage === $item['key'] ? 'text-[var(--color-gold-text)]' : ''; ?>"
           <?php echo $activePage === $item['key'] ? 'aria-current="page"' : ''; ?>>
          <?php echo $item['label']; ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="flex items-center gap-4">
      <button class="theme-toggle" id="themeToggle" type="button" aria-label="Activar modo oscuro" aria-pressed="false" title="Cambiar tema">
        <svg class="theme-icon theme-icon--sun" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
          <circle cx="12" cy="12" r="4"/>
          <path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/>
        </svg>
        <svg class="theme-icon theme-icon--moon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <path d="M20 14.5A8.5 8.5 0 0 1 9.5 4 8.5 8.5 0 1 0 20 14.5z"/>
        </svg>
      </button>

      <a href="contacto.php" class="btn-outline-pill hidden lg:inline-flex" aria-label="Agenda una cita">
        Agenda una cita
        <svg class="arrow-rotate" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
      </a>

      <button class="hamburger lg:hidden" id="mobileMenuBtn" type="button"
              aria-label="Abrir menú" aria-expanded="false" aria-controls="mobileMenu">
        <span></span><span></span>
      </button>
    </div>
  </div>

  <div class="mobile-menu hidden lg:hidden" id="mobileMenu">
    <?php foreach ($navItems as $item): ?>
      <a href="<?php echo $item['href']; ?>"><?php echo $item['label']; ?></a>
    <?php endforeach; ?>
  </div>
</header>
