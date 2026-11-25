(function () {
  'use strict';

  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  ready(function () {
    var dialog = document.getElementById('catalogModal');
    if (!dialog) return;

    var dataEl = document.getElementById('catalogData');
    var properties = [];
    try { properties = JSON.parse(dataEl.textContent); } catch (e) { properties = []; }

    var allCategories = ['Todas', 'Casa residencial', 'Bodega', 'Local comercial', 'Departamento'];

    var title = document.getElementById('catalogTitle');
    var filters = document.getElementById('catalogFilters');
    var count = document.getElementById('catalogCount');
    var grid = document.getElementById('catalogGrid');
    var empty = document.getElementById('catalogEmpty');
    var current = 'Todas';

    function arrow(size) {
      return '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M13 6l6 6-6 6"/></svg>';
    }
    function esc(value) {
      return String(value == null ? '' : value).replace(/[&<>"']/g, function (c) {
        return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
      });
    }

    function renderFilters() {
      filters.innerHTML = '';
      allCategories.forEach(function (cat) {
        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'cat-pill' + (cat === current ? ' active' : '');
        btn.textContent = cat;
        btn.setAttribute('aria-pressed', String(cat === current));
        btn.addEventListener('click', function () { apply(cat); });
        filters.appendChild(btn);
      });
    }

    function cardHtml(p) {
      return '<article class="catalog-card group">' +
        '<div class="relative h-[256px] overflow-hidden rounded-2xl rounded-tr-[4rem]" style="background:#d8d1c5;">' +
          '<img src="' + esc(p.img) + '" alt="' + esc(p.location) + '" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>' +
          '<span class="catalog-label">' + esc(p.category || 'Casa residencial') + '</span>' +
        '</div>' +
        '<p class="mt-5 text-xs" style="color:#66727e;">' + esc(p.city || p.location) + '</p>' +
        '<h3 class="font-display text-[30px] leading-tight mt-1" style="color:#10263b;">' + esc(p.location) + '</h3>' +
        '<p class="text-sm font-semibold mt-2" style="color:#9a773b;">' + esc(p.price) + '</p>' +
        '<div class="mt-3 pt-3 border-t text-xs flex flex-wrap gap-x-4" style="border-color:#d3cab9;color:#747b80;">' +
          '<span>' + (Number(p.bed) || 0) + ' recámaras</span>' +
          '<span>' + (Number(p.bath) || 0) + ' baños</span>' +
          '<span>' + (Number(p.sqm) || 0) + ' m²</span>' +
        '</div>' +
        '<a href="#contacto" class="catalog-contact mt-5 inline-flex items-center gap-2 text-sm font-medium">' +
          'Consultar propiedad ' + arrow(16) +
        '</a>' +
      '</article>';
    }

    function closeAndContact(e) {
      if (e) e.preventDefault();
      if (dialog.open) dialog.close();
      window.setTimeout(function () {
        var target = document.getElementById('contacto');
        if (target) target.scrollIntoView({ behavior: 'smooth' });
      }, 50);
    }

    function apply(cat) {
      current = cat;
      title.textContent = cat === 'Todas' ? 'Todas las propiedades' : cat;
      renderFilters();
      var list = cat === 'Todas'
        ? properties
        : properties.filter(function (p) { return p.category === cat; });
      count.textContent = list.length + (list.length === 1 ? ' propiedad disponible' : ' propiedades disponibles');
      grid.innerHTML = list.map(cardHtml).join('');
      grid.classList.toggle('hidden', list.length === 0);
      empty.classList.toggle('hidden', list.length > 0);
      grid.querySelectorAll('.catalog-contact').forEach(function (a) {
        a.addEventListener('click', closeAndContact);
      });
    }

    document.getElementById('catalogClose').addEventListener('click', function () { dialog.close(); });
    dialog.addEventListener('click', function (e) { if (e.target === dialog) dialog.close(); });
    empty.querySelector('[data-catalog-contact]').addEventListener('click', closeAndContact);
    dialog.addEventListener('catalog:open', function (e) {
      apply((e.detail && e.detail.category) || 'Todas');
    });

    apply('Todas');
  });
})();
