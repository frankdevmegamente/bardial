<?php $pageTitle = 'Nosotros | Bardial Inmobiliaria'; $activePage = 'nosotros'; $pageCss = 'about'; ?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>

<main class="flex-grow">
  <!-- Hero -->
  <section class="about-hero relative flex items-center overflow-hidden">
    <div class="about-hero-overlay"></div>
    <div class="reveal-group container-bardial relative z-10 pt-32 pb-24 text-center">
      <p class="about-hero-eyebrow reveal">Bardial · desde 2004</p>
      <h1 class="about-hero-title reveal">Elevando el Estándar<br/><em>del Lujo Inmobiliario</em></h1>
      <p class="about-hero-copy reveal">Redefiniendo la exclusividad y la discreción en el mercado de propiedades de alto valor desde 2004. Nuestra misión es conectar a individuos exigentes con espacios extraordinarios.</p>
      <a href="#historia" class="about-hero-btn reveal">
        Descubre Nuestra Historia
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 5v14M6 13l6 6 6-6"/></svg>
      </a>
    </div>
  </section>

  <!-- Historia -->
  <section id="historia" class="py-24 md:py-32" style="background:var(--color-cream);">
    <div class="container-bardial">
      <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-16 items-center">
        <div class="reveal md:col-span-5 order-1 md:order-1">
          <p class="eyebrow">Nuestra Historia</p>
          <h2 class="about-section-title mt-6">Un Legado de Excelencia desde 2004</h2>
          <div class="about-rule"></div>
          <p class="about-copy">Fundada en los principios de integridad, discreción y un conocimiento inigualable del mercado, Bardial Inmobiliaria comenzó como una boutique enfocada en propiedades patrimoniales. A lo largo de casi dos décadas, hemos cultivado relaciones basadas en la confianza absoluta, gestionando las carteras inmobiliarias de las familias más distinguidas.</p>
          <p class="about-copy">Nuestro crecimiento ha sido deliberado y medido, asegurando que cada transacción reciba la atención meticulosa que exige el sector del lujo. No solo vendemos propiedades; asesoramos en la adquisición de activos que trascienden generaciones.</p>
          <div class="about-stats">
            <div>
              <p class="about-stat-value">€2B+</p>
              <p class="about-stat-label">Volumen Gestionado</p>
            </div>
            <div>
              <p class="about-stat-value">150+</p>
              <p class="about-stat-label">Propiedades Exclusivas</p>
            </div>
          </div>
        </div>
        <div class="md:col-span-6 md:col-start-7 order-2 md:order-2 relative">
          <div class="about-photo reveal reveal--arch overflow-hidden rounded-2xl rounded-tr-[10rem]">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCrbi-zU4Ghzlhe0xELEDmDYIlkn2bVAr4JgPICeTSACNRxY43jzCPFu35KcTpmAbnLsMWS_ZHe5_Cdp7VRYA8bEG-TnvMO0m47CBLQJQPFBYzR3Mi7-DMVVSz6_0h52GV23clPDTOjLBEmLULpZLk6LExw5LeFwDeR_qHry4CiX0WBlRfi5bZA0kGS8wH-Vg8sSIoy68wYCgAOKmhc0nrKVdG29vrIaO5IBlHAjj3RvF4YfxkRFkCkXov-zxLV03zhqDbLcuH9YWdx" alt="Planos arquitectónicos sobre un escritorio de roble oscuro con una maqueta de villa al fondo"/>
          </div>
          <div class="about-badge reveal hidden md:flex" style="--reveal-delay:300ms;">
            <span>20</span>
            <span>Años de<br/>Experiencia</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Valores -->
  <section class="py-24 md:py-32" style="background:var(--color-cream-alt);">
    <div class="container-bardial">
      <div class="reveal text-center max-w-3xl mx-auto mb-16">
        <p class="eyebrow justify-center">Nuestros Valores</p>
        <h2 class="about-section-title mt-5">Nuestros Valores Fundamentales</h2>
        <div class="about-rule mx-auto"></div>
        <p class="about-copy mt-5">Los pilares que sostienen cada interacción, negociación y asesoramiento en Bardial Inmobiliaria.</p>
      </div>
      <div class="reveal-group grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 items-start">
        <article class="about-value-card reveal">
          <div class="flex items-start justify-between">
            <span class="about-value-icon"><span class="material-symbols-outlined">domain_verification</span></span>
            <span class="about-value-num">01</span>
          </div>
          <h3>Profesionalismo Riguroso</h3>
          <p>Abordamos cada cartera inmobiliaria con la misma disciplina analítica que los activos financieros. Nuestro equipo posee una profunda comprensión técnica, legal y comercial del mercado de alto standing.</p>
        </article>
        <article class="about-value-card about-value-card--raised reveal">
          <div class="flex items-start justify-between">
            <span class="about-value-icon"><span class="material-symbols-outlined">lock</span></span>
            <span class="about-value-num">02</span>
          </div>
          <h3>Confidencialidad Absoluta</h3>
          <p>Entendemos que la privacidad es el máximo lujo. Operamos bajo estrictos protocolos de discreción, protegiendo la identidad y los intereses de nuestros clientes en todo momento y en cada transacción.</p>
        </article>
        <article class="about-value-card reveal">
          <div class="flex items-start justify-between">
            <span class="about-value-icon"><span class="material-symbols-outlined">public</span></span>
            <span class="about-value-num">03</span>
          </div>
          <h3>Visión Global</h3>
          <p>Mientras nuestras raíces son profundas localmente, nuestro alcance es internacional. Conectamos capital global con oportunidades exclusivas, ofreciendo una perspectiva macroeconómica en inversiones inmobiliarias.</p>
        </article>
      </div>
    </div>
  </section>

  <!-- Cierre -->
  <section class="py-20 md:py-24" style="background:var(--color-navy);">
    <div class="reveal container-bardial flex flex-col md:flex-row items-center justify-between gap-8">
      <div>
        <p class="about-cta-eyebrow">Hablemos</p>
        <h2 class="about-cta-title">Tu próximo espacio comienza aquí.</h2>
      </div>
      <a href="contacto.php" class="btn-primary-pill">Agenda una cita <svg class="arrow-rotate" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg></a>
    </div>
  </section>
</main>

<?php include 'includes/footer.php'; ?>
