<?php $pageTitle = 'Contacto | Bardial Inmobiliaria'; $activePage = 'contacto'; $pageCss = 'contacto'; ?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>

<main class="flex-grow">
  <div class="container-bardial pt-32 pb-24 md:pb-32">
    <div class="reveal-group text-center max-w-3xl mx-auto mb-16">
      <p class="eyebrow justify-center reveal">Hablemos</p>
      <h1 class="contact-title reveal">Póngase en Contacto</h1>
      <p class="contact-intro reveal">Estamos a su disposición para asesorarle en la adquisición o venta de propiedades exclusivas. Complete el formulario o visítenos en nuestras oficinas.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
      <!-- Formulario -->
      <section class="lg:col-span-7 contact-panel reveal rounded-2xl rounded-tr-[8rem] p-8 md:p-12">
        <h2 class="contact-panel-title">Envíenos un Mensaje</h2>
        <form id="contactForm" class="mt-10 space-y-8" method="POST">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
              <label class="form-label" for="name">Nombre completo</label>
              <input class="input-line" id="name" name="name" placeholder="Nombre Completo" type="text" required/>
            </div>
            <div>
              <label class="form-label" for="email">Correo electrónico</label>
              <input class="input-line" id="email" name="email" placeholder="Correo Electrónico" type="email" required/>
            </div>
          </div>
          <div>
            <label class="form-label" for="phone">Teléfono</label>
            <input class="input-line" id="phone" name="phone" placeholder="Teléfono" type="tel"/>
          </div>
          <div>
            <label class="form-label" for="interest">Motivo de la consulta</label>
            <div class="relative">
              <select class="input-line appearance-none pr-8 cursor-pointer" id="interest" name="interest">
                <option disabled selected value="">Motivo de la consulta</option>
                <option value="buy">Comprar Propiedad</option>
                <option value="sell">Vender Propiedad</option>
                <option value="rent">Alquiler de Lujo</option>
                <option value="other">Otros</option>
              </select>
              <svg class="absolute right-0 bottom-4 pointer-events-none" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </div>
          <div>
            <label class="form-label" for="message">Mensaje</label>
            <textarea class="input-line resize-none" id="message" name="message" placeholder="Mensaje..." rows="4" required></textarea>
          </div>
          <p id="contactStatus" class="contact-status" role="status" aria-live="polite"></p>
          <button type="submit" class="btn-primary-pill">
            Enviar Consulta
            <svg class="arrow-rotate" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>
          </button>
        </form>
      </section>

      <!-- Datos directos -->
      <aside class="lg:col-span-5 reveal flex flex-col gap-8" style="--reveal-delay:120ms;">
        <div class="contact-panel rounded-2xl p-8 h-full">
          <h3 class="contact-panel-title !text-[24px]">Contacto Directo</h3>
          <div class="mt-8 space-y-6">
            <a class="contact-detail" href="mailto:info@bardial.com">
              <span class="contact-detail-icon"><span class="material-symbols-outlined">mail</span></span>
              <span>
                <span class="contact-detail-label">Email</span>
                <span class="contact-detail-value">info@bardial.com</span>
              </span>
            </a>
            <a class="contact-detail" href="tel:+34900123456">
              <span class="contact-detail-icon"><span class="material-symbols-outlined">call</span></span>
              <span>
                <span class="contact-detail-label">Teléfono Central</span>
                <span class="contact-detail-value">+34 900 123 456</span>
              </span>
            </a>
          </div>
          <h3 class="contact-panel-title !text-[24px] mt-12">Síganos</h3>
          <div class="flex gap-3 mt-6">
            <a aria-label="Instagram" class="contact-social" href="#"><span class="material-symbols-outlined">photo_camera</span></a>
            <a aria-label="LinkedIn" class="contact-social" href="#"><span class="material-symbols-outlined">work</span></a>
            <a aria-label="Facebook" class="contact-social" href="#"><span class="material-symbols-outlined">public</span></a>
          </div>
          <div class="contact-note">
            <p>Un asesor de Bardial responderá su consulta a la brevedad. Para visitas presenciales, le recomendamos agendar cita con anticipación.</p>
          </div>
        </div>
      </aside>
    </div>

  </div>
</main>

<?php include 'includes/footer.php'; ?>
