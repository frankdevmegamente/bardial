<?php $pageTitle = 'Bardial Inmobiliaria | Catálogo Exclusivo de Propiedades'; $activePage = 'catalogo'; $pageCss = 'catalogo'; $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : ''; $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'recent';
include 'includes/properties.php';
include 'includes/categories.php';

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
    if (!empty($filterType) && !in_array(bardial_category_for($p['type'] ?? ''), $filterType)) {
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

$allCategories = BARDIAL_CATEGORIES;
$allServices = ['Alberca', 'Alberca Infinity', 'Vista al Mar', 'Seguridad 24h', 'Estacionamiento Privado', 'Roof Garden', 'Gimnasio', 'Spa', 'Jardín', 'Chimenea', 'Casa de Huéspedes', 'Cancha de Tenis', 'Muelle Privado', 'Helipuerto', 'Bodega de Vinos', 'Palapa', 'Tinaja'];

include 'includes/head.php';
include 'includes/header.php';
?>

<main class="flex-grow">
  <div class="container-bardial pt-32 pb-24">

    <nav class="flex items-center gap-2 mb-10 text-xs" style="color:var(--color-gray-6);" aria-label="Ruta de navegación">
      <a class="hover:text-[var(--color-gold-text)] transition-colors" href="index.php">Inicio</a>
      <span class="text-[10px]">›</span>
      <a class="hover:text-[var(--color-gold-text)] transition-colors" href="catalogo.php">Propiedades</a>
      <span class="text-[10px]">›</span>
      <span style="color:var(--color-navy);">Listados exclusivos</span>
    </nav>

    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-14">
      <div>
        <p class="eyebrow">Colección Bardial</p>
        <h1 class="section-title mt-5">Propiedades</h1>
        <p class="mt-4 text-sm font-medium" style="color:var(--color-gold-text);" role="status"><?php echo $totalProps; ?> propiedades encontradas</p>
        <p class="mt-2 max-w-[448px] text-sm leading-6" style="color:var(--color-gray-2);">Oportunidades de inversión de lujo en los destinos más exclusivos de México.</p>
      </div>
      <div class="flex flex-col sm:flex-row items-stretch sm:items-end gap-4 w-full lg:w-auto">
        <form method="get" action="" id="searchContainer" class="relative flex-1 lg:w-72">
          <label class="form-label" for="searchInput">Buscar por ubicación</label>
          <div class="flex items-center gap-2">
            <input class="input-line" id="searchInput" name="search" type="search" placeholder="Escribe una ubicación" value="<?php echo htmlspecialchars($searchQuery); ?>"/>
            <button type="submit" class="shrink-0 w-11 h-11 rounded-full flex items-center justify-center transition-colors" style="background:var(--color-navy-btn);color:#fff;" aria-label="Buscar">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3.5-3.5"/></svg>
            </button>
          </div>
          <?php foreach ($_GET as $k => $v): if ($k === 'search' || $k === 'sort' || $k === 'page') continue; if (is_array($v)): foreach ($v as $vv): ?><input name="<?php echo htmlspecialchars($k); ?>[]" type="hidden" value="<?php echo htmlspecialchars($vv); ?>"><?php endforeach; else: ?><input name="<?php echo htmlspecialchars($k); ?>" type="hidden" value="<?php echo htmlspecialchars($v); ?>"><?php endif; endforeach; ?>
        </form>
        <form method="get" class="w-full sm:w-auto">
          <label class="form-label" for="sortSelect">Ordenar por</label>
          <div class="relative">
            <select id="sortSelect" name="sort" class="input-line appearance-none pr-8 cursor-pointer" onchange="this.form.submit()">
              <option value="recent" <?php echo $sortBy === 'recent' ? 'selected' : ''; ?>>Más recientes</option>
              <option value="price_asc" <?php echo $sortBy === 'price_asc' ? 'selected' : ''; ?>>Precio: menor a mayor</option>
              <option value="price_desc" <?php echo $sortBy === 'price_desc' ? 'selected' : ''; ?>>Precio: mayor a menor</option>
              <option value="sqm" <?php echo $sortBy === 'sqm' ? 'selected' : ''; ?>>Metros cuadrados</option>
            </select>
            <svg class="absolute right-0 bottom-4 pointer-events-none" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
          </div>
          <?php foreach ($_GET as $k => $v): if ($k === 'sort' || $k === 'page') continue; if (is_array($v)): foreach ($v as $vv): ?><input name="<?php echo htmlspecialchars($k); ?>[]" type="hidden" value="<?php echo htmlspecialchars($vv); ?>"><?php endforeach; else: ?><input name="<?php echo htmlspecialchars($k); ?>" type="hidden" value="<?php echo htmlspecialchars($v); ?>"><?php endif; endforeach; ?>
        </form>
      </div>
    </div>

    <?php if ($searchQuery): ?>
      <p class="mb-8 text-sm" style="color:var(--color-gray-2);" role="status"><?php echo $totalProps; ?> resultado<?php echo $totalProps === 1 ? '' : 's'; ?> para “<?php echo htmlspecialchars($searchQuery); ?>”</p>
    <?php endif; ?>

    <div class="flex flex-col lg:flex-row gap-12">
      <aside class="w-full lg:w-[300px] flex-shrink-0">
        <form method="get" action="" class="space-y-10">
          <?php foreach ($_GET as $k => $v): if ($k === 'type' || $k === 'price_min' || $k === 'price_max' || $k === 'bed' || $k === 'sqm_min' || $k === 'sqm_max' || $k === 'services' || $k === 'page') continue; if (is_array($v)): foreach ($v as $vv): ?><input name="<?php echo htmlspecialchars($k); ?>[]" type="hidden" value="<?php echo htmlspecialchars($vv); ?>"><?php endforeach; else: ?><input name="<?php echo htmlspecialchars($k); ?>" type="hidden" value="<?php echo htmlspecialchars($v); ?>"><?php endif; endforeach; ?>

          <div class="pb-4 border-b" style="border-color:var(--color-beige-border);">
            <h2 class="text-sm font-semibold uppercase" style="letter-spacing:.18em;color:var(--color-navy);">Filtros</h2>
          </div>

          <fieldset>
            <legend class="form-label mb-4">Categoría</legend>
            <div class="space-y-3">
              <?php foreach ($allCategories as $cat): ?>
                <label class="flex items-center gap-3 cursor-pointer group">
                  <input class="filter-checkbox" name="type[]" type="checkbox" value="<?php echo htmlspecialchars($cat); ?>" <?php echo checkedFilter('type', $cat); ?>/>
                  <span class="text-sm transition-colors group-hover:text-[var(--color-gold-text)]" style="color:var(--color-gray-4);"><?php echo htmlspecialchars($cat); ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          </fieldset>

          <fieldset>
            <legend class="form-label mb-4">Rango de precio (MXN)</legend>
            <div class="grid grid-cols-2 gap-4">
              <input class="input-line" name="price_min" placeholder="Mín" type="number" value="<?php echo htmlspecialchars($_GET['price_min'] ?? ''); ?>"/>
              <input class="input-line" name="price_max" placeholder="Máx" type="number" value="<?php echo htmlspecialchars($_GET['price_max'] ?? ''); ?>"/>
            </div>
          </fieldset>

          <fieldset>
            <legend class="form-label mb-4">Dormitorios</legend>
            <div class="flex flex-wrap gap-2">
              <?php foreach ([1, 2, 3, 4] as $b): ?>
                <a href="?<?php echo htmlspecialchars(http_build_query(array_merge($_GET, ['bed' => $b, 'page' => 1]))); ?>" class="cat-pill <?php echo $filterBed === $b ? 'active' : ''; ?>"><?php echo $b; ?>+</a>
              <?php endforeach; ?>
              <?php if ($filterBed > 0): ?>
                <a href="?<?php echo htmlspecialchars(http_build_query(array_merge($_GET, ['bed' => '', 'page' => 1]))); ?>" class="cat-pill">Limpiar</a>
              <?php endif; ?>
            </div>
          </fieldset>

          <fieldset>
            <legend class="form-label mb-4">Superficie (m²)</legend>
            <div class="grid grid-cols-2 gap-4">
              <input class="input-line" name="sqm_min" placeholder="Desde" type="number" value="<?php echo htmlspecialchars($_GET['sqm_min'] ?? ''); ?>"/>
              <input class="input-line" name="sqm_max" placeholder="Hasta" type="number" value="<?php echo htmlspecialchars($_GET['sqm_max'] ?? ''); ?>"/>
            </div>
          </fieldset>

          <fieldset>
            <legend class="form-label mb-4">Servicios</legend>
            <div class="space-y-3 max-h-56 overflow-y-auto scrollbar-hide pr-2">
              <?php foreach ($allServices as $s): ?>
                <label class="flex items-center gap-3 cursor-pointer group">
                  <input class="filter-checkbox" name="services[]" type="checkbox" value="<?php echo htmlspecialchars($s); ?>" <?php echo checkedFilter('services', $s); ?>/>
                  <span class="text-sm transition-colors group-hover:text-[var(--color-gold-text)]" style="color:var(--color-gray-4);"><?php echo htmlspecialchars($s); ?></span>
                </label>
              <?php endforeach; ?>
            </div>
          </fieldset>

          <button type="submit" class="btn-primary-pill w-full justify-center">Aplicar filtros <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg></button>
          <?php if (!empty($_GET)): ?>
            <a class="btn-ghost-underline block w-full text-center" href="catalogo.php">Limpiar filtros</a>
          <?php endif; ?>
        </form>
      </aside>

      <div class="flex-1 min-w-0">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
          <?php foreach ($pageProperties as $p): ?>
            <a href="detalles.php?id=<?php echo (int)$p['id']; ?>" class="property-card group block <?php echo !empty($p['sold']) ? 'opacity-80' : ''; ?>">
              <div class="relative h-[300px] overflow-hidden rounded-2xl rounded-tr-[5rem]" style="background:#d8d1c5;">
                <img src="<?php echo htmlspecialchars($p['img']); ?>" alt="<?php echo htmlspecialchars($p['location']); ?>" class="property-img w-full h-full object-cover"/>
                <span class="card-label"><?php echo htmlspecialchars(bardial_category_for($p['type'] ?? '')); ?></span>
                <?php if (!empty($p['sold'])): ?><span class="card-label !top-auto !bottom-5 !left-5" style="background:var(--color-navy);color:#fff;">Vendida</span><?php endif; ?>
                <?php if (!empty($p['video'])): ?>
                  <span class="absolute bottom-5 left-5 flex items-center gap-2 px-3 py-1.5 rounded-full text-[11px] uppercase tracking-wider" style="background:rgba(9,29,48,.75);color:#fff;"><span class="fill-icon material-symbols-outlined text-[15px]">play_circle</span> Video tour</span>
                <?php endif; ?>
                <span class="card-btn absolute bottom-5 right-5"><svg class="arrow-rotate" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg></span>
              </div>
              <div class="px-1 pt-6">
                <p class="text-xs" style="color:var(--color-gray-7);"><?php echo htmlspecialchars($p['city'] ?: $p['location']); ?></p>
                <div class="mt-2 flex items-start justify-between gap-4">
                  <h3 class="font-display text-[26px] leading-tight" style="color:var(--color-navy);"><?php echo htmlspecialchars($p['location']); ?></h3>
                  <p class="text-sm font-semibold pt-2 whitespace-nowrap" style="color:var(--color-gold-price);"><?php echo htmlspecialchars($p['price']); ?></p>
                </div>
                <?php if (!empty($p['services'])): ?>
                  <?php $svcList = array_map('trim', explode(',', $p['services'])); ?>
                  <div class="mt-3 flex flex-wrap gap-2">
                    <?php foreach (array_slice($svcList, 0, 3) as $svc): ?>
                      <span class="text-[11px] px-2.5 py-1 rounded-full" style="background:var(--color-beige-icon);color:var(--color-gray-8);"><?php echo htmlspecialchars($svc); ?></span>
                    <?php endforeach; ?>
                    <?php if (count($svcList) > 3): ?><span class="text-[11px]" style="color:var(--color-gray-6);">+<?php echo count($svcList) - 3; ?></span><?php endif; ?>
                  </div>
                <?php endif; ?>
                <div class="mt-4 pt-3 border-t text-xs flex flex-wrap gap-x-5 gap-y-1" style="border-color:var(--color-beige-border);color:var(--color-gray-6);">
                  <span><?php echo (int)$p['bed']; ?> recámaras</span>
                  <span><?php echo (int)$p['bath']; ?> baños</span>
                  <span><?php echo (int)$p['sqm']; ?> m²</span>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>

        <?php if ($totalProps === 0): ?>
          <div class="empty-state mt-6">
            <h3 class="font-display text-[30px]" style="color:var(--color-navy);">Sin resultados</h3>
            <p class="mt-4 text-sm leading-7" style="color:var(--color-gray-2);">No encontramos propiedades con esos filtros. Prueba con otros criterios.</p>
            <a class="btn-primary-pill mt-8" href="catalogo.php">Ver todas las propiedades</a>
          </div>
        <?php endif; ?>

        <?php if ($totalPages > 1): ?>
          <?php $prevPage = max(1, $page - 1); $nextPage = min($totalPages, $page + 1); $prevDisabled = $page <= 1; $nextDisabled = $page >= $totalPages; $filterParams = $_GET; unset($filterParams['page']); $queryString = $filterParams ? '&amp;' . htmlspecialchars(http_build_query($filterParams)) : ''; ?>
          <nav class="mt-20 flex flex-wrap justify-center items-center gap-3" aria-label="Paginación">
            <a class="pagination-btn <?php echo $prevDisabled ? 'pointer-events-none opacity-30' : ''; ?>" href="?page=<?php echo $prevPage . $queryString; ?>" aria-label="Página anterior" <?php echo $prevDisabled ? 'aria-disabled="true" tabindex="-1"' : ''; ?>>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <a class="pagination-btn <?php echo $i === $page ? 'active' : ''; ?>" href="?page=<?php echo $i . $queryString; ?>" aria-current="<?php echo $i === $page ? 'page' : 'false'; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <a class="pagination-btn <?php echo $nextDisabled ? 'pointer-events-none opacity-30' : ''; ?>" href="?page=<?php echo $nextPage . $queryString; ?>" aria-label="Página siguiente" <?php echo $nextDisabled ? 'aria-disabled="true" tabindex="-1"' : ''; ?>>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
            </a>
          </nav>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>

<script>
(function () {
  var searchInput = document.getElementById('searchInput');
  var searchContainer = document.getElementById('searchContainer');
  if (!searchInput || !searchContainer) return;
  var dropdown = document.createElement('div');
  dropdown.id = 'searchDropdown';
  dropdown.className = 'absolute top-full left-0 right-0 mt-2 z-50 hidden';
  dropdown.style.background = 'var(--color-cream)';
  dropdown.style.border = '1px solid var(--color-beige-border)';
  dropdown.style.borderRadius = '16px';
  dropdown.style.boxShadow = '0 20px 25px -5px rgba(0,0,0,.12)';
  dropdown.style.overflow = 'hidden';
  searchContainer.appendChild(dropdown);

  function escapeHtml(str) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
  }
  var timer;
  searchInput.addEventListener('input', function () {
    clearTimeout(timer);
    var q = this.value.trim();
    if (q.length < 2) { dropdown.classList.add('hidden'); return; }
    timer = setTimeout(function () {
      fetch('ajax-search.php?q=' + encodeURIComponent(q))
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (!data.length) { dropdown.classList.add('hidden'); return; }
          dropdown.innerHTML = '';
          data.forEach(function (p) {
            var item = document.createElement('a');
            item.href = 'detalles.php?id=' + p.id;
            item.className = 'flex items-center gap-3 px-4 py-3 transition-colors';
            item.style.borderBottom = '1px solid var(--color-beige-border)';
            item.innerHTML =
              '<img class="w-10 h-10 object-cover flex-shrink-0 rounded" src="' + (p.img || '') + '" alt="" loading="lazy" onerror="this.style.display=\'none\'">' +
              '<span class="flex-1 min-w-0"><span class="block text-sm truncate" style="color:var(--color-navy);">' + escapeHtml(p.location) + '</span>' +
              '<span class="block text-xs" style="color:var(--color-gold-text);">' + escapeHtml(p.price) + '</span></span>';
            dropdown.appendChild(item);
          });
          dropdown.classList.remove('hidden');
        })
        .catch(function () { dropdown.classList.add('hidden'); });
    }, 250);
  });
  searchInput.addEventListener('keydown', function (e) { if (e.key === 'Escape') dropdown.classList.add('hidden'); });
  document.addEventListener('click', function (e) { if (!searchContainer.contains(e.target)) dropdown.classList.add('hidden'); });
  searchInput.addEventListener('blur', function () { setTimeout(function () { dropdown.classList.add('hidden'); }, 200); });
})();
</script>

<?php include 'includes/footer.php'; ?>
