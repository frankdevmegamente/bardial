<?php
$activePage = $activePage ?? '';
$navItems = [
    ['key' => 'catalogo',   'label' => 'Propiedades',   'href' => 'catalogo.php'],
    ['key' => 'servicios',  'label' => 'Servicios',     'href' => 'index.php#servicios'],
    ['key' => 'nosotros',   'label' => 'Quiénes somos', 'href' => 'about.php'],
    ['key' => 'contacto',   'label' => 'Contacto',      'href' => 'contacto.php'],
];
?>
<header class="absolute top-0 left-0 w-full z-30" aria-label="Cabecera principal">
  <div class="container-bardial h-24 flex items-center justify-between">
    <a href="index.php#inicio" class="flex items-center gap-3" aria-label="Bardial — inicio">
      <svg width="36" height="36" viewBox="0 0 40 40" fill="none" stroke="#b28c48" stroke-width="1.35" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M6 18 L20 7 L34 18"/>
        <path d="M10 17 V32 H30 V17"/>
        <path d="M14 32 V23 H20 V32"/>
        <path d="M24 20 H27"/>
      </svg>
      <span style="font-size:1.15rem; font-weight:600; letter-spacing:.28em; color:var(--color-navy);">BARDIAL</span>
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

    <a href="contacto.php" class="btn-outline-pill hidden lg:inline-flex" aria-label="Agenda una cita">
      Agenda una cita
      <svg class="arrow-rotate" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
    </a>

    <button class="hamburger lg:hidden" id="mobileMenuBtn" type="button"
            aria-label="Abrir menú" aria-expanded="false" aria-controls="mobileMenu">
      <span></span><span></span>
    </button>
  </div>

  <div class="mobile-menu hidden lg:hidden" id="mobileMenu">
    <?php foreach ($navItems as $item): ?>
      <a href="<?php echo $item['href']; ?>"><?php echo $item['label']; ?></a>
    <?php endforeach; ?>
  </div>
</header>
