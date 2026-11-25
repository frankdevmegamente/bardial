<!DOCTYPE html>
<html lang="es">
<head>
<script>
(function () {
  document.documentElement.classList.add('js');
  var theme = 'light';
  try {
    var saved = localStorage.getItem('bardial-theme');
    if (saved === 'dark' || saved === 'light') {
      theme = saved;
    } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      theme = 'dark';
    }
  } catch (e) {}
  document.documentElement.setAttribute('data-theme', theme);
})();
</script>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?php echo $pageTitle ?? 'Bardial Inmobiliaria'; ?></title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&amp;family=Playfair+Display:ital,wght@0,500;1,500&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>

<!-- Design system -->
<link rel="stylesheet" href="assets/css/tokens.css"/>
<link rel="stylesheet" href="assets/css/base.css"/>
<link rel="stylesheet" href="assets/css/components.css"/>

<?php
$pageCss = $pageCss ?? '';
if ($pageCss !== '' && preg_match('/^[a-z0-9-]+$/', $pageCss)) {
    $cssFile = __DIR__ . '/../assets/css/pages/' . $pageCss . '.css';
    if (file_exists($cssFile)) {
        echo '<link rel="stylesheet" href="assets/css/pages/' . htmlspecialchars($pageCss) . '.css"/>' . "\n";
    }
}
?>

<!-- Tailwind Play CDN (config must be set after the CDN script loads) -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="assets/js/tailwind.config.js"></script>
</head>
<body class="antialiased flex flex-col min-h-screen">