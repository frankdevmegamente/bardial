<style>
.autocomplete-results {
  position: absolute; top: 100%; left: 0; right: 0; z-index: 999;
  background: #fff; border: 1px solid #d1d5db; border-top: none;
  max-height: 220px; overflow-y: auto; display: none;
  box-shadow: 0 4px 12px rgba(0,0,0,.1);
}
.autocomplete-results .result-item {
  padding: 8px 12px; cursor: pointer; font-size: .875rem; border-bottom: 1px solid #f3f4f6;
}
.autocomplete-results .result-item:hover,
.autocomplete-results .result-item.active {
  background: #fef9e7; color: #1e293b;
}
.autocomplete-results .result-item small {
  color: #6b7280; display: block; font-size: .75rem;
}
</style>
<script>
(function() {
  'use strict';

  function initNominatim(inputId, extraParams) {
    var input = document.getElementById(inputId);
    if (!input) return;

    var wrap = document.createElement('div');
    wrap.style.position = 'relative';
    input.parentNode.insertBefore(wrap, input);
    wrap.appendChild(input);

    var container = document.createElement('div');
    container.className = 'autocomplete-results';
    wrap.appendChild(container);

    var timer = null;
    var currentIdx = -1;

    input.addEventListener('input', function() {
      clearTimeout(timer);
      var q = this.value.trim();
      if (q.length < 2) { container.style.display = 'none'; return; }
      timer = setTimeout(function() { fetchResults(q); }, 350);
    });

    input.addEventListener('keydown', function(e) {
      var items = container.querySelectorAll('.result-item');
      if (items.length === 0) return;
      if (e.key === 'ArrowDown') {
        e.preventDefault();
        currentIdx = (currentIdx + 1) % items.length;
        items.forEach(function(el, i) { el.classList.toggle('active', i === currentIdx); });
        if (items[currentIdx]) items[currentIdx].scrollIntoView({ block: 'nearest' });
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        currentIdx = (currentIdx - 1 + items.length) % items.length;
        items.forEach(function(el, i) { el.classList.toggle('active', i === currentIdx); });
        if (items[currentIdx]) items[currentIdx].scrollIntoView({ block: 'nearest' });
      } else if (e.key === 'Enter' && currentIdx >= 0 && items[currentIdx]) {
        e.preventDefault();
        selectItem(items[currentIdx]);
      } else if (e.key === 'Escape') {
        container.style.display = 'none'; currentIdx = -1;
      }
    });

    document.addEventListener('click', function(e) {
      if (!wrap.contains(e.target)) { container.style.display = 'none'; currentIdx = -1; }
    });

    function fetchResults(q) {
      var url = 'https://nominatim.openstreetmap.org/search?q=' + encodeURIComponent(q) + '&format=json&limit=6&addressdetails=1&countrycodes=mx';
      if (extraParams) url += '&' + extraParams;
      fetch(url)
        .then(function(r) { return r.json(); })
        .then(function(data) {
          container.innerHTML = '';
          if (!data || data.length === 0) { container.style.display = 'none'; return; }
          data.forEach(function(item) {
            var div = document.createElement('div');
            div.className = 'result-item';
            div.dataset.display = item.display_name;
            var parts = item.display_name.split(',');
            var label = parts[0];
            div.innerHTML = '<strong>' + label + '</strong><small>' + item.display_name + '</small>';
            div.addEventListener('click', function() { selectItem(div); });
            div.addEventListener('mouseenter', function() { currentIdx = -1; });
            container.appendChild(div);
          });
          container.style.display = 'block';
          currentIdx = -1;
        })
        .catch(function() { container.style.display = 'none'; });
    }

    function selectItem(el) {
      input.value = el.dataset.display;
      container.style.display = 'none';
      currentIdx = -1;
    }
  }

  if (document.getElementById('location')) initNominatim('location');
  if (document.getElementById('city')) initNominatim('city', 'type=city');

  // Auto-fill price text from numeric value
  var priceVal = document.getElementById('price_value');
  var priceText = document.getElementById('price');
  if (priceVal && priceText) {
    priceVal.addEventListener('input', function() {
      var num = this.value.replace(/[^\d]/g, '');
      if (num.length > 0) {
        priceText.value = '$' + Number(num).toLocaleString('en-US') + ' MXN';
      }
    });
  }
})();
</script>
