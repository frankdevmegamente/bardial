<?php $pageTitle = 'Contacto | Bardial Inmobiliaria'; $activePage = 'contacto'; ?>
<?php include 'includes/head.php'; ?>
<?php include 'includes/header.php'; ?>

<main class="max-w-[1800px] mx-auto px-margin-mobile md:px-margin-desktop py-section-gap">
<div class="mb-section-gap text-center max-w-3xl mx-auto">
<h1 class="font-display-lg text-display-lg text-primary mb-6">Póngase en Contacto</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant">
            Estamos a su disposición para asesorarle en la adquisición o venta de propiedades exclusivas. Complete el formulario o visítenos en nuestras oficinas.
        </p>
</div>
<div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
<div class="md:col-span-7 tonal-card p-8 md:p-12 relative overflow-hidden">
<h2 class="font-headline-md text-headline-md text-primary mb-8">Envíenos un Mensaje</h2>
<form action="#" class="space-y-8 relative z-10" method="POST">
<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
<div class="relative">
<input class="input-line w-full pb-2 font-body-md text-on-surface" id="name" name="name" placeholder="Nombre Completo" required="" type="text"/>
</div>
<div class="relative">
<input class="input-line w-full pb-2 font-body-md text-on-surface" id="email" name="email" placeholder="Correo Electrónico" required="" type="email"/>
</div>
</div>
<div class="relative">
<input class="input-line w-full pb-2 font-body-md text-on-surface" id="phone" name="phone" placeholder="Teléfono" type="tel"/>
</div>
<div class="relative">
<select class="input-line w-full pb-2 font-body-md text-on-surface bg-transparent appearance-none" id="interest" name="interest">
<option disabled="" selected="" value="">Motivo de la consulta</option>
<option value="buy">Comprar Propiedad</option>
<option value="sell">Vender Propiedad</option>
<option value="rent">Alquiler de Lujo</option>
<option value="other">Otros</option>
</select>
<span class="material-symbols-outlined absolute right-0 top-0 pointer-events-none text-on-surface-variant">expand_more</span>
</div>
<div class="relative">
<textarea class="input-line w-full pb-2 font-body-md text-on-surface resize-none" id="message" name="message" placeholder="Mensaje..." required="" rows="4"></textarea>
</div>
<button class="bg-secondary-fixed-dim text-brand-navy font-title-lg text-title-lg uppercase px-8 py-4 w-full md:w-auto hover:brightness-110 transition-all" type="submit">
                    Enviar Consulta
                </button>
</form>
</div>
<div class="md:col-span-5 flex flex-col gap-gutter">
<div class="tonal-card p-8 flex-grow">
<h3 class="font-title-lg text-title-lg text-primary mb-6 uppercase">Contacto Directo</h3>
<div class="space-y-6">
<a class="flex items-center gap-4 group" href="mailto:info@bardial.com">
<div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary group-hover:bg-secondary-container transition-colors">
<span class="material-symbols-outlined" data-icon="mail">mail</span>
</div>
<div>
<p class="font-label-md text-label-md text-on-surface-variant uppercase">Email</p>
<p class="font-body-lg text-body-lg text-primary">info@bardial.com</p>
</div>
</a>
<a class="flex items-center gap-4 group" href="tel:+34900123456">
<div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center text-primary group-hover:bg-secondary-container transition-colors">
<span class="material-symbols-outlined" data-icon="call">call</span>
</div>
<div>
<p class="font-label-md text-label-md text-on-surface-variant uppercase">Teléfono Central</p>
<p class="font-body-lg text-body-lg text-primary">+34 900 123 456</p>
</div>
</a>
</div>
<h3 class="font-title-lg text-title-lg text-primary mt-12 mb-6 uppercase">Síganos</h3>
<div class="flex gap-4">
<a aria-label="Instagram" class="w-10 h-10 border border-outline-variant rounded flex items-center justify-center hover:bg-secondary-fixed-dim hover:text-brand-navy transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="photo_camera">photo_camera</span>
</a>
<a aria-label="LinkedIn" class="w-10 h-10 border border-outline-variant rounded flex items-center justify-center hover:bg-secondary-fixed-dim hover:text-brand-navy transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="work">work</span>
</a>
<a aria-label="Facebook" class="w-10 h-10 border border-outline-variant rounded flex items-center justify-center hover:bg-secondary-fixed-dim hover:text-brand-navy transition-colors" href="#">
<span class="material-symbols-outlined" data-icon="public">public</span>
</a>
</div>
</div>
</div>
</div>
<div class="mt-section-gap">
<h2 class="font-display-lg text-display-lg text-primary mb-12 text-center md:text-left">Nuestras Oficinas</h2>
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
<div class="tonal-card overflow-hidden group">
<div class="h-64 bg-surface-container-highest relative">
<img class="w-full h-full object-cover" data-alt="Fotografía arquitectónica profesional y altamente detallada del exterior de una moderna oficina inmobiliaria de lujo en Madrid. El edificio presenta líneas limpias, amplios ventanales de suelo a techo y un elegante revestimiento de piedra en un estilo corporativo de alta gama. La escena está bañada por una luz natural brillante y suave, transmitiendo una atmósfera exclusiva, sofisticada y señorial, acorde con una agencia de propiedades de lujo española." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAeFU06mdTOnVkYGDPtxUMeryIqwYOqaNM9S_MCeGt7gLVnvgDE6iQ7PnVqboU2viMZZhh3u-neegdbQ2WnMFMd8daKh4OniJ0JM78zpM0LtIZNt5meQkkfnXMevn5h3PzCQCuWBQGHa2qvIRWK0bC2qWoswMUc8oacHZoDcuBajkuxBFNLfPNIbO13CK8R6-IheNHdGoxe7qW89KyK29T12EHrzMqiqo5WTKgSpSC3YWlifyAJEXACzXWua8At4FwH-3J_W8oYjerI"/>
<div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-500"></div>
<div class="absolute top-4 right-4 bg-secondary-fixed-dim text-brand-navy font-label-md px-3 py-1 uppercase text-xs">Sede Central</div>
</div>
<div class="p-8">
<h3 class="font-headline-md text-headline-md text-primary mb-2">Madrid</h3>
<p class="font-body-md text-on-surface-variant mb-6">Calle de Serrano, 45, 28001 Madrid, España</p>
<div class="flex flex-wrap gap-4 mt-auto">
<a class="font-label-md text-label-md text-primary uppercase border-b-2 border-transparent hover:border-secondary-fixed-dim transition-colors flex items-center gap-2" href="#">
<span class="material-symbols-outlined text-sm" data-icon="map">map</span> Ver Mapa
                            </a>
<a class="font-label-md text-label-md text-primary uppercase border-b-2 border-transparent hover:border-secondary-fixed-dim transition-colors flex items-center gap-2" href="tel:+34910000000">
<span class="material-symbols-outlined text-sm" data-icon="phone">phone</span> +34 910 000 000
                            </a>
</div>
</div>
</div>
<div class="tonal-card overflow-hidden group">
<div class="h-64 bg-surface-container-highest relative">
<img class="w-full h-full object-cover" data-alt="Fotografía arquitectónica profesional y altamente detallada del exterior de una oficina inmobiliaria costera de lujo en Marbella. La estructura presume un diseño minimalista moderno y nítido con paredes de estuco blanco, grandes paneles de vidrio y un sutil paisajismo mediterráneo. La iluminación es brillante y soleada, creando un ambiente de alto contraste, prestigioso y acogedor para inversores adinerados en el sur de España." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDXIL1kZcAoruH9dnB5Zkgwpoq2vNto2b7WDPMhxbfaHeMOtuyoNPJUFHFr8DvOpZIjFtRo-s117vUrjZpJQtidrmQ70mo_zyTUFklYzALelnFC2C27mvsQh3LITEk4Gdnu4H1YnlP4DAQISL1hp_sboU1NoARM7G9NzJSPEKeBnVbSJY42RHG46SBuYVhRQBiwFMJqp644OhCGZiyfEqQJLVw775wtrKftUuZtI4zEJ2NqaQMqU21-9EDiUbEM2ovYGYJFcxaRr1x8"/>
<div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors duration-500"></div>
<div class="absolute top-4 right-4 bg-secondary-fixed-dim text-brand-navy font-label-md px-3 py-1 uppercase text-xs">Costa del Sol</div>
</div>
<div class="p-8">
<h3 class="font-headline-md text-headline-md text-primary mb-2">Marbella</h3>
<p class="font-body-md text-on-surface-variant mb-6">Bulevar Príncipe Alfonso von Hohenlohe, s/n, 29602 Marbella, Málaga, España</p>
<div class="flex flex-wrap gap-4 mt-auto">
<a class="font-label-md text-label-md text-primary uppercase border-b-2 border-transparent hover:border-secondary-fixed-dim transition-colors flex items-center gap-2" href="#">
<span class="material-symbols-outlined text-sm" data-icon="map">map</span> Ver Mapa
                            </a>
<a class="font-label-md text-label-md text-primary uppercase border-b-2 border-transparent hover:border-secondary-fixed-dim transition-colors flex items-center gap-2" href="tel:+34950000000">
<span class="material-symbols-outlined text-sm" data-icon="phone">phone</span> +34 950 000 000
                            </a>
</div>
</div>
</div>
</div>
</div>
</main>

<?php include 'includes/footer.php'; ?>
