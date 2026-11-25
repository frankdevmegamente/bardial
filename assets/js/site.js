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

    // Tema claro / oscuro (guarda la elección del usuario).
    var themeBtn = document.getElementById('themeToggle');
    if (themeBtn) {
      var syncThemeButton = function () {
        var dark = document.documentElement.getAttribute('data-theme') === 'dark';
        var label = dark ? 'Activar modo claro' : 'Activar modo oscuro';
        themeBtn.setAttribute('aria-pressed', String(dark));
        themeBtn.setAttribute('aria-label', label);
        themeBtn.setAttribute('title', label);
      };
      syncThemeButton();
      themeBtn.addEventListener('click', function () {
        var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        try { localStorage.setItem('bardial-theme', next); } catch (e) {}
        syncThemeButton();
      });

      // Si no hay preferencia guardada, sigue los cambios del sistema.
      var systemTheme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)');
      if (systemTheme && systemTheme.addEventListener) {
        systemTheme.addEventListener('change', function (e) {
          try {
            if (localStorage.getItem('bardial-theme')) return;
          } catch (err) {}
          document.documentElement.setAttribute('data-theme', e.matches ? 'dark' : 'light');
          syncThemeButton();
        });
      }
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

    // Reveal on scroll.
    var revealTargets = document.querySelectorAll('.reveal, .reveal--arch, .reveal--line');
    var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!('IntersectionObserver' in window) || reduceMotion) {
      revealTargets.forEach(function (el) { el.classList.add('is-visible'); });
    } else {
      var revealObserver = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          entry.target.classList.add('is-visible');
          revealObserver.unobserve(entry.target);
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -10% 0px' });
      revealTargets.forEach(function (el) {
        // El hero y lo que ya está en pantalla se revelan de inmediato.
        var rect = el.getBoundingClientRect();
        if (el.closest('#inicio') || (rect.top < window.innerHeight * 0.95 && rect.bottom > 0)) {
          el.classList.add('is-visible');
        } else {
          revealObserver.observe(el);
        }
      });
    }
  });
})();
