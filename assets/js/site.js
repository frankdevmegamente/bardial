(function () {
  'use strict';

  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  ready(function () {
    var menuBtn = document.getElementById('mobileMenuBtn');
    var mobileMenu = document.getElementById('mobileMenu');
    if (menuBtn && mobileMenu) {
      menuBtn.addEventListener('click', function () {
        var open = !mobileMenu.classList.contains('hidden');
        mobileMenu.classList.toggle('hidden', open);
        menuBtn.classList.toggle('open', !open);
        menuBtn.setAttribute('aria-expanded', String(!open));
      });
      mobileMenu.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', function () {
          mobileMenu.classList.add('hidden');
          menuBtn.classList.remove('open');
          menuBtn.setAttribute('aria-expanded', 'false');
        });
      });
    }

    var observer = new MutationObserver(function () {
      var open = document.querySelector('dialog[open]');
      document.body.classList.toggle('dialog-open', !!open);
    });
    observer.observe(document.body, { childList: true, subtree: true, attributes: true });

    document.querySelectorAll('[data-open-catalog]').forEach(function (btn) {
      btn.addEventListener('click', function (e) {
        e.preventDefault();
        var cat = btn.getAttribute('data-open-catalog') || 'Todas';
        var dlg = document.getElementById('catalogModal');
        if (!dlg) return;
        if (typeof dlg.showModal === 'function') dlg.showModal();
        dlg.dispatchEvent(new CustomEvent('catalog:open', { detail: { category: cat } }));
      });
    });

    // Demo del formulario de contacto (sin backend).
    var form = document.getElementById('contactForm');
    if (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        var status = document.getElementById('contactStatus');
        if (status) status.textContent = 'Gracias. Hemos recibido tu mensaje.';
        form.reset();
      });
    }
  });
})();
