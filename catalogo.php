<?php $pageTitle = 'Bardial Inmobiliaria | Catálogo Exclusivo de Propiedades'; $activePage = 'catalogo'; $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : ''; $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'recent';
include 'includes/properties.php';

// Filter state
$filterType    = isset($_GET['type']) ? (array)$_GET['type'] : [];
$filterPriceMin = isset($_GET['price_min']) ? (float)$_GET['price_min'] : 0;
$filterPriceMax = isset($_GET['price_max']) ? (float)$_GET['price_max'] : 0;
$filterBed     = isset($_GET['bed']) ? (int)$_GET['bed'] : 0;
$filterSqmMin  = isset($_GET['sqm_min']) ? (float)$_GET['sqm_min'] : 0;
$filterSqmMax  = isset($_GET['sqm_max']) ? (float)$_GET['sqm_max'] : 0;
$filterServices = isset($_GET['services']) ? (array)$_GET['services'] : [];

$properties = array_filter($properties, function($p) use ($searchQuery, $filterType, $filterPriceMin, $filterPriceMax, $filterBed, $filterSqmMin, $filterSqmMax, $filterServices) {
    if ($searchQuery && stripos($p['location'], $searchQuery) === false) {
        return false;
    }
    if (!empty($filterType) && !in_array($p['type'], $filterType)) {
        return false;
    }
    if ($filterPriceMin > 0 && (float)($p['price_value'] ?? 0) < $filterPriceMin) {
        return false;
    }
    if ($filterPriceMax > 0 && (float)($p['price_value'] ?? 0) > $filterPriceMax) {
        return false;
    }
    if ($filterBed > 0 && (int)$p['bed'] < $filterBed) {
        return false;
    }
    if ($filterSqmMin > 0 && (float)($p['sqm'] ?? 0) < $filterSqmMin) {
        return false;
    }
    if ($filterSqmMax > 0 && (float)($p['sqm'] ?? 0) > $filterSqmMax) {
        return false;
    }
    if (!empty($filterServices)) {
        $pServices = array_map('trim', explode(',', $p['services'] ?? ''));
        $match = false;
        foreach ($filterServices as $fs) {
            if (in_array($fs, $pServices)) { $match = true; break; }
        }
        if (!$match) return false;
    }
    return true;
});
$properties = array_values($properties);

if ($sortBy === 'price_asc') {
    usort($properties, fn($a, $b) => ($a['price_value'] ?? 0) <=> ($b['price_value'] ?? 0));
} elseif ($sortBy === 'price_desc') {
    usort($properties, fn($a, $b) => ($b['price_value'] ?? 0) <=> ($a['price_value'] ?? 0));
} elseif ($sortBy === 'sqm') {
    usort($properties, fn($a, $b) => ($b['sqm'] ?? 0) <=> ($a['sqm'] ?? 0));
}
$totalProps = count($properties);
$perPage = 4;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$totalPages = ceil($totalProps / $perPage);
$page = min($page, max(1, $totalPages));
$pageProperties = array_slice($properties, ($page - 1) * $perPage, $perPage);

function checkedFilter(string $name, string $value): string {
    $arr = isset($_GET[$name]) ? (array)$_GET[$name] : [];
    return in_array($value, $arr) ? 'checked' : '';
}
include 'includes/head.php';
include 'includes/header.php'; ?>

<style>
        .property-card:hover .property-image-overlay { opacity: 1; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .filter-border { border-bottom: 1px solid rgba(115, 120, 124, 0.2); }
        input:focus { outline: none !important; border-bottom-width: 2px !important; border-color: #081C27 !important; box-shadow: none !important; }
        .dark input:focus { border-color: #f8be26 !important; }
    </style>
<main class="max-w-[1800px] mx-auto px-margin-mobile md:px-margin-desktop py-28">

<nav class="flex items-center gap-2 mb-12 text-on-surface-variant/70 font-label-md text-label-md">
<a class="hover:text-primary transition-colors" href="index.php">Inicio</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<a class="hover:text-primary transition-colors" href="catalogo.php">Propiedades</a>
<span class="material-symbols-outlined text-[16px]">chevron_right</span>
<span class="text-primary font-bold">Listados Exclusivos</span>
</nav>
<div class="flex flex-col lg:flex-row gap-16">
<aside class="w-full lg:w-96 flex-shrink-0 space-y-12">
<form method="get" action="">
<?php foreach ($_GET as $k => $v): if ($k === 'type' || $k === 'price_min' || $k === 'price_max' || $k === 'bed' || $k === 'sqm_min' || $k === 'sqm_max' || $k === 'services' || $k === 'page') continue; if (is_array($v)): foreach ($v as $vv): ?><input name="<?php echo htmlspecialchars($k); ?>[]" type="hidden" value="<?php echo htmlspecialchars($vv); ?>"><?php endforeach; else: ?><input name="<?php echo htmlspecialchars($k); ?>" type="hidden" value="<?php echo htmlspecialchars($v); ?>"><?php endif; endforeach; ?>
<div class="border-b-2 border-primary pb-2 mb-6"><h2 class="font-title-lg text-title-lg uppercase tracking-widest text-primary">Filtros</h2></div>
<div class="space-y-4">
<label class="font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">Tipo de Propiedad</label>
<div class="space-y-2">
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="type[]" type="checkbox" value="Casa Residencial" <?php echo checkedFilter('type', 'Casa Residencial'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Casa Residencial</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="type[]" type="checkbox" value="Villa" <?php echo checkedFilter('type', 'Villa'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Villa</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="type[]" type="checkbox" value="Mansión" <?php echo checkedFilter('type', 'Mansión'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Mansión</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="type[]" type="checkbox" value="Penthouse" <?php echo checkedFilter('type', 'Penthouse'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Penthouse</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="type[]" type="checkbox" value="Departamento Premium" <?php echo checkedFilter('type', 'Departamento Premium'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Departamento Premium</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="type[]" type="checkbox" value="Hacienda" <?php echo checkedFilter('type', 'Hacienda'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Hacienda</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="type[]" type="checkbox" value="Casona Colonial" <?php echo checkedFilter('type', 'Casona Colonial'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Casona Colonial</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="type[]" type="checkbox" value="Casa de Playa" <?php echo checkedFilter('type', 'Casa de Playa'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Casa de Playa</span></label>
</div>
</div>
<div class="space-y-4">
<label class="font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">Rango de Precio (MXN)</label>
<div class="grid grid-cols-2 gap-4">
<input class="w-full bg-transparent border-0 border-b border-outline-variant dark:border-outline-variant/30 py-2 font-body-md focus:ring-0 dark:text-surface-variant" name="price_min" placeholder="Mín" type="number" value="<?php echo htmlspecialchars($_GET['price_min'] ?? ''); ?>"/>
<input class="w-full bg-transparent border-0 border-b border-outline-variant dark:border-outline-variant/30 py-2 font-body-md focus:ring-0 dark:text-surface-variant" name="price_max" placeholder="Máx" type="number" value="<?php echo htmlspecialchars($_GET['price_max'] ?? ''); ?>"/>
</div>
</div>
<div class="space-y-4">
<label class="font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">Dormitorios</label>
<div class="flex flex-wrap gap-2">
<?php foreach ([1,2,3,4] as $b): ?>
<a href="?<?php echo http_build_query(array_merge($_GET, ['bed' => $b, 'page' => 1])); ?>" class="px-4 py-2 <?php echo ($filterBed === $b) ? 'border-2 border-secondary-fixed-dim text-secondary-fixed-dim font-bold' : 'border border-outline-variant dark:border-outline-variant/30 hover:border-secondary-fixed-dim transition-colors text-on-surface-variant dark:text-surface-variant'; ?> text-label-md font-label-md"><?php echo $b; ?>+</a>
<?php endforeach; ?>
<?php if ($filterBed > 0): ?>
<a href="?<?php echo http_build_query(array_merge($_GET, ['bed' => '', 'page' => 1])); ?>" class="px-4 py-2 text-label-md font-label-md text-on-surface-variant/50 hover:text-error transition-colors">Limpiar</a>
<?php endif; ?>
</div>
</div>
<div class="space-y-4">
<label class="font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">Superficie (m²)</label>
<div class="grid grid-cols-2 gap-4">
<input class="w-full bg-transparent border-0 border-b border-outline-variant py-2 font-body-md focus:ring-0" name="sqm_min" placeholder="Desde" type="number" value="<?php echo htmlspecialchars($_GET['sqm_min'] ?? ''); ?>"/>
<input class="w-full bg-transparent border-0 border-b border-outline-variant py-2 font-body-md focus:ring-0" name="sqm_max" placeholder="Hasta" type="number" value="<?php echo htmlspecialchars($_GET['sqm_max'] ?? ''); ?>"/>
</div>
</div>
<div class="space-y-4">
<label class="font-label-md text-label-md uppercase tracking-wider text-on-surface-variant">Servicios</label>
<div class="space-y-3 max-h-56 overflow-y-auto scrollbar-hide">
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Alberca" <?php echo checkedFilter('services', 'Alberca'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Alberca</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Alberca Infinity" <?php echo checkedFilter('services', 'Alberca Infinity'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Alberca Infinity</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Vista al Mar" <?php echo checkedFilter('services', 'Vista al Mar'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Vista al Mar</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Seguridad 24h" <?php echo checkedFilter('services', 'Seguridad 24h'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Seguridad 24h</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Estacionamiento Privado" <?php echo checkedFilter('services', 'Estacionamiento Privado'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Estacionamiento Privado</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Roof Garden" <?php echo checkedFilter('services', 'Roof Garden'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Roof Garden</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Gimnasio" <?php echo checkedFilter('services', 'Gimnasio'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Gimnasio</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Spa" <?php echo checkedFilter('services', 'Spa'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Spa</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Jardín" <?php echo checkedFilter('services', 'Jardín'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Jardín</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Chimenea" <?php echo checkedFilter('services', 'Chimenea'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Chimenea</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Casa de Huéspedes" <?php echo checkedFilter('services', 'Casa de Huéspedes'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Casa de Huéspedes</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Cancha de Tenis" <?php echo checkedFilter('services', 'Cancha de Tenis'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Cancha de Tenis</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Muelle Privado" <?php echo checkedFilter('services', 'Muelle Privado'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Muelle Privado</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Helipuerto" <?php echo checkedFilter('services', 'Helipuerto'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Helipuerto</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Bodega de Vinos" <?php echo checkedFilter('services', 'Bodega de Vinos'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Bodega de Vinos</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Palapa" <?php echo checkedFilter('services', 'Palapa'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Palapa</span></label>
<label class="flex items-center gap-3 cursor-pointer group"><input class="w-5 h-5 border-outline-variant text-secondary-fixed-dim focus:ring-0 rounded-none" name="services[]" type="checkbox" value="Tinaja" <?php echo checkedFilter('services', 'Tinaja'); ?>/><span class="font-body-md group-hover:text-primary transition-colors">Tinaja</span></label>
</div>
</div>
<button class="w-full bg-secondary-fixed-dim text-brand-navy py-4 font-label-md text-label-md uppercase tracking-widest font-bold hover:brightness-110 transition-all mt-6" type="submit">Aplicar Filtros</button>
<?php if (!empty($_GET)): ?>
<a class="block w-full text-center border border-outline-variant text-on-surface-variant py-4 font-label-md text-label-md uppercase tracking-widest hover:text-error hover:border-error transition-all mt-2" href="catalogo.php">Limpiar Filtros</a>
<?php endif; ?>
</form>
</aside>
<div class="flex-1">
<div class="flex flex-col sm:flex-row justify-between items-end sm:items-center mb-12 gap-6">
<div><?php if ($searchQuery): ?><h1 class="font-headline-md text-headline-md text-primary mb-1"><?php echo $totalProps; ?> Resultados para "<?php echo htmlspecialchars($searchQuery); ?>"</h1><p class="text-on-surface-variant/80 font-body-md">Mostrando propiedades que coinciden con su búsqueda.</p><?php else: ?><h1 class="font-headline-md text-headline-md text-primary mb-1"><?php echo $totalProps; ?> Propiedades Encontradas</h1><p class="text-on-surface-variant/80 font-body-md">Oportunidades de inversión de lujo en los destinos más exclusivos de México.</p><?php endif; ?></div>
<form method="get" class="flex items-center gap-4 bg-surface-container-low dark:bg-surface-container-dark px-4 py-2">
<span class="font-label-md text-label-md text-on-surface-variant uppercase whitespace-nowrap">Ordenar por:</span>
<select name="sort" class="bg-transparent border-none focus:ring-0 font-label-md text-label-md cursor-pointer text-primary font-bold pr-10" onchange="this.form.submit()">
<option value="recent" <?php echo $sortBy === 'recent' ? 'selected' : ''; ?>>Más Recientes</option>
<option value="price_asc" <?php echo $sortBy === 'price_asc' ? 'selected' : ''; ?>>Precio: Menor a Mayor</option>
<option value="price_desc" <?php echo $sortBy === 'price_desc' ? 'selected' : ''; ?>>Precio: Mayor a Menor</option>
<option value="sqm" <?php echo $sortBy === 'sqm' ? 'selected' : ''; ?>>Metros Cuadrados</option>
</select>
<?php foreach ($_GET as $k => $v): if ($k === 'sort' || $k === 'page') continue; if (is_array($v)): foreach ($v as $vv): ?><input name="<?php echo htmlspecialchars($k); ?>[]" type="hidden" value="<?php echo htmlspecialchars($vv); ?>"><?php endforeach; else: ?><input name="<?php echo htmlspecialchars($k); ?>" type="hidden" value="<?php echo htmlspecialchars($v); ?>"><?php endif; endforeach; ?>
</form>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-12">
<?php foreach ($pageProperties as $p): ?>
<div class="bg-surface dark:bg-surface-dark group hover:shadow-[0_20px_60px_rgba(8,28,39,0.12)] dark:hover:shadow-[0_20px_60px_rgba(0,0,0,0.5)] border border-outline-variant/15 hover:border-secondary-fixed-dim transition-all duration-500 flex flex-col">
<a href="detalles.php?id=<?php echo $p['id']; ?>" class="relative overflow-hidden aspect-[4/3]">
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="<?php echo htmlspecialchars($p['img']); ?>" alt="<?php echo htmlspecialchars($p['location']); ?>"/>

<?php if (!empty($p['video'])): ?><div class="absolute bottom-4 left-4 bg-black/70 backdrop-blur-sm text-white flex items-center gap-2 px-4 py-2 font-label-md text-[12px] uppercase tracking-wider"><span class="material-symbols-outlined text-[18px] text-secondary-fixed-dim" style="font-variation-settings: 'FILL' 1;">play_circle</span> Video Tour</div><?php endif; ?>
</a>
<a href="detalles.php?id=<?php echo $p['id']; ?>" class="p-8 flex-1 flex flex-col <?php echo !empty($p['sold']) ? 'opacity-80' : ''; ?>">
<div class="flex justify-between items-start mb-3">
<h3 class="font-headline-md text-headline-md text-primary"><?php echo htmlspecialchars($p['price']); ?></h3>
<button class="material-symbols-outlined text-on-surface-variant hover:text-error transition-colors text-2xl" onclick="event.preventDefault()">favorite</button>
</div>
<p class="font-body-md text-on-surface-variant mb-1 uppercase tracking-wider"><?php echo htmlspecialchars($p['location']); ?></p>
<?php if (!empty($p['type'])): ?>
<p class="font-label-md text-label-md text-secondary-fixed-dim mb-4"><?php echo htmlspecialchars($p['type']); ?></p>
<?php endif; ?>
<?php if (!empty($p['services'])): ?>
<?php $svcList = array_map('trim', explode(',', $p['services'])); ?>
<div class="flex flex-wrap gap-2 mb-5">
<?php foreach (array_slice($svcList, 0, 3) as $svc): ?>
<span class="bg-brand-navy/5 dark:bg-surface-variant/10 text-on-surface-variant dark:text-surface-variant px-3 py-1 font-label-md text-[11px] uppercase tracking-wider"><?php echo htmlspecialchars($svc); ?></span>
<?php endforeach; ?>
<?php if (count($svcList) > 3): ?>
<span class="text-on-surface-variant/60 font-label-md text-[11px]">+<?php echo count($svcList) - 3; ?></span>
<?php endif; ?>
</div>
<?php endif; ?>
<div class="mt-auto pt-5 border-t border-outline-variant/20 flex justify-between items-center text-on-surface-variant">
<div class="flex items-center gap-5">
<span class="flex items-center gap-1.5 font-label-md"><span class="material-symbols-outlined text-xl">bed</span> <?php echo (int)$p['bed']; ?></span>
<span class="flex items-center gap-1.5 font-label-md"><span class="material-symbols-outlined text-xl">bathtub</span> <?php echo (int)$p['bath']; ?></span>
<span class="flex items-center gap-1.5 font-label-md"><span class="material-symbols-outlined text-xl">square_foot</span> <?php echo (int)$p['sqm']; ?>m²</span>
</div>
<span class="material-symbols-outlined text-primary group-hover:translate-x-1 transition-transform">arrow_forward</span>
</div>
</a>
</div>
<?php endforeach; ?>
</div>
<div class="mt-20 flex justify-center items-center gap-4">
<?php if ($totalPages > 1): ?>
<?php $prevPage = $page - 1; $nextPage = $page + 1; $filterParams = $_GET; unset($filterParams['page']); $queryString = $filterParams ? '&' . http_build_query($filterParams) : ''; ?>
<a class="p-3 border border-outline-variant hover:border-secondary-fixed-dim disabled:opacity-30 <?php echo $page <= 1 ? 'pointer-events-none opacity-30' : ''; ?>" href="?page=<?php echo $prevPage . $queryString; ?>"><span class="material-symbols-outlined">chevron_left</span></a>
<div class="flex items-center gap-2">
<?php for ($i = 1; $i <= $totalPages; $i++): ?>
<a class="w-12 h-12 flex items-center justify-center <?php echo $i === $page ? 'border-2 border-secondary-fixed-dim text-secondary-fixed-dim font-bold' : 'border border-outline-variant dark:border-outline-variant/30 hover:border-secondary-fixed-dim transition-colors text-on-surface-variant dark:text-surface-variant'; ?>" href="?page=<?php echo $i . $queryString; ?>"><?php echo $i; ?></a>
<?php endfor; ?>
</div>
<a class="p-2 border border-outline-variant hover:border-secondary-fixed-dim <?php echo $page >= $totalPages ? 'pointer-events-none opacity-30' : ''; ?>" href="?page=<?php echo $nextPage . $queryString; ?>"><span class="material-symbols-outlined">chevron_right</span></a>
<?php endif; ?>
</div>
</div>
</div>
</main>

<script>
        const bedroomButtons = document.querySelectorAll('aside .flex.flex-wrap button');
        bedroomButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                bedroomButtons.forEach(b => {
                    b.classList.remove('border-2', 'border-primary', 'text-primary', 'font-bold');
                    b.classList.add('border', 'border-outline-variant');
                });
                btn.classList.add('border-2', 'border-primary', 'text-primary', 'font-bold');
                btn.classList.remove('border', 'border-outline-variant');
            });
        });
    </script>

<script>
const searchInput = document.getElementById('searchInput');
const searchContainer = document.getElementById('searchContainer');
if (searchInput && searchContainer) {
    const dropdown = document.createElement('div');
    dropdown.id = 'searchDropdown';
    dropdown.className = 'absolute top-full left-0 right-0 mt-1 bg-surface dark:bg-inverse-surface border border-outline-variant/30 dark:border-outline-variant/10 shadow-xl rounded-none overflow-hidden hidden z-50';
    searchContainer.style.position = 'relative';
    searchContainer.appendChild(dropdown);

    let debounceTimer;

    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const q = this.value.trim();
        if (q.length < 2) { dropdown.classList.add('hidden'); return; }
        debounceTimer = setTimeout(function() {
            fetch('ajax-search.php?q=' + encodeURIComponent(q))
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    if (!data.length) { dropdown.classList.add('hidden'); return; }
                    dropdown.innerHTML = '';
                    data.forEach(function(p) {
                        const item = document.createElement('a');
                        item.href = 'detalles.php?id=' + p.id;
                        item.className = 'flex items-center gap-3 px-4 py-3 hover:bg-surface-container-low dark:hover:bg-surface-container-highest transition-colors border-b border-outline-variant/10 last:border-b-0';
                        item.innerHTML =
                            '<img class="w-10 h-10 object-cover flex-shrink-0" src="' + (p.img || '') + '" alt="" loading="lazy" onerror="this.style.display=\'none\'">' +
                            '<div class="flex-1 min-w-0"><p class="font-label-md text-label-md text-on-surface dark:text-inverse-on-surface truncate">' + escapeHtml(p.location) + '</p><p class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant">' + escapeHtml(p.price) + '</p></div>';
                        dropdown.appendChild(item);
                    });
                    dropdown.classList.remove('hidden');
                })
                .catch(function() { dropdown.classList.add('hidden'); });
        }, 250);
    });

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { dropdown.classList.add('hidden'); }
    });

    document.addEventListener('click', function(e) {
        if (!searchContainer.contains(e.target)) { dropdown.classList.add('hidden'); }
    });

    searchInput.addEventListener('blur', function() {
        setTimeout(function() { dropdown.classList.add('hidden'); }, 200);
    });
}
function escapeHtml(str) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
}
</script>

<?php include 'includes/footer.php';
