<?php $pageTitle = 'Contacto | Bardial Inmobiliaria'; $activePage = 'contacto'; $pageCss = 'contacto'; ?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>

<main class="flex-grow">
  <div class="container-bardial pt-32 pb-24 md:pb-32">
    <div class="text-center max-w-3xl mx-auto mb-16">
      <p class="eyebrow justify-center">Hablemos</p>
      <h1 class="contact-title">Póngase en Contacto</h1>
      <p class="contact-intro">Estamos a su disposición para asesorarle en la adquisición o venta de propiedades exclusivas. Complete el formulario o visítenos en nuestras oficinas.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
      <!-- Formulario -->
      <section class="lg:col-span-7 contact-panel rounded-2xl rounded-tr-[8rem] p-8 md:p-12">
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
      <aside class="lg:col-span-5 flex flex-col gap-8">
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

    <!-- Oficinas -->
    <section class="mt-24 md:mt-32">
      <p class="eyebrow">Dónde estamos</p>
      <h2 class="contact-title mt-5" style="font-size:clamp(2.2rem,4vw,3.4rem);">Nuestras Oficinas</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
        <article class="contact-office overflow-hidden rounded-2xl">
          <div class="relative h-64 overflow-hidden rounded-t-2xl">
            <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAeFU06mdTOnVkYGDPtxUMeryIqwYOqaNM9S_MCeGt7gLVnvgDE6iQ7PnVqboU2viMZZhh3u-neegdbQ2WnMFMd8daKh4OniJ0JM78zpM0LtIZNt5meQkkfnXMevn5h3PzCQCuWBQGHa2qvIRWK0bC2qWoswMUc8oacHZoDcuBajkuxBFNLfPNIbO13CK8R6-IheNHdGoxe7qW89KyK29T12EHrzMqiqo5WTKgSpSC3YWlifyAJEXACzXWua8At4FwH-3J_W8oYjerI" alt="Exterior de la oficina inmobiliaria de lujo en Madrid"/>
            <span class="contact-office-tag">Sede Central</span>
          </div>
          <div class="p-8">
            <h3 class="contact-office-title">Madrid</h3>
            <p class="contact-office-address">Calle de Serrano, 45, 28001 Madrid, España</p>
            <div class="flex flex-wrap gap-x-6 gap-y-3 mt-6">
              <a class="contact-office-link" href="https://www.google.com/maps/search/?api=1&amp;query=Calle+de+Serrano+45+28001+Madrid" target="_blank" rel="noopener noreferrer"><span class="material-symbols-outlined !text-[16px]">map</span> Ver Mapa</a>
              <a class="contact-office-link" href="tel:+34910000000"><span class="material-symbols-outlined !text-[16px]">phone</span> +34 910 000 000</a>
            </div>
          </div>
        </article>
        <article class="contact-office overflow-hidden rounded-2xl">
          <div class="relative h-64 overflow-hidden rounded-t-2xl">
            <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDXIL1kZcAoruH9dnB5Zkgwpoq2vNto2b7WDPMhxbfaHeMOtuyoNPJUFHFr8DvOpZIjFtRo-s117vUrjZpJQtidrmQ70mo_zyTUFklYzALelnFC2C27mvsQh3LITEk4Gdnu4H1YnlP4DAQISL1hp_sboU1NoARM7G9NzJSPEKeBnVbSJY42RHG46SBuYVhRQBiwFMJqp644OhCGZiyfEqQJLVw775wtrKftUuZtI4zEJ2NqaQMqU21-9EDiUbEM2ovYGYJFcxaRr1x8" alt="Exterior de la oficina inmobiliaria de lujo en Marbella"/>
            <span class="contact-office-tag">Costa del Sol</span>
          </div>
          <div class="p-8">
            <h3 class="contact-office-title">Marbella</h3>
            <p class="contact-office-address">Bulevar Príncipe Alfonso von Hohenlohe, s/n, 29602 Marbella, Málaga, España</p>
            <div class="flex flex-wrap gap-x-6 gap-y-3 mt-6">
              <a class="contact-office-link" href="https://www.google.com/maps/search/?api=1&amp;query=Bulevar+Pr%C3%ADncipe+Alfonso+von+Hohenlohe+Marbella" target="_blank" rel="noopener noreferrer"><span class="material-symbols-outlined !text-[16px]">map</span> Ver Mapa</a>
              <a class="contact-office-link" href="tel:+34950000000"><span class="material-symbols-outlined !text-[16px]">phone</span> +34 950 000 000</a>
            </div>
          </div>
        </article>
      </div>
    </section>
  </div>
</main>

<?php include 'includes/footer.php'; ?>
