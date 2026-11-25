<?php $pageTitle = 'Bardial Inmobiliaria | Detalles de la Propiedad'; $activePage = '';
include 'includes/properties.php';
$propId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$property = null;
foreach ($properties as $p) { if ($p['id'] === $propId) { $property = $p; break; } }
if (!$property) { $property = $properties[0]; }

$galleryImages = [];
if (!empty($property['images'])) {
    $galleryImages = array_map('trim', explode(',', $property['images']));
} elseif (!empty($property['img'])) {
    $galleryImages = [$property['img']];
}
$hasVideo = !empty($property['video']);
?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>

<style>
.fill-icon { font-variation-settings: 'FILL' 1; }
.sticky-sidebar { top: 100px; max-height: calc(100vh - 140px); }

/* Collage grid */
.collage {
  display: grid;
  grid-template-columns: 2fr 1fr;
  grid-auto-rows: 220px;
  gap: 6px;
}
.collage-item {
  position: relative; overflow: hidden; cursor: pointer;
}
.collage-item img {
  width: 100%; height: 100%; object-fit: cover;
  transition: transform .6s ease;
}
.collage-item:hover img { transform: scale(1.05); }
.collage-item .overlay-count {
  position: absolute; inset: 0; background: rgba(10,20,30,.7);
  display: flex; align-items: center; justify-content: center;
  color: #fff; font-size: 2rem; font-weight: 700;
  transition: opacity .3s;
}
.collage-item .overlay-count:hover { opacity: .9; }
.collage-main {
  grid-row: span 2;
}

/* Lightbox */
.lightbox {
  display: none; position: fixed; inset: 0; z-index: 9999;
  background: rgba(0,0,0,.92); align-items: center; justify-content: center;
}
.lightbox.active { display: flex; }
.lightbox img {
  max-width: 90vw; max-height: 90vh; object-fit: contain;
  box-shadow: 0 20px 60px rgba(0,0,0,.5);
}
.lightbox-close {
  position: absolute; top: 20px; right: 30px; color: #fff; font-size: 2.5rem;
  cursor: pointer; opacity: .7; transition: opacity .2s;
  background: none; border: none; line-height: 1;
}
.lightbox-close:hover { opacity: 1; }
.lightbox-nav {
  position: absolute; top: 50%; transform: translateY(-50%);
  color: #fff; font-size: 2.5rem; cursor: pointer; opacity: .6;
  transition: opacity .2s; background: none; border: none; padding: 10px;
}
.lightbox-nav:hover { opacity: 1; }
.lightbox-prev { left: 20px; }
.lightbox-next { right: 20px; }
.lightbox-counter {
  position: absolute; bottom: 30px; color: rgba(255,255,255,.6);
  font-size: .9rem; letter-spacing: 2px;
}

@media (max-width: 1023px) {
  .collage { grid-template-columns: 1fr 1fr; grid-auto-rows: 180px; }
  .collage-main { grid-row: span 1; grid-column: span 2; height: 260px; }
}
@media (max-width: 639px) {
  .collage { grid-template-columns: 1fr; grid-auto-rows: 200px; }
  .collage-main { grid-column: span 1; height: auto; }
}
</style>

<main class="max-w-[1800px] mx-auto px-margin-mobile md:px-margin-desktop py-24">

<!-- Collage Gallery -->
<section class="mb-12">
<div class="collage">
<?php
$totalImages = count($galleryImages);
$displayLimit = 6;
$remaining = $totalImages - $displayLimit;
$showImages = array_slice($galleryImages, 0, $displayLimit);
$hasMore = $totalImages > $displayLimit;
$vi = 0;
foreach ($showImages as $i => $gi):
  $cls = $i === 0 ? 'collage-item collage-main' : 'collage-item';
  if ($i === $displayLimit - 1 && $hasMore):
?>
<div class="<?php echo $cls; ?>" onclick="openLightbox(<?php echo $i; ?>)">
<img src="<?php echo htmlspecialchars($gi); ?>" alt=""/>
<div class="overlay-count">+<?php echo $remaining; ?></div>
</div>
<?php else: ?>
<div class="<?php echo $cls; ?>" onclick="openLightbox(<?php echo $i; ?>)">
<img src="<?php echo htmlspecialchars($gi); ?>" alt=""/>
</div>
<?php endif; $vi = $i; endforeach; ?>

<?php if ($hasVideo): ?>
<?php $vi++; ?>
<div class="collage-item relative cursor-pointer group" onclick="document.getElementById('videoTour').scrollIntoView({behavior:'smooth'})">
<div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20 z-10"></div>
<?php $vp = $galleryImages[1] ?? $galleryImages[0] ?? $property['img']; ?>
<img class="w-full h-full object-cover" src="<?php echo htmlspecialchars($vp); ?>" alt="Video Tour"/>
<div class="absolute inset-0 z-20 flex items-center justify-center">
<div class="w-16 h-16 rounded-full bg-secondary-fixed-dim/90 flex items-center justify-center shadow-2xl transition-transform group-hover:scale-110">
<span class="material-symbols-outlined text-brand-navy text-3xl fill-icon">play_arrow</span>
</div>
</div>
<div class="absolute bottom-3 left-3 z-20">
<span class="bg-brand-navy text-white font-label-md text-[10px] uppercase px-2 py-0.5 tracking-wider">Video Tour</span>
</div>
</div>
<?php endif; ?>
</div>
</section>

<!-- Lightbox -->
<div class="lightbox" id="lightbox" onclick="closeLightbox(event)">
<button class="lightbox-close" onclick="closeLightbox()">&times;</button>
<button class="lightbox-nav lightbox-prev" onclick="navigateLightbox(-1)">&#10094;</button>
<img id="lightboxImg" src="" alt=""/>
<button class="lightbox-nav lightbox-next" onclick="navigateLightbox(1)">&#10095;</button>
<div class="lightbox-counter" id="lightboxCounter"></div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter relative">
<div class="lg:col-span-8 space-y-section-gap/2">
<section>
<div class="flex flex-col gap-2 mb-6">
<span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest"><?php echo htmlspecialchars($property['location']); ?></span>
<?php if (!empty($property['type'])): ?>
<span class="font-label-md text-label-md text-secondary-fixed-dim uppercase tracking-widest"><?php echo htmlspecialchars($property['type']); ?></span>
<?php endif; ?>
<h1 class="font-headline-lg text-headline-lg text-brand-navy dark:text-surface-variant"><?php echo htmlspecialchars($property['location']); ?></h1>
</div>
<div class="flex flex-wrap gap-8 py-6 border-y border-outline-variant/30 mb-8">
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-on-surface-variant">bed</span><span class="font-body-md text-body-md"><?php echo $property['bed']; ?> Dormitorios</span></div>
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-on-surface-variant">bathtub</span><span class="font-body-md text-body-md"><?php echo $property['bath']; ?> Baños</span></div>
<div class="flex items-center gap-3"><span class="material-symbols-outlined text-on-surface-variant">square_foot</span><span class="font-body-md text-body-md"><?php echo $property['sqm']; ?> m² Construidos</span></div>
</div>
</section>
<?php if (!empty($property['description'])): ?>
<section>
<div class="prose max-w-none">
<h2 class="font-headline-md text-headline-md text-brand-navy mb-4">Descripción</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant leading-relaxed"><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
</div>
</section>
<?php endif; ?>
<section class="mt-12">
<?php
$serviceIcons = [
    'Alberca' => 'pool',
    'Alberca Infinity' => 'pool',
    'Vista al Mar' => 'beach_access',
    'Seguridad 24h' => 'security',
    'Seguridad 24/7' => 'security',
    'Estacionamiento Privado' => 'local_parking',
    'Roof Garden' => 'deck',
    'Gimnasio' => 'fitness_center',
    'Spa' => 'spa',
    'Jardín' => 'yard',
    'Chimenea' => 'fireplace',
    'Casa de Huéspedes' => 'holiday_village',
    'Cancha de Tenis' => 'sports_tennis',
    'Muelle Privado' => 'dock',
    'Helipuerto' => 'flight_takeoff',
    'Bodega de Vinos' => 'wine_bar',
    'Palapa' => 'hut',
    'Tinaja' => 'hot_tub',
];
?>
<h2 class="font-headline-md text-headline-md text-brand-navy mb-8">Servicios y Amenidades</h2>
<?php if (!empty($property['services'])): ?>
<?php $svcList = array_map('trim', explode(',', $property['services'])); ?>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
<?php foreach ($svcList as $svc): ?>
<?php $icon = $serviceIcons[$svc] ?? 'check_circle'; ?>
<div class="flex flex-col items-center justify-center gap-3 p-6 text-center border border-outline-variant/15 hover:border-secondary-fixed-dim hover:shadow-md transition-all bg-white dark:bg-surface-dark rounded-none group">
<span class="material-symbols-outlined text-3xl text-secondary-fixed-dim transition-transform group-hover:scale-110"><?php echo $icon; ?></span>
<span class="font-body-md text-body-md dark:text-surface-variant"><?php echo htmlspecialchars($svc); ?></span>
</div>
<?php endforeach; ?>
</div>
<?php else: ?>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
<div class="flex flex-col items-center justify-center gap-3 p-6 text-center border border-outline-variant/15 bg-white dark:bg-surface-dark"><span class="material-symbols-outlined text-3xl text-secondary-fixed-dim">security</span><span class="font-body-md text-body-md dark:text-surface-variant">Seguridad 24/7</span></div>
<div class="flex flex-col items-center justify-center gap-3 p-6 text-center border border-outline-variant/15 bg-white dark:bg-surface-dark"><span class="material-symbols-outlined text-3xl text-secondary-fixed-dim">local_parking</span><span class="font-body-md text-body-md dark:text-surface-variant">Estacionamiento Privado</span></div>
<div class="flex flex-col items-center justify-center gap-3 p-6 text-center border border-outline-variant/15 bg-white dark:bg-surface-dark"><span class="material-symbols-outlined text-3xl text-secondary-fixed-dim">pool</span><span class="font-body-md text-body-md dark:text-surface-variant">Alberca</span></div>
</div>
<?php endif; ?>
</section>
<section class="mt-12">
<h2 class="font-headline-md text-headline-md text-brand-navy mb-6">Mapa Interactivo</h2>
<div class="h-[400px] bg-surface-container-high border border-outline-variant/30 overflow-hidden">
<iframe class="w-full h-full" src="https://maps.google.com/maps?q=<?php echo urlencode($property['location']); ?>+Mexico&amp;output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
</section>
</div>
<aside class="lg:col-span-4">
<div class="sticky-sidebar bg-white dark:bg-surface-dark border border-outline-variant/20 p-8 shadow-sm dark:shadow-black/30">
<div class="mb-8">
<span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest">Precio</span>
<div class="font-headline-md text-headline-md text-brand-navy mt-1"><?php echo htmlspecialchars($property['price']); ?></div>
</div>
<form class="space-y-6">
<h3 class="font-title-lg text-title-lg text-brand-navy border-b border-outline-variant/10 pb-4">Contactar al Agente</h3>
<div class="space-y-4">
<input class="w-full border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-secondary-fixed-dim placeholder:text-on-surface-variant/40 bg-transparent transition-colors" placeholder="Nombre Completo" type="text"/>
<input class="w-full border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-secondary-fixed-dim placeholder:text-on-surface-variant/40 bg-transparent transition-colors" placeholder="Correo Electrónico" type="email"/>
<input class="w-full border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-secondary-fixed-dim placeholder:text-on-surface-variant/40 bg-transparent transition-colors" placeholder="Teléfono" type="tel"/>
<textarea class="w-full border-0 border-b border-outline-variant py-3 px-0 focus:ring-0 focus:border-secondary-fixed-dim placeholder:text-on-surface-variant/40 bg-transparent transition-colors resize-none" placeholder="Estoy interesado en visitar esta propiedad..." rows="3"></textarea>
</div>
<button class="w-full bg-secondary-fixed-dim text-brand-navy font-label-md text-label-md py-4 uppercase tracking-widest hover:brightness-105 transition-all shadow-md active:scale-[0.98]" type="submit">Programar una Visita</button>
<button class="w-full border-2 border-secondary-fixed-dim text-secondary-fixed-dim font-label-md text-label-md py-4 uppercase tracking-widest hover:bg-secondary-fixed-dim hover:text-brand-navy transition-all" type="button">Enviar Mensaje</button>
</form>
<div class="mt-8 flex items-center gap-4 p-4 bg-surface-container-low">
<div class="w-12 h-12 rounded-full overflow-hidden bg-outline-variant">
<img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBiIrPYzIJhDpm7Z7CFCArJzzXRFs0IQF9Liua_YWlSYhWUqflgjf9pm5GSbSB3GeVa3SrvfQjyQkJRX7C-18LCIVrjr3gwevKH-yWsbrcorOQ1Z5GakkTh3vAYxG0W2aCa9oTQdBv9BikGdJ7yWTBgt53tDhq8IGeK9wd9rK6cBQdMRDIdj9Ev1uTerPAbhHgDslUD1RdRb8CboqRcP9eUXO9BsfvPcTFw6RxRuBcxPK9ghz-xlQURVPfokMfs03cQhgoDaaopiX1z"/>
</div>
<div>
<div class="font-title-lg text-label-md font-bold">Julian Bardial</div>
<div class="font-body-md text-xs text-on-surface-variant uppercase tracking-tighter">Director Gerente</div>
</div>
</div>
<?php if ($hasVideo): ?>
<button class="video-modal-btn w-full mt-4 bg-secondary-fixed-dim text-brand-navy font-label-md text-label-md py-4 uppercase tracking-widest flex items-center justify-center gap-2 hover:brightness-105 transition-all shadow-md active:scale-[0.98]">
<span class="material-symbols-outlined fill-icon">play_circle</span> Ver Video Tour
</button>
<?php endif; ?>
</div>
</aside>
</div>
<section class="mt-section-gap">
<div class="flex justify-between items-end mb-10">
<h2 class="font-headline-md text-headline-md text-brand-navy">Propiedades Similares</h2>
<a class="font-label-md text-label-md text-brand-navy border-b border-brand-navy pb-1 hover:text-secondary-fixed-dim hover:border-secondary-fixed-dim transition-all" href="catalogo.php">Ver Todas las Propiedades</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
<?php $similares = array_filter($properties, function($sp) use ($propId) { return $sp['id'] !== $propId; }); ?>
<?php $similares = array_slice(array_values($similares), 0, 3); ?>
<?php foreach ($similares as $sp): ?>
<a href="detalles.php?id=<?php echo $sp['id']; ?>" class="bg-white dark:bg-surface-dark border border-outline-variant/15 group hover:shadow-xl transition-all duration-500 overflow-hidden">
<div class="relative h-[280px] overflow-hidden">
<img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="<?php echo htmlspecialchars($sp['img']); ?>" alt="<?php echo htmlspecialchars($sp['location']); ?>"/>
<?php if ($sp['badge']): ?>
<div class="absolute top-4 left-4 bg-brand-navy text-white text-[10px] uppercase font-bold px-3 py-1 tracking-widest"><?php echo htmlspecialchars($sp['badge']); ?></div>
<?php endif; ?>
</div>
<div class="p-8">
<div class="text-secondary-fixed-dim font-headline-md text-title-lg mb-2"><?php echo htmlspecialchars($sp['price']); ?></div>
<h3 class="font-body-lg font-bold text-on-surface dark:text-surface-variant mb-4"><?php echo htmlspecialchars($sp['location']); ?></h3>
<div class="flex gap-4 border-t border-outline-variant/10 pt-4 text-on-surface-variant dark:text-surface-variant text-sm">
<span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">bed</span> <?php echo (int)$sp['bed']; ?></span>
<span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">bathtub</span> <?php echo (int)$sp['bath']; ?></span>
<span class="flex items-center gap-1"><span class="material-symbols-outlined text-sm">square_foot</span> <?php echo (int)$sp['sqm']; ?>m²</span>
</div>
</div>
</a>
<?php endforeach; ?>
</div>
</section>
</main>

<script>
var lightboxImages = <?php echo json_encode(array_values($galleryImages)); ?>;
var currentIndex = 0;

function openLightbox(index) {
  currentIndex = index;
  updateLightbox();
  document.getElementById('lightbox').classList.add('active');
  document.body.style.overflow = 'hidden';
}

function closeLightbox(e) {
  if (e && e.target !== e.currentTarget) return;
  document.getElementById('lightbox').classList.remove('active');
  document.body.style.overflow = '';
}

function navigateLightbox(dir) {
  currentIndex = (currentIndex + dir + lightboxImages.length) % lightboxImages.length;
  updateLightbox();
}

function updateLightbox() {
  var img = document.getElementById('lightboxImg');
  img.src = lightboxImages[currentIndex];
  document.getElementById('lightboxCounter').textContent = (currentIndex + 1) + ' / ' + lightboxImages.length;
}

document.addEventListener('keydown', function(e) {
  if (!document.getElementById('lightbox').classList.contains('active')) return;
  if (e.key === 'Escape') closeLightbox();
  if (e.key === 'ArrowLeft') navigateLightbox(-1);
  if (e.key === 'ArrowRight') navigateLightbox(1);
});
</script>

<?php if ($hasVideo): ?>
<div class="video-modal-overlay" id="videoModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.92);align-items:center;justify-content:center;padding:2rem;">
<div style="position:relative;width:100%;max-width:1100px;background:#000;">
<button class="video-modal-close" style="position:absolute;top:-44px;right:0;background:none;border:none;color:#fff;font-size:2rem;cursor:pointer;padding:4px 12px;line-height:1;">&times;</button>
<video class="w-full max-h-[80vh] object-contain bg-black" controls preload="auto" id="modalVideo">
<source src="assets/videos/<?php echo htmlspecialchars($property['video'] ?? ''); ?>" type="video/mp4">
</video>
</div>
</div>
<style>
.video-modal-overlay.open { display:flex !important; }
</style>
<script>
(function(){
  var btn = document.querySelector('.video-modal-btn');
  var modal = document.getElementById('videoModal');
  var closeBtn = modal.querySelector('.video-modal-close');
  var video = modal.querySelector('video');
  if (!btn) return;
  btn.addEventListener('click', function(){
    modal.classList.add('open');
    video.currentTime = 0;
    video.play();
  });
  function closeModal(){
    modal.classList.remove('open');
    video.pause();
    video.currentTime = 0;
  }
  closeBtn.addEventListener('click', closeModal);
  modal.addEventListener('click', function(e){
    if(e.target === modal) closeModal();
  });
  document.addEventListener('keydown', function(e){
    if(e.key === 'Escape') closeModal();
  });
})();
</script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
