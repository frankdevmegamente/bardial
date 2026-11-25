<?php $pageTitle = 'Bardial Inmobiliaria | Inmobiliaria de Lujo'; $activePage = 'inicio'; $pageCss = 'home'; ?>
<?php include 'includes/properties.php'; ?>
<?php include 'includes/categories.php'; ?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>

<?php
$categories = BARDIAL_CATEGORIES;
$destacadas = array_slice($properties, 0, 3);
$catalogProperties = bardial_with_categories($properties);
?>

<main class="flex-grow">

  <!-- ==================== HERO ==================== -->
  <section id="inicio" class="relative overflow-hidden pt-24" style="min-height:840px;">
    <div class="pointer-events-none absolute rounded-full" style="width:384px;height:384px;left:-112px;top:160px;border:1px solid rgba(199,168,106,.25);"></div>
    <div class="pointer-events-none absolute rounded-full" style="width:256px;height:256px;left:-40px;top:224px;border:1px solid rgba(199,168,106,.2);"></div>

    <div class="container-bardial grid grid-cols-1 lg:grid-cols-[0.93fr_1.07fr] gap-12 items-center py-12">
      <div class="reveal-group relative z-10 max-w-[672px] py-8 lg:py-20">
        <p class="eyebrow-inline reveal">Patrimonio que se siente hogar</p>
        <h1 class="font-display reveal" style="font-size:clamp(3.7rem,7vw,7rem);line-height:.88;letter-spacing:-.045em;color:var(--color-navy);">
          Espacios para
          <em class="block mt-2" style="color:var(--color-gold);font-style:italic;">vivir y crecer.</em>
        </h1>
        <p class="reveal mt-8 text-base md:text-lg leading-7" style="max-width:512px;color:var(--color-gray-1);">
          Encontramos el lugar que acompaña tu historia. Casas residenciales, bodegas, locales comerciales y departamentos elegidos con atención y propósito.
        </p>
        <div class="reveal mt-10 flex flex-wrap gap-4">
          <a href="#propiedades" class="btn-primary-pill">
            Explorar propiedades
            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
          </a>
          <a href="#servicios" class="btn-ghost-underline">Conoce nuestro enfoque</a>
        </div>
        <div class="reveal mt-14 flex flex-wrap gap-10 sm:gap-16 pt-7 border-t" style="border-color:var(--color-beige-border-3);">
          <div><p class="font-display text-[30px]" style="color:var(--color-navy);">12+</p><p class="text-xs mt-1" style="color:var(--color-gray-5);">Años de experiencia</p></div>
          <div><p class="font-display text-[30px]" style="color:var(--color-navy);">460</p><p class="text-xs mt-1" style="color:var(--color-gray-5);">Operaciones exitosas</p></div>
        </div>
      </div>

      <div class="relative min-h-[520px] lg:min-h-[700px]">
        <div class="hero-arch reveal reveal--arch absolute inset-0 overflow-hidden">
          <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=82&amp;w=1800" alt="Casa contemporánea de concreto claro rodeada de vegetación" class="w-full h-full object-cover"/>
          <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(7,24,39,.35) 0%, transparent 50%, rgba(247,244,237,.05) 100%);"></div>
        </div>
        <div class="reveal absolute -bottom-6 -left-4 sm:-left-8 flex items-center gap-4 p-4 pr-6 rounded-2xl" style="--reveal-delay:360ms;background:rgba(247,244,237,.95);backdrop-filter:blur(4px);box-shadow:0 20px 50px rgba(43,55,47,.14);">
          <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0" style="background:var(--color-beige-icon);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-gold)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="15" r="4"/><path d="M11 15h9v-2h-2v-2h-2v2h-2m-3 2V9l2-2"/></svg>
          </div>
          <div>
            <p class="text-[10.4px] uppercase" style="letter-spacing:.2em;color:#80776b;">Nueva propiedad</p>
            <p class="text-sm font-medium mt-1" style="color:var(--color-navy-footer);">Casa Roble · En venta</p>
          </div>
        </div>
        <svg class="absolute -right-14 bottom-8 w-[208px] h-[144px] pointer-events-none opacity-70" viewBox="0 0 220 140" fill="none" stroke="#fff" stroke-width="1.2" aria-hidden="true">
          <path d="M5 135V85h30v50M35 135V65h30v70M65 135V95h30v40M100 135V70h40v65M140 135V50h40v85M180 135V90h35v45M5 135h210"/>
          <path d="M15 85l5-10 5 10M45 65l5-10 5 10M110 70l10-10 10 10M150 50l10-10 10 10M190 90l7-8 8 8"/>
        </svg>
        <p class="absolute bottom-4 right-5 text-[9.6px] text-white/70">Foto: Avi Werde / Unsplash</p>
      </div>
    </div>
  </section>

  <!-- ==================== PROPIEDADES DESTACADAS ==================== -->
  <section id="propiedades" style="background:var(--color-cream-alt);padding:96px 0;">
    <div class="container-bardial">
      <div class="reveal-group flex flex-col lg:flex-row lg:items-end justify-between gap-8">
        <div class="reveal">
          <p class="eyebrow">Selección Bardial</p>
          <h2 class="section-title mt-5">Propiedades <em class="block" style="color:var(--color-gold);font-style:italic;">destacadas</em></h2>
        </div>
        <p class="reveal max-w-[448px] text-sm leading-6" style="color:var(--color-gray-2);">Una colección cuidada de espacios con ubicación, arquitectura y valor a largo plazo.</p>
      </div>

      <div class="reveal-group mt-10 flex flex-wrap gap-x-8 gap-y-3 py-4 border-t border-b" style="border-color:var(--color-beige-border);">
        <?php foreach ($categories as $cat): ?>
          <button type="button" class="cat-bar-btn reveal flex items-center gap-2 text-xs uppercase" style="letter-spacing:.16em;color:var(--color-gray-2);" data-open-catalog="<?php echo htmlspecialchars($cat); ?>" aria-haspopup="dialog">
            <?php echo htmlspecialchars($cat); ?>
            <svg class="arrow-rotate" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="reveal-group mt-14 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($destacadas as $i => $p): ?>
          <a href="detalles.php?id=<?php echo (int)$p['id']; ?>" class="property-card reveal group block <?php echo $i === 1 ? 'reveal--offset lg:translate-y-8' : ''; ?>">
            <div class="relative h-[380px] overflow-hidden rounded-2xl rounded-tr-[5rem]" style="background:var(--color-beige-icon);">
              <img src="<?php echo htmlspecialchars($p['img']); ?>" alt="<?php echo htmlspecialchars($p['location']); ?>" class="property-img w-full h-full object-cover"/>
              <span class="card-label"><?php echo htmlspecialchars(bardial_category_for($p['type'] ?? '')); ?></span>
              <span class="card-btn absolute bottom-5 right-5">
                <svg class="arrow-rotate" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
              </span>
            </div>
            <div class="px-1 pt-6">
              <p class="text-xs" style="color:var(--color-gray-7);"><?php echo htmlspecialchars($p['city'] ?: $p['location']); ?></p>
              <div class="mt-2 flex items-start justify-between gap-4">
                <h3 class="font-display text-[30px] leading-tight" style="color:var(--color-navy);"><?php echo htmlspecialchars($p['location']); ?></h3>
                <p class="text-sm font-semibold pt-2 whitespace-nowrap" style="color:var(--color-gold-price);"><?php echo htmlspecialchars($p['price']); ?></p>
              </div>
              <div class="mt-3 pt-3 border-t text-xs flex flex-wrap gap-x-5 gap-y-1" style="border-color:var(--color-beige-border);color:var(--color-gray-6);">
                <span><?php echo (int)$p['bed']; ?> recámaras</span>
                <span><?php echo (int)$p['bath']; ?> baños</span>
                <span><?php echo (int)$p['sqm']; ?> m²</span>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>

      <div class="reveal mt-20 lg:mt-28 text-center">
        <button type="button" class="inline-flex items-center gap-4 text-sm font-semibold pb-2 border-b" style="border-color:var(--color-gold-text);color:var(--color-navy);" data-open-catalog="Todas" aria-haspopup="dialog">
          Ver todas las propiedades
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
        </button>
      </div>
    </div>
  </section>

  <!-- ==================== SERVICIOS ==================== -->
  <section id="servicios" style="padding:96px 0;">
    <div class="container-bardial grid grid-cols-1 lg:grid-cols-[0.75fr_1.25fr] gap-12">
      <div class="reveal">
        <p class="eyebrow">Lo hacemos simple</p>
        <h2 class="section-title mt-5">Decisiones seguras,<em class="block" style="color:var(--color-gold);font-style:italic;">de principio a fin.</em></h2>
        <p class="mt-7 max-w-[384px] text-sm leading-7" style="color:var(--color-gray-3);">Más que inmuebles, construimos relaciones transparentes para que el proceso sea tan valioso como el resultado.</p>
      </div>
      <div class="reveal-group grid grid-cols-1 sm:grid-cols-2 border-t" style="border-color:var(--color-beige-border-3);">
        <div class="service-card reveal">
          <div class="flex items-start justify-between">
            <span class="text-xs" style="color:var(--color-gray-10);">01</span>
            <svg class="service-icon" width="40" height="40" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="18" r="6"/><path d="M16 18h13v-3h-3v-3h-3v3h-3m-5 3V10l3-3"/></svg>
          </div>
          <h3 class="font-display text-[30px] mt-12" style="color:var(--color-navy);">Compra y venta</h3>
          <p class="mt-4 text-sm leading-6 max-w-[320px]" style="color:var(--color-gray-4);">Te acompañamos en cada paso para encontrar o colocar una propiedad con claridad y confianza.</p>
        </div>
        <div class="service-card reveal">
          <div class="flex items-start justify-between">
            <span class="text-xs" style="color:var(--color-gray-10);">02</span>
            <svg class="service-icon" width="40" height="40" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 28V9l11-5 11 5v19M5 28h22M11 14h3m4 0h3M11 19h3m4 0h3M11 24h3m4 0h3"/></svg>
          </div>
          <h3 class="font-display text-[30px] mt-12" style="color:var(--color-navy);">Renta de espacios</h3>
          <p class="mt-4 text-sm leading-6 max-w-[320px]" style="color:var(--color-gray-4);">Casas residenciales, bodegas, locales comerciales y departamentos seleccionados de acuerdo con tus necesidades.</p>
        </div>
        <div class="service-card reveal">
          <div class="flex items-start justify-between">
            <span class="text-xs" style="color:var(--color-gray-10);">03</span>
            <svg class="service-icon" width="40" height="40" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 28h22M9 28V18h4v10M15 28V10h4v18M21 28V14h4v14"/></svg>
          </div>
          <h3 class="font-display text-[30px] mt-12" style="color:var(--color-navy);">Valuación inmobiliaria</h3>
          <p class="mt-4 text-sm leading-6 max-w-[320px]" style="color:var(--color-gray-4);">Análisis preciso del mercado para definir el valor real y competitivo de tu inmueble.</p>
        </div>
        <div class="service-card reveal">
          <div class="flex items-start justify-between">
            <span class="text-xs" style="color:var(--color-gray-10);">04</span>
            <svg class="service-icon" width="40" height="40" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="16" cy="16" r="12"/><path d="M20 12l-2.5 7.5L10 22l2.5-7.5L20 12z"/></svg>
          </div>
          <h3 class="font-display text-[30px] mt-12" style="color:var(--color-navy);">Asesoría integral</h3>
          <p class="mt-4 text-sm leading-6 max-w-[320px]" style="color:var(--color-gray-4);">Soporte legal, financiero y comercial para que cada decisión se sienta sencilla y segura.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== QUIÉNES SOMOS ==================== -->
  <section id="nosotros" class="relative overflow-hidden" style="background:var(--color-navy-deep);color:var(--fg-on-dark);">
    <div class="grid grid-cols-1 lg:grid-cols-2 mx-auto" style="max-width:var(--container-max);">
      <div class="reveal reveal--arch relative min-h-[500px] lg:min-h-[720px]">
        <img src="https://images.unsplash.com/photo-1558661091-5cc1b64d0dc5?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=82&amp;w=1200" alt="Detalle arquitectónico de una residencia contemporánea" class="absolute inset-0 w-full h-full object-cover opacity-80"/>
        <div class="absolute inset-0" style="background:rgba(9,30,49,.2);"></div>
        <div class="absolute bottom-8 left-8 max-w-[220px] rounded-xl p-5" style="background:#f7f1e5;color:var(--color-navy-footer);">
          <span class="font-display block text-[36px] leading-none">“</span>
          <p class="text-sm leading-6 -mt-3">Cada espacio tiene una historia. Nuestra labor es ayudarte a encontrar la tuya.</p>
        </div>
      </div>
      <div class="reveal relative flex flex-col justify-center px-6 py-20 lg:px-20 lg:py-24">
        <svg class="absolute -right-20 top-10 w-[288px] h-[288px] pointer-events-none" viewBox="0 0 280 280" fill="none" stroke="#fff" stroke-opacity=".1" aria-hidden="true"><circle cx="140" cy="140" r="100"/><circle cx="140" cy="140" r="135"/></svg>
        <div class="relative max-w-[576px]">
          <p class="text-[11.2px] font-semibold uppercase" style="letter-spacing:.26em;color:var(--color-gold-eyebrow-dark);">Quiénes somos</p>
          <h2 class="font-display mt-6" style="font-size:clamp(3rem,5vw,5.3rem);line-height:.96;letter-spacing:-.035em;">Cercanía, criterio y visión.</h2>
          <p class="mt-8 text-base leading-8" style="color:#eef1f3;">Somos una firma inmobiliaria que combina conocimiento local, sensibilidad arquitectónica y una forma más humana de hacer negocios.</p>
          <p class="mt-5 text-sm leading-7" style="color:#cbd4db;">Desde 2012 acompañamos a familias, inversionistas y empresas a tomar decisiones patrimoniales con información clara, atención personal y absoluto cuidado por los detalles.</p>
          <ul class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-5 pt-8 border-t" style="border-color:rgba(255,255,255,.2);">
            <li class="flex items-center gap-2 text-sm"><span class="w-1.5 h-1.5 rounded-full shrink-0" style="background:var(--color-gold-dark);"></span>Asesoría honesta</li>
            <li class="flex items-center gap-2 text-sm"><span class="w-1.5 h-1.5 rounded-full shrink-0" style="background:var(--color-gold-dark);"></span>Conocimiento local</li>
            <li class="flex items-center gap-2 text-sm"><span class="w-1.5 h-1.5 rounded-full shrink-0" style="background:var(--color-gold-dark);"></span>Atención personal</li>
            <li class="flex items-center gap-2 text-sm"><span class="w-1.5 h-1.5 rounded-full shrink-0" style="background:var(--color-gold-dark);"></span>Visión patrimonial</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== CONTACTO ==================== -->
  <section id="contacto" class="relative overflow-hidden" style="padding:96px 0;">
    <div class="pointer-events-none absolute rounded-full" style="width:544px;height:544px;bottom:-160px;right:-128px;border:1px solid rgba(193,163,103,.25);"></div>
    <div class="pointer-events-none absolute rounded-full" style="width:384px;height:384px;bottom:-96px;right:-64px;border:1px solid rgba(193,163,103,.25);"></div>
    <div class="relative mx-auto" style="max-width:1200px;padding:0 24px;">
      <div class="grid grid-cols-1 lg:grid-cols-[0.8fr_1.2fr] gap-16">
        <div class="reveal">
          <p class="eyebrow">Hablemos</p>
          <h2 class="section-title mt-5">Tu próximo espacio comienza aquí.</h2>
          <p class="mt-7 max-w-[384px] text-sm leading-7" style="color:var(--color-gray-2);">Cuéntanos qué estás buscando. Uno de nuestros asesores se pondrá en contacto contigo.</p>
          <div class="mt-10 space-y-5">
            <div><p class="text-xs" style="color:var(--color-gray-9);">Teléfono</p><a href="tel:+525555481290" class="block mt-1 font-medium" style="color:var(--color-navy);">+52 55 5548 1290</a></div>
            <div><p class="text-xs" style="color:var(--color-gray-9);">Correo</p><a href="mailto:info@bardial.com" class="block mt-1 font-medium" style="color:var(--color-navy);">info@bardial.com</a></div>
            <div><p class="text-xs" style="color:var(--color-gray-9);">Oficina</p><p class="mt-1 font-medium" style="color:var(--color-navy);">Ciudad de México, México</p></div>
          </div>
        </div>
        <form id="contactForm" class="reveal grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8" style="--reveal-delay:120ms;">
          <div>
            <label class="form-label" for="cf-name">Nombre completo</label>
            <input class="input-line" id="cf-name" name="name" type="text" placeholder="Escribe tu nombre" required/>
          </div>
          <div>
            <label class="form-label" for="cf-email">Correo electrónico</label>
            <input class="input-line" id="cf-email" name="email" type="email" placeholder="nombre@correo.com" required/>
          </div>
          <div>
            <label class="form-label" for="cf-phone">Teléfono</label>
            <input class="input-line" id="cf-phone" name="phone" type="tel" placeholder="+52 00 0000 0000" required/>
          </div>
          <div class="relative">
            <label class="form-label" for="cf-interest">Estoy interesado en</label>
            <select class="input-line appearance-none pr-6" id="cf-interest" name="interest">
              <option disabled selected value="">Selecciona una opción</option>
              <option value="buy">Comprar una propiedad</option>
              <option value="rent">Rentar una propiedad</option>
              <option value="sell">Vender mi propiedad</option>
              <option value="advisory">Valuación y asesoría</option>
            </select>
            <svg class="absolute right-0 bottom-4 pointer-events-none" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
          </div>
          <div class="sm:col-span-2">
            <label class="form-label" for="cf-message">Mensaje</label>
            <textarea class="input-line resize-none" id="cf-message" name="message" rows="3" placeholder="Cuéntanos un poco más..."></textarea>
          </div>
          <div class="sm:col-span-2 flex flex-wrap items-center gap-6">
            <button type="submit" class="btn-primary-pill" style="padding:16px 32px;">
              Enviar mensaje
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
            </button>
            <p id="contactStatus" class="text-sm" style="color:var(--color-gold);" role="status" aria-live="polite"></p>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

<!-- ==================== MODAL DE CATÁLOGO ==================== -->
<script type="application/json" id="catalogData"><?php echo json_encode($catalogProperties, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?></script>

<dialog id="catalogModal" class="modal-catalog" aria-labelledby="catalogTitle">
  <div class="flex items-start justify-between gap-6">
    <div>
      <p class="eyebrow">Colección Bardial</p>
      <h2 id="catalogTitle" class="font-display mt-5" style="font-size:clamp(2rem,4vw,3rem);color:var(--color-navy);">Todas las propiedades</h2>
    </div>
    <button type="button" id="catalogClose" class="w-11 h-11 rounded-full flex items-center justify-center shrink-0 transition-colors" style="border:1px solid rgba(176,138,71,.4);color:var(--color-navy);" aria-label="Cerrar catálogo">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18"/></svg>
    </button>
  </div>
  <div id="catalogFilters" class="flex flex-wrap gap-2 my-8" role="group" aria-label="Filtrar propiedades por categoría"></div>
  <p id="catalogCount" class="text-sm mb-6" style="color:var(--color-gray-2);" role="status"></p>
  <div id="catalogGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"></div>
  <div id="catalogEmpty" class="empty-state hidden">
    <h3 class="font-display text-[30px]" style="color:var(--color-navy);">Próximamente, nuevos espacios</h3>
    <p class="mt-4 text-sm leading-7 mx-auto" style="max-width:448px;color:var(--color-gray-2);">Por el momento no hay propiedades en esta categoría. Contáctanos para conocer opciones de acuerdo con tus necesidades.</p>
    <button type="button" class="btn-primary-pill mt-8" data-catalog-contact>Hablar con un asesor <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg></button>
  </div>
</dialog>

<script src="assets/js/modal-catalog.js"></script>
<?php include 'includes/footer.php'; ?>
