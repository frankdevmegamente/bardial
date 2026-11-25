<footer class="bg-primary-container dark:bg-inverse-surface border-t border-outline-variant/20 text-on-primary-container dark:text-inverse-on-surface mt-auto">
<div class="grid grid-cols-1 md:grid-cols-4 gap-gutter px-margin-mobile md:px-margin-desktop py-section-gap max-w-container-max mx-auto">
<div class="md:col-span-1">
<a href="index.php">
        <img src="assets/images/logo-curvas-01.png" alt="Bardial Inmobiliaria" class="h-20 md:h-28 w-auto mb-6">
    </a>
<p class="font-body-md text-body-md text-on-primary-container/80 dark:text-inverse-on-surface/80 mb-6">
        Excelencia en el Mercado Inmobiliario de Lujo.
    </p>
<p class="font-body-md text-body-md text-on-primary-container/80 dark:text-inverse-on-surface/80 text-sm">
        &copy; 2026 Bardial Inmobiliaria. Todos los derechos reservados.
    </p>
</div>
<div class="md:col-span-1">
<h4 class="font-title-lg text-title-lg text-secondary-fixed dark:text-secondary-fixed-dim font-bold mb-2 uppercase tracking-wider">Navegación</h4>
<div class="h-0.5 w-10 bg-secondary-fixed-dim mb-6"></div>
<ul class="space-y-4 font-body-md text-body-md">
<li><a class="text-on-primary-container/80 dark:text-inverse-on-surface/80 hover:text-on-primary dark:hover:text-inverse-on-surface hover:underline transition-all" href="index.php">Inicio</a></li>
<li><a class="text-on-primary-container/80 dark:text-inverse-on-surface/80 hover:text-on-primary dark:hover:text-inverse-on-surface hover:underline transition-all" href="catalogo.php">Catálogo</a></li>
<li><a class="text-on-primary-container/80 dark:text-inverse-on-surface/80 hover:text-on-primary dark:hover:text-inverse-on-surface hover:underline transition-all" href="about.php">Nosotros</a></li>
</ul>
</div>
<div class="md:col-span-1">
<h4 class="font-title-lg text-title-lg text-secondary-fixed dark:text-secondary-fixed-dim font-bold mb-2 uppercase tracking-wider">Legal</h4>
<div class="h-0.5 w-10 bg-secondary-fixed-dim mb-6"></div>
<ul class="space-y-4 font-body-md text-body-md">
<li><a class="text-on-primary-container/80 dark:text-inverse-on-surface/80 hover:text-on-primary dark:hover:text-inverse-on-surface hover:underline transition-all" href="terms.php">Términos de Servicio</a></li>
<li><a class="text-on-primary-container/80 dark:text-inverse-on-surface/80 hover:text-on-primary dark:hover:text-inverse-on-surface hover:underline transition-all" href="privacy.php">Política de Privacidad</a></li>
<li><a class="text-on-primary-container/80 dark:text-inverse-on-surface/80 hover:text-on-primary dark:hover:text-inverse-on-surface hover:underline transition-all" href="cookies.php">Política de Cookies</a></li>
</ul>
</div>
<div class="md:col-span-1">
<h4 class="font-title-lg text-title-lg text-secondary-fixed dark:text-secondary-fixed-dim font-bold mb-2 uppercase tracking-wider">Newsletter</h4>
<div class="h-0.5 w-10 bg-secondary-fixed-dim mb-6"></div>
<p class="text-on-primary-container/80 dark:text-inverse-on-surface/80 font-body-md text-body-md mb-6">Reciba selecciones exclusivas de propiedades en su bandeja de entrada.</p>
<div class="flex flex-col gap-2">
<input class="bg-transparent border-b border-outline-variant/30 text-white p-2 focus:border-secondary-fixed-dim outline-none transition-colors placeholder:text-outline-variant/50" placeholder="Su correo electrónico" type="email"/>
<button class="mt-4 bg-secondary-fixed-dim text-primary-container font-bold py-3 uppercase tracking-widest hover:brightness-110 transition-all">Subscribirse</button>
</div>
</div>
</div>
</footer>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var nav = document.getElementById('mainNav');
    if (nav) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                nav.classList.add('shadow-md');
                nav.classList.replace('py-4', 'py-2');
            } else {
                nav.classList.remove('shadow-md');
                nav.classList.replace('py-2', 'py-4');
            }
        });
    }
    var menuBtn = document.getElementById('mobileMenuBtn');
    if (menuBtn) {
        menuBtn.addEventListener('click', function() {
            var menu = document.getElementById('mobileMenu');
            if (menu) menu.classList.toggle('hidden');
        });
    }
    var darkToggle = document.getElementById('darkModeToggle');
    var darkIcon = document.getElementById('darkModeIcon');
    var mobileDarkToggles = document.querySelectorAll('.dark-toggle-mobile');
    function applyDark(isDark) {
        document.documentElement.classList.toggle('dark', isDark);
        if (darkIcon) darkIcon.textContent = isDark ? 'dark_mode' : 'light_mode';
        mobileDarkToggles.forEach(function(el) {
            el.textContent = isDark ? 'dark_mode' : 'light_mode';
        });
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }
    if (darkToggle && darkIcon) {
        if (localStorage.getItem('theme') === 'dark') applyDark(true);
        darkToggle.addEventListener('click', function() {
            applyDark(!document.documentElement.classList.contains('dark'));
        });
    }
    mobileDarkToggles.forEach(function(el) {
        el.addEventListener('click', function() {
            applyDark(!document.documentElement.classList.contains('dark'));
        });
    });
});
</script>
</body>
</html>
