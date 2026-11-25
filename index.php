<?php $pageTitle = 'Bardial Inmobiliaria | Inmobiliaria de Lujo'; $activePage = 'inicio'; ?>
<?php include 'includes/properties.php'; ?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>

<header class="relative min-h-[860px] flex items-center justify-center overflow-hidden">
<div class="absolute inset-0 bg-cover bg-center transition-transform duration-10000 hover:scale-105" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAcuEmQr_y-ozA7UM0ZlH2k8on6zkYLIu6MHHGEthikgE3sjeqkfQ5WObKc6Bj3KZZZ7Nh88cYl9g_S1a_Nw9SOCdHDnXse2afexQZEYncFM5E5BgXcIi1kxIV09VU9DhYPACKEYGX9yTUYhq6MQN3fPQvyf-GYVvOi5jPZVFPDzgGMkPmnJaBawcnsv-nPO8UIUtZyWsrgslLGHJApweunbFQUbdWZqC-pxe5uFRU-67PrgHtPYFw1VsKSb1cQDy8YO0Yx2OOxvhLJ')">
</div>
<div class="absolute inset-0 hero-gradient" style="background: linear-gradient(to bottom, rgba(8, 28, 39, 0.4), rgba(8, 28, 39, 0.8));"></div>
<div class="relative z-10 w-full max-w-[1800px] px-margin-mobile md:px-margin-desktop text-center text-white">
<h1 class="font-display-lg text-display-lg md:text-[80px] leading-tight mb-6 max-w-4xl mx-auto">Vida Exquisita, Definida por la Excelencia.</h1>
<p class="font-body-lg text-body-lg opacity-90 tracking-wide">Descubra las propiedades más prestigiosas del mercado con Bardial Inmobiliaria.</p>
</div>
<a href="#coleccion" class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 opacity-50 hover:opacity-100 transition-opacity">
<span class="text-[10px] uppercase font-bold text-white tracking-[0.3em]">Explorar</span>
<span class="material-symbols-outlined text-white">expand_more</span>
</a>
</header>

<section id="coleccion" class="py-section-gap max-w-[1800px] mx-auto px-margin-mobile md:px-margin-desktop">
<div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
<div class="max-w-2xl">
<span class="text-secondary-fixed-dim font-label-md text-label-md uppercase tracking-[0.2em] mb-4 block">Nuestra Colección</span>
<h2 class="font-headline-lg text-headline-lg text-brand-navy dark:text-surface-variant">Propiedades Destacadas</h2>
<div class="h-1 w-24 bg-secondary-fixed-dim mt-6"></div>
</div>
<a class="text-brand-navy dark:text-secondary-fixed-dim font-label-md text-label-md flex items-center gap-2 group " href="catalogo.php">Ver todo el catálogo <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span></a>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
<?php $destacadas = array_slice($properties, 0, 3); ?>
<?php foreach ($destacadas as $p): ?>
<a href="detalles.php?id=<?php echo $p['id']; ?>" class="luxury-card group bg-surface border border-outline-variant/15 transition-all duration-500 hover:shadow-2xl hover:border-secondary-fixed-dim">
<div class="relative overflow-hidden aspect-[4/5]">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="<?php echo htmlspecialchars($p['img']); ?>" alt="<?php echo htmlspecialchars($p['location']); ?>"/>

</div>
<div class="p-8">
<p class="text-brand-navy dark:text-surface-variant font-display-lg text-headline-md mb-2"><?php echo htmlspecialchars($p['price']); ?></p>
<p class="text-on-surface-variant dark:text-surface-variant font-label-md text-label-md uppercase tracking-widest mb-1"><?php echo htmlspecialchars($p['location']); ?></p>
<?php if (!empty($p['type'])): ?>
<p class="text-secondary-fixed-dim font-label-md text-label-md mb-4"><?php echo htmlspecialchars($p['type']); ?></p>
<?php endif; ?>
<div class="flex gap-6 border-t border-outline-variant/30 pt-6 text-on-surface-variant dark:text-surface-variant">
<div class="flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">bed</span><span class="font-label-md text-[14px]"><?php echo (int)$p['bed']; ?> Dorm</span></div>
<div class="flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">bathtub</span><span class="font-label-md text-[14px]"><?php echo (int)$p['bath']; ?> Baños</span></div>
<div class="flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">square_foot</span><span class="font-label-md text-[14px]"><?php echo (int)$p['sqm']; ?> m²</span></div>
</div>
</div>
</a>
<?php endforeach; ?>
</div>
</section>

<section class="bg-brand-navy text-on-primary py-section-gap">
<div class="max-w-[1800px] mx-auto px-margin-mobile md:px-margin-desktop grid grid-cols-1 lg:grid-cols-2 gap-24 items-center">
<div class="relative order-2 lg:order-1">
<div class="absolute -top-6 -left-6 w-32 h-32 border-t-4 border-l-4 border-secondary-fixed-dim opacity-50"></div>
<img class="w-full h-[600px] object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDg4pXFKtTyukpgDS4iaK183Rr9_wkg4OLtuh5r6gQLPJAaEAzdbrILLfhsu_6QUQiXKUWUZ52_HRqZ-2eLqoofawFErXcy45AhFokZTQ2ZjoL2HwgFrbyhfzD_RTvn32JM80_UoYUJh6w2pyVxYea7t9RMh-KJ43d6G5bIeTgCwUutH3DTgVx-iSg2JUOR2-5kYQ48WwitriARWx7qer5NhAU2LkMIByydM1UILI9EPRieO7NLhfCQv6-udxftBC9fyk0SvdQeeRzY"/>
<div class="absolute -bottom-10 -right-10 bg-secondary-fixed-dim p-12 hidden md:block">
<p class="text-brand-navy font-display-lg text-headline-lg">25+</p>
<p class="text-brand-navy font-label-md text-label-md uppercase font-bold tracking-widest">Años de Historia</p>
</div>
</div>
<div class="order-1 lg:order-2">
<span class="text-secondary-fixed-dim font-label-md text-label-md uppercase tracking-[0.2em] mb-4 block">Sobre Nosotros</span>
<h2 class="font-display-lg text-display-lg md:text-headline-lg mb-8 leading-tight">Por qué elegirnos</h2>
<p class="font-body-lg text-body-lg mb-12 opacity-80 leading-relaxed">En Bardial Inmobiliaria, no solo vendemos propiedades; curamos estilos de vida. Nuestra trayectoria se define por una discreción absoluta y una búsqueda incansable de la excelencia arquitectónica para nuestros clientes más exigentes.</p>
<div class="space-y-10">
<div class="flex gap-6 items-start">
<div class="bg-secondary-fixed-dim/10 p-4"><span class="material-symbols-outlined text-secondary-fixed-dim">workspace_premium</span></div>
<div><h4 class="font-title-lg text-title-lg mb-2">Profesionalismo Incomparable</h4><p class="font-body-md text-body-md opacity-70">Asesoramiento experto respaldado por décadas de experiencia en el mercado de activos de lujo.</p></div>
</div>
<div class="flex gap-6 items-start">
<div class="bg-secondary-fixed-dim/10 p-4"><span class="material-symbols-outlined text-secondary-fixed-dim">lock</span></div>
<div><h4 class="font-title-lg text-title-lg mb-2">Privacidad y Confidencialidad</h4><p class="font-body-md text-body-md opacity-70">Garantizamos la máxima discreción en cada transacción, protegiendo siempre sus intereses.</p></div>
</div>
<div class="flex gap-6 items-start">
<div class="bg-secondary-fixed-dim/10 p-4"><span class="material-symbols-outlined text-secondary-fixed-dim">public</span></div>
<div><h4 class="font-title-lg text-title-lg mb-2">Visión Global</h4><p class="font-body-md text-body-md opacity-70">Acceso exclusivo a una red internacional de inversores y las propiedades más cotizadas del mundo.</p></div>
</div>
</div>
</div>
</div>
</section>

<?php include 'includes/footer.php'; ?>
