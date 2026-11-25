<?php
$activePage = $activePage ?? '';
$navItems = [
    'inicio'    => ['label' => 'Inicio',   'href' => 'index.php'],
    'catalogo'  => ['label' => 'Catálogo', 'href' => 'catalogo.php'],
    'nosotros'  => ['label' => 'Nosotros', 'href' => 'about.php'],
];
?>
<nav class="bg-surface dark:bg-inverse-surface text-primary dark:text-inverse-primary border-b border-outline-variant/30 dark:border-outline-variant/10 sticky top-0 z-50 transition-all duration-300" id="mainNav">
<div class="flex justify-between items-center w-full px-margin-mobile md:px-margin-desktop py-4 max-w-[1800px] mx-auto">
<a class="flex-shrink-0 hover:opacity-80 transition-opacity" href="index.php">
        <img src="assets/images/logo.png" alt="Bardial Inmobiliaria" class="h-14 md:h-20 w-auto dark:hidden">
        <img src="assets/images/logo-curvas-01.png" alt="Bardial Inmobiliaria" class="h-14 md:h-20 w-auto hidden dark:block">
    </a>
<div class="hidden md:flex items-center space-x-8">
<?php foreach ($navItems as $key => $item): ?>
<a class="<?php echo $activePage === $key ? 'text-primary dark:text-secondary-fixed-dim border-b-2 border-secondary-fixed-dim pb-1 font-bold' : 'text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-on-surface transition-colors'; ?> font-label-md text-label-md uppercase tracking-wider py-2 hover:bg-surface-container-low dark:hover:bg-surface-container-highest transition-all duration-300" href="<?php echo $item['href']; ?>"><?php echo $item['label']; ?></a>
<?php endforeach; ?>
</div>
<div class="flex items-center space-x-6 flex-shrink-0">
<div class="hidden md:flex items-center space-x-4">
<div class="relative flex items-center" id="searchContainer">
<input class="w-0 opacity-0 transition-all duration-300 ease-in-out bg-transparent border-0 border-b border-outline-variant dark:border-surface-variant py-1 font-body-md text-on-surface-variant dark:text-surface-variant focus:ring-0 focus:border-secondary-fixed-dim placeholder:text-on-surface-variant/50" id="searchInput" placeholder="Buscar propiedades..." type="text"/>
<button aria-label="search" class="text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low dark:hover:bg-surface-container-highest rounded-full p-2" id="searchToggle">
<span class="material-symbols-outlined" data-icon="search" id="searchIcon">search</span>
</button>
</div>
<button aria-label="Toggle dark mode" class="text-on-surface-variant hover:text-primary transition-colors hover:bg-surface-container-low dark:hover:bg-surface-container-highest rounded-full p-2" id="darkModeToggle">
<span class="material-symbols-outlined" id="darkModeIcon" data-icon="light_mode">light_mode</span>
</button>
</div>
<a class="bg-secondary-fixed-dim text-primary-container font-bold font-label-md text-label-md uppercase tracking-wider py-3 px-6 hover:brightness-110 transition-all rounded-none flex items-center justify-center" href="contacto.php">
        Contacto
    </a>
<button class="md:hidden text-primary p-2" id="mobileMenuBtn">
<span class="material-symbols-outlined" data-icon="menu">menu</span>
</button>
</div>
</div>
<div class="md:hidden hidden bg-surface border-t border-outline-variant/30" id="mobileMenu">
<div class="flex flex-col px-margin-mobile py-4 space-y-4">
<?php foreach ($navItems as $key => $item): ?>
<a class="<?php echo $activePage === $key ? 'text-secondary-fixed-dim font-bold border-l-2 border-secondary-fixed-dim pl-3' : 'text-on-surface-variant'; ?> font-label-md text-label-md uppercase tracking-wider py-2" href="<?php echo $item['href']; ?>"><?php echo $item['label']; ?></a>
<?php endforeach; ?>
<div class="flex space-x-4 pt-4 border-t border-outline-variant/30">
<a class="text-on-surface-variant" href="catalogo.php"><span class="material-symbols-outlined">search</span></a>
<button class="text-on-surface-variant dark-toggle-mobile"><span class="material-symbols-outlined">light_mode</span></button>
</div>
</div>
</div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchToggle = document.getElementById('searchToggle');
    var searchInput = document.getElementById('searchInput');
    var searchIcon = document.getElementById('searchIcon');
    var searchContainer = document.getElementById('searchContainer');
    if (searchToggle && searchInput && searchIcon) {
        searchToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            if (searchInput.classList.contains('w-0')) {
                searchInput.classList.remove('w-0', 'opacity-0', 'mr-0');
                searchInput.classList.add('w-48', 'opacity-100', 'mr-3');
                searchInput.focus();
                searchIcon.textContent = 'close';
            } else if (searchInput.value.trim()) {
                window.location.href = 'catalogo.php?search=' + encodeURIComponent(searchInput.value.trim());
            } else {
                searchInput.classList.add('w-0', 'opacity-0', 'mr-0');
                searchInput.classList.remove('w-48', 'opacity-100', 'mr-3');
                searchIcon.textContent = 'search';
            }
        });
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && searchInput.value.trim()) {
                window.location.href = 'catalogo.php?search=' + encodeURIComponent(searchInput.value.trim());
            }
            if (e.key === 'Escape') {
                searchInput.classList.add('w-0', 'opacity-0', 'mr-0');
                searchInput.classList.remove('w-48', 'opacity-100', 'mr-3');
                searchIcon.textContent = 'search';
                searchInput.blur();
            }
        });
        document.addEventListener('click', function(e) {
            if (searchContainer && !searchContainer.contains(e.target) && !searchInput.classList.contains('w-0')) {
                searchInput.classList.add('w-0', 'opacity-0', 'mr-0');
                searchInput.classList.remove('w-48', 'opacity-100', 'mr-3');
                searchIcon.textContent = 'search';
            }
        });
    }
});
</script>
