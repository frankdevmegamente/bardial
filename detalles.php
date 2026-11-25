<?php $pageTitle = 'Bardial Inmobiliaria | Detalles de la Propiedad'; $activePage = ''; $pageCss = 'detalles';
include 'includes/properties.php';
include 'includes/categories.php';
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

<main class="flex-grow">
  <div class="container-bardial pt-32 pb-24">

    <nav class="reveal flex items-center gap-2 mb-8 text-xs" style="color:var(--color-gray-6);" aria-label="Ruta de navegación">
      <a class="hover:text-[var(--color-gold-text)] transition-colors" href="index.php">Inicio</a>
      <span class="text-[10px]">›</span>
      <a class="hover:text-[var(--color-gold-text)] transition-colors" href="catalogo.php">Propiedades</a>
      <span class="text-[10px]">›</span>
      <span style="color:var(--color-navy);"><?php echo htmlspecialchars($property['location']); ?></span>
    </nav>

    <!-- Galería -->
    <section class="mb-12">
      <div class="collage reveal reveal--arch rounded-2xl overflow-hidden" style="background:var(--color-beige-icon);">
        <?php
        $totalImages = count($galleryImages);
        $displayLimit = 6;
        $remaining = $totalImages - $displayLimit;
        $showImages = array_slice($galleryImages, 0, $displayLimit);
        $hasMore = $totalImages > $displayLimit;
        foreach ($showImages as $i => $gi):
          $cls = $i === 0 ? 'collage-item collage-main' : 'collage-item';
          if ($i === $displayLimit - 1 && $hasMore):
        ?>
          <div class="<?php echo $cls; ?>" role="button" tabindex="0" aria-label="Abrir galería" onclick="openLightbox(<?php echo $i; ?>)" onkeydown="if(event.key==='Enter')openLightbox(<?php echo $i; ?>)">
            <img src="<?php echo htmlspecialchars($gi); ?>" alt="Imagen de la propiedad"/>
            <div class="overlay-count">+<?php echo $remaining; ?></div>
          </div>
        <?php else: ?>
          <div class="<?php echo $cls; ?>" role="button" tabindex="0" aria-label="Abrir galería" onclick="openLightbox(<?php echo $i; ?>)" onkeydown="if(event.key==='Enter')openLightbox(<?php echo $i; ?>)">
            <img src="<?php echo htmlspecialchars($gi); ?>" alt="Imagen de la propiedad"/>
          </div>
        <?php endif; endforeach; ?>

        <?php if ($hasVideo): ?>
          <div class="collage-item relative cursor-pointer group" role="button" tabindex="0" aria-label="Ver video tour" onclick="openVideoTour()" onkeydown="if(event.key==='Enter')openVideoTour()">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20 z-10"></div>
            <?php $vp = $galleryImages[1] ?? $galleryImages[0] ?? $property['img']; ?>
            <img class="w-full h-full object-cover" src="<?php echo htmlspecialchars($vp); ?>" alt="Video tour"/>
            <div class="absolute inset-0 z-20 flex items-center justify-center">
              <div class="w-16 h-16 rounded-full flex items-center justify-center shadow-2xl transition-transform group-hover:scale-110" style="background:rgba(176,138,71,.92);">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor" style="color:var(--color-navy);" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
              </div>
            </div>
            <div class="absolute bottom-3 left-3 z-20">
              <span class="text-[10px] uppercase px-2 py-1 tracking-wider rounded-full" style="background:var(--surface-dark-accent);color:#fff;">Video tour</span>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox" onclick="closeLightbox(event)">
      <button class="lightbox-close" onclick="closeLightbox()" aria-label="Cerrar galería">&times;</button>
      <button class="lightbox-nav lightbox-prev" onclick="navigateLightbox(-1)" aria-label="Imagen anterior">&#10094;</button>
      <img id="lightboxImg" src="" alt="Imagen ampliada de la propiedad"/>
      <button class="lightbox-nav lightbox-next" onclick="navigateLightbox(1)" aria-label="Imagen siguiente">&#10095;</button>
      <div class="lightbox-counter" id="lightboxCounter" role="status"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 relative">
      <div class="lg:col-span-8 space-y-16 min-w-0">

        <section class="reveal">
          <p class="eyebrow"><?php echo htmlspecialchars($property['city'] ?: 'Propiedad exclusiva'); ?></p>
          <h1 class="font-display mt-5" style="font-size:clamp(2.6rem,5vw,4.4rem);line-height:1;letter-spacing:-.04em;color:var(--color-navy);"><?php echo htmlspecialchars($property['location']); ?></h1>
          <?php if (!empty($property['type'])): ?>
            <p class="mt-4 text-sm uppercase tracking-[.18em]" style="color:var(--color-gold-text);"><?php echo htmlspecialchars(bardial_category_for($property['type'] ?? '')); ?></p>
          <?php endif; ?>
          <div class="flex flex-wrap gap-x-10 gap-y-4 py-6 mt-8 border-y text-sm" style="border-color:var(--color-beige-border);color:var(--color-gray-5);">
            <span class="flex items-center gap-2"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-gold-icon)" stroke-width="1.4" aria-hidden="true"><path d="M3 18v-6l6-4 6 4v6M3 18h18M9 12v6"/></svg><?php echo (int)$property['bed']; ?> recámaras</span>
            <span class="flex items-center gap-2"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-gold-icon)" stroke-width="1.4" aria-hidden="true"><path d="M4 12h16v4a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4v-4zM7 12V6a2 2 0 0 1 2-2 2 2 0 0 1 2 2v6"/></svg><?php echo (int)$property['bath']; ?> baños</span>
            <span class="flex items-center gap-2"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--color-gold-icon)" stroke-width="1.4" aria-hidden="true"><path d="M4 4h16v16H4zM4 10h16M10 4v16"/></svg><?php echo (int)$property['sqm']; ?> m² construidos</span>
          </div>
        </section>

        <?php if (!empty($property['description'])): ?>
          <section class="reveal">
            <h2 class="font-display text-[30px]" style="color:var(--color-navy);">Descripción</h2>
            <p class="mt-5 text-base leading-8" style="color:var(--color-gray-4);"><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
          </section>
        <?php endif; ?>

        <section class="reveal">
          <h2 class="font-display text-[30px]" style="color:var(--color-navy);">Servicios y amenidades</h2>
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
          <?php if (!empty($property['services'])): ?>
            <?php $svcList = array_map('trim', explode(',', $property['services'])); ?>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6">
              <?php foreach ($svcList as $svc): ?>
                <?php $icon = $serviceIcons[$svc] ?? 'check_circle'; ?>
                <div class="flex flex-col items-center justify-center gap-3 p-6 text-center border rounded-2xl transition-all hover:bg-[var(--color-beige-hover)]" style="border-color:var(--color-beige-border);">
                  <span class="material-symbols-outlined text-3xl service-icon"><?php echo htmlspecialchars($icon); ?></span>
                  <span class="text-sm" style="color:var(--color-gray-4);"><?php echo htmlspecialchars($svc); ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-6">
              <?php foreach (['Seguridad 24/7' => 'security', 'Estacionamiento Privado' => 'local_parking', 'Alberca' => 'pool'] as $label => $icon): ?>
                <div class="flex flex-col items-center justify-center gap-3 p-6 text-center border rounded-2xl" style="border-color:var(--color-beige-border);">
                  <span class="material-symbols-outlined text-3xl service-icon"><?php echo $icon; ?></span>
                  <span class="text-sm" style="color:var(--color-gray-4);"><?php echo $label; ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </section>

        <section class="reveal">
          <h2 class="font-display text-[30px]" style="color:var(--color-navy);">Ubicación</h2>
          <div class="h-[400px] mt-6 rounded-2xl overflow-hidden border" style="border-color:var(--color-beige-border);">
            <iframe class="w-full h-full" src="https://maps.google.com/maps?q=<?php echo urlencode($property['location']); ?>+Mexico&amp;output=embed" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </section>
      </div>

      <aside class="lg:col-span-4">
        <div class="sticky-sidebar reveal rounded-2xl border p-8" style="--reveal-delay:120ms;background:var(--color-cream);border-color:var(--color-beige-border);box-shadow:0 20px 50px -20px rgba(9,29,48,.18);">
          <p class="form-label">Precio</p>
          <p class="font-display text-[36px] mt-1" style="color:var(--color-gold-text);"><?php echo htmlspecialchars($property['price']); ?></p>

          <form class="mt-10 space-y-6" id="agentForm">
            <h3 class="font-display text-[24px] pb-4 border-b" style="color:var(--color-navy);border-color:var(--color-beige-border);">Contactar al agente</h3>
            <div>
              <label class="form-label" for="ag-name">Nombre completo</label>
              <input class="input-line" id="ag-name" type="text" placeholder="Escribe tu nombre" required/>
            </div>
            <div>
              <label class="form-label" for="ag-email">Correo electrónico</label>
              <input class="input-line" id="ag-email" type="email" placeholder="nombre@correo.com" required/>
            </div>
            <div>
              <label class="form-label" for="ag-phone">Teléfono</label>
              <input class="input-line" id="ag-phone" type="tel" placeholder="+52 00 0000 0000"/>
            </div>
            <div>
              <label class="form-label" for="ag-msg">Mensaje</label>
              <textarea class="input-line resize-none" id="ag-msg" rows="3" placeholder="Estoy interesado en visitar esta propiedad..."></textarea>
            </div>
            <p id="agentStatus" class="text-sm" style="color:var(--color-gold);" role="status" aria-live="polite"></p>
            <button type="submit" class="btn-primary-pill w-full justify-center">Programar una visita <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg></button>
          </form>

          <div class="mt-8 flex items-center gap-4 p-4 rounded-2xl" style="background:var(--color-beige-icon);">
            <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0" style="background:var(--color-beige-border);">
              <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBiIrPYzIJhDpm7Z7CFCArJzzXRFs0IQF9Liua_YWlSYhWUqflgjf9pm5GSbSB3GeVa3SrvfQjyQkJRX7C-18LCIVrjr3gwevKH-yWsbrcorOQ1Z5GakkTh3vAYxG0W2aCa9oTQdBv9BikGdJ7yWTBgt53tDhq8IGeK9wd9rK6cBQdMRDIdj9Ev1uTerPAbhHgDslUD1RdRb8CboqRcP9eUXO9BsfvPcTFw6RxRuBcxPK9ghz-xlQURVPfokMfs03cQhgoDaaopiX1z" alt="Julian Bardial"/>
            </div>
            <div>
              <p class="font-medium" style="color:var(--color-navy);">Julian Bardial</p>
              <p class="text-xs uppercase tracking-wider" style="color:var(--color-gray-6);">Director gerente</p>
            </div>
          </div>

          <?php if ($hasVideo): ?>
            <button type="button" class="video-modal-btn btn-outline-pill w-full justify-center mt-4">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="color:var(--color-gold-icon);" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg> Ver video tour
            </button>
          <?php endif; ?>
        </div>
      </aside>
    </div>

    <section class="mt-24">
      <div class="reveal flex flex-wrap justify-between items-end gap-6 mb-10">
        <div>
          <p class="eyebrow">Sigue explorando</p>
          <h2 class="font-display text-[38px] mt-4" style="color:var(--color-navy);">Propiedades similares</h2>
        </div>
        <a class="text-sm font-medium pb-1 border-b" style="color:var(--color-navy);border-color:var(--color-gold-line);" href="catalogo.php">Ver todas las propiedades</a>
      </div>
      <div class="reveal-group grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php $similares = array_filter($properties, function($sp) use ($propId) { return $sp['id'] !== $propId; }); ?>
        <?php $similares = array_slice(array_values($similares), 0, 3); ?>
        <?php foreach ($similares as $sp): ?>
          <a href="detalles.php?id=<?php echo (int)$sp['id']; ?>" class="property-card reveal group block">
            <div class="relative h-[260px] overflow-hidden rounded-2xl rounded-tr-[5rem]" style="background:var(--color-beige-icon);">
              <img class="property-img w-full h-full object-cover" src="<?php echo htmlspecialchars($sp['img']); ?>" alt="<?php echo htmlspecialchars($sp['location']); ?>"/>
              <span class="card-label"><?php echo htmlspecialchars(bardial_category_for($sp['type'] ?? '')); ?></span>
              <span class="card-btn absolute bottom-5 right-5"><svg class="arrow-rotate" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg></span>
            </div>
            <div class="px-1 pt-5">
              <p class="text-xs" style="color:var(--color-gray-7);"><?php echo htmlspecialchars($sp['city'] ?: $sp['location']); ?></p>
              <div class="mt-2 flex items-start justify-between gap-4">
                <h3 class="font-display text-[24px] leading-tight" style="color:var(--color-navy);"><?php echo htmlspecialchars($sp['location']); ?></h3>
                <p class="text-sm font-semibold pt-2 whitespace-nowrap" style="color:var(--color-gold-price);"><?php echo htmlspecialchars($sp['price']); ?></p>
              </div>
              <div class="mt-3 pt-3 border-t text-xs flex flex-wrap gap-x-5" style="border-color:var(--color-beige-border);color:var(--color-gray-6);">
                <span><?php echo (int)$sp['bed']; ?> recámaras</span>
                <span><?php echo (int)$sp['bath']; ?> baños</span>
                <span><?php echo (int)$sp['sqm']; ?> m²</span>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </section>
  </div>
</main>

<script>
var lightboxImages = <?php echo json_encode(array_values($galleryImages), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
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
  if (!lightboxImages.length) return;
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
(function () {
  var form = document.getElementById('agentForm');
  if (!form) return;
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var status = document.getElementById('agentStatus');
    if (status) status.textContent = 'Gracias. Te contactaremos pronto.';
    form.reset();
  });
})();
</script>

<?php if ($hasVideo): ?>
  <div class="video-modal-overlay" id="videoModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(9,29,48,.94);align-items:center;justify-content:center;padding:2rem;">
    <div style="position:relative;width:100%;max-width:1100px;background:#000;">
      <button class="video-modal-close" style="position:absolute;top:-44px;right:0;background:none;border:none;color:#fff;font-size:2rem;cursor:pointer;padding:4px 12px;line-height:1;" aria-label="Cerrar video">&times;</button>
      <video class="w-full max-h-[80vh] object-contain bg-black" controls preload="auto" id="modalVideo">
        <source src="assets/videos/<?php echo htmlspecialchars($property['video'] ?? ''); ?>" type="video/mp4">
      </video>
    </div>
  </div>
  <script>
  (function(){
    var btn = document.querySelector('.video-modal-btn');
    var modal = document.getElementById('videoModal');
    var closeBtn = modal.querySelector('.video-modal-close');
    var video = modal.querySelector('video');
    function openModal(){
      modal.classList.add('open');
      video.currentTime = 0;
      video.play();
    }
    function closeModal(){
      modal.classList.remove('open');
      video.pause();
      video.currentTime = 0;
    }
    window.openVideoTour = openModal;
    if (btn) btn.addEventListener('click', openModal);
    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', function(e){ if(e.target === modal) closeModal(); });
    document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeModal(); });
  })();
  </script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
