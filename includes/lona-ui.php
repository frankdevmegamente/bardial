<?php
// Lona para impresión: vista previa + descarga PNG con el QR de la propiedad.
// Espera en alcance: $properties (array con todas las propiedades).
if (empty($properties)) {
    $properties = [];
}

$lonaProps = [];
foreach ($properties as $lp) {
    $img = $lp['img'] ?? '';
    if (strpos($img, 'uploads/') === 0 || strpos($img, 'assets/') === 0) {
        $img = '../' . $img;
    }
    $svc = array_map('trim', explode(',', $lp['services'] ?? ''));
    $svc = array_values(array_filter($svc));
    $lonaProps[] = [
        'id'       => (int)$lp['id'],
        'location' => $lp['location'] ?? '',
        'type'     => $lp['type'] ?? '',
        'operation'=> $lp['operation'] ?? '',
        'bed'      => (int)$lp['bed'],
        'bath'     => (int)$lp['bath'],
        'sqm'      => (int)$lp['sqm'],
        'services' => array_slice($svc, 0, 8),
        'img'      => $img,
        'url'      => propertyAbsoluteUrl((int)$lp['id']),
    ];
}

$lonaLogo = siteAbsoluteUrl() . '/assets/images/logo-curvas-01.png';
?>
<link href="https://fonts.googleapis.com/css2?family=Libre+Caslon+Text:wght@400;700&amp;family=Montserrat:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet">

<!-- Lona Modal -->
<div class="modal fade" id="lonaModal" tabindex="-1" aria-labelledby="lonaModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" style="max-width:1360px;">
<div class="modal-content" style="border-radius:var(--radius);overflow:hidden;">
<div class="modal-header" style="border-bottom:1px solid rgba(0,0,0,.04);">
<h5 class="modal-title" id="lonaModalLabel" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;"><i class="bi bi-aspect-ratio me-2" style="color:var(--gold);"></i>Lona para impresión — medidas exactas</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>

<!-- Toolbar medidas exactas -->
<div class="lona-toolbar bg-white border-bottom p-3">
<div class="d-flex flex-wrap gap-3 align-items-end">
<div>
<label class="form-label small fw-semibold text-muted mb-1">Preestablecido</label>
<select id="lonaPreset" class="form-select form-select-sm" style="min-width:190px;">
<option value="custom">Personalizado</option>
<option value="300x200" selected>3.00 × 2.00 m — 300 × 200 cm (horizontal)</option>
<option value="250x150">2.50 × 1.50 m — 250 × 150 cm</option>
<option value="200x150">2.00 × 1.50 m — 200 × 150 cm</option>
<option value="200x100">2.00 × 1.00 m — 200 × 100 cm</option>
<option value="150x100">1.50 × 1.00 m — 150 × 100 cm</option>
<option value="120x80">1.20 × 0.80 m — 120 × 80 cm</option>
<option value="100x70">1.00 × 0.70 m — 100 × 70 cm</option>
<option value="80x60">0.80 × 0.60 m — 80 × 60 cm</option>
<option value="80x120">0.80 × 1.20 m — Vertical 80 × 120 cm</option>
<option value="100x200">1.00 × 2.00 m — Vertical 100 × 200 cm</option>
</select>
</div>
<div>
<label class="form-label small fw-semibold text-muted mb-1" for="lonaTopText">Texto superior</label>
<select id="lonaTopText" class="form-select form-select-sm" style="min-width:120px;">
<option value="En Venta">En Venta</option>
<option value="En Renta">En Renta</option>
</select>
</div>
<div>
<label class="form-label small fw-semibold text-muted mb-1" for="lonaWidth">Ancho</label>
<input id="lonaWidth" type="number" class="form-control form-control-sm" value="300" min="1" max="1000" step="0.1" style="width:96px;">
</div>
<div>
<label class="form-label small fw-semibold text-muted mb-1" for="lonaHeight">Alto</label>
<input id="lonaHeight" type="number" class="form-control form-control-sm" value="200" min="1" max="1000" step="0.1" style="width:96px;">
</div>
<div>
<label class="form-label small fw-semibold text-muted mb-1" for="lonaUnit">Unidad</label>
<select id="lonaUnit" class="form-select form-select-sm" style="width:92px;">
<option value="cm" selected>cm</option>
<option value="m">m</option>
<option value="mm">mm</option>
<option value="inch">pulgadas</option>
<option value="px">px</option>
</select>
</div>
<div class="d-flex flex-column">
<label class="form-label small fw-semibold text-muted mb-1">&nbsp;</label>
<button type="button" id="lonaSwap" class="btn btn-outline-modern btn-sm" title="Intercambiar ancho y alto (girar orientación)"><i class="bi bi-arrow-left-right"></i></button>
</div>
<div>
<label class="form-label small fw-semibold text-muted mb-1" for="lonaDpi">DPI</label>
<select id="lonaDpi" class="form-select form-select-sm" style="width:108px;">
<option value="72">72 (web)</option>
<option value="96">96</option>
<option value="150">150</option>
<option value="200">200</option>
<option value="300" selected>300 (impresión)</option>
</select>
</div>
<div>
<label class="form-label small fw-semibold text-muted mb-1" for="lonaZoom">Zoom vista</label>
<select id="lonaZoom" class="form-select form-select-sm" style="width:118px;">
<option value="fit" selected>Ajustar</option>
<option value="1">100% real (96 DPI)</option>
<option value="0.5">50%</option>
<option value="0.75">75%</option>
</select>
</div>
<div class="ms-auto d-flex flex-column align-items-end" style="min-width:120px;">
<label class="form-label small fw-semibold text-muted mb-1" for="lonaScale">Calidad extra</label>
<select id="lonaScale" class="form-select form-select-sm" style="width:110px;">
<option value="1">×1 (base)</option>
<option value="1.5">×1.5</option>
<option value="2" selected>×2</option>
</select>
</div>
</div>
<div id="lonaSizeInfo" class="small text-muted mt-2" style="line-height:1.5;background:#f8fafc;border:1px solid #f1f3f5;border-radius:8px;padding:6px 10px;"></div>
</div>

<div id="lonaViewport" style="background:#eef0f3;overflow:auto;max-height:62vh;display:flex;justify-content:center;align-items:flex-start;padding:16px;">
<div class="lona" id="lonaCanvas"></div>
</div>

<div class="modal-footer justify-content-between flex-wrap gap-2" style="border-top:1px solid rgba(0,0,0,.04);">
<div class="small text-muted"><i class="bi bi-info-circle me-1"></i>El PNG se descarga con las medidas físicas exactas a la DPI seleccionada.</div>
<div class="d-flex gap-2">
<a id="lonaDownload" class="btn btn-gold" href="#"><i class="bi bi-download me-1"></i> Descargar lona (PNG)</a>
<button type="button" class="btn btn-outline-modern" data-bs-dismiss="modal">Cerrar</button>
</div>
</div>
</div>
</div>
</div>

<style>
#lonaViewport { scrollbar-width: thin; }
#lonaCanvas {
  width:1200px; height:800px;
  background:#f9f9f7; position:relative; overflow:hidden;
  font-family:'Montserrat',system-ui,sans-serif;
  margin:0 auto; flex-shrink:0;
  box-shadow:0 10px 40px rgba(0,0,0,.18);
  --lx:1; --ly:1; --scale:1;
}
.lona-top { position:absolute; top:0; left:0; right:0; height:calc(96px * var(--ly)); background:#081C27; display:flex; align-items:center; justify-content:space-between; padding:0 calc(40px * var(--lx)); z-index:2; }
.lona-top .logo { height:calc(64px * var(--ly)); width:auto; object-fit:contain; }
.lona-venta { color:#F8BE26; font-weight:800; letter-spacing:.38em; font-size:calc(34px * var(--scale)); text-transform:uppercase; white-space:nowrap; }
.lona-photo { position:absolute; top:calc(96px * var(--ly)); left:0; bottom:calc(140px * var(--ly)); width:62%; background-size:cover; background-position:center; background-repeat:no-repeat; }
.lona-info { position:absolute; top:calc(96px * var(--ly)); right:0; bottom:calc(140px * var(--ly)); width:38%; background:#ffffff; padding:calc(34px * var(--ly)) calc(30px * var(--lx)); overflow:hidden; display:flex; flex-direction:column; }
.lona-price { font-family:'Libre Caslon Text',serif; font-weight:700; font-size:calc(44px * var(--scale)); color:#081C27; line-height:1.05; word-break:break-word; }
.lona-location { margin-top:calc(12px * var(--ly)); font-size:calc(14px * var(--scale)); font-weight:700; color:#081C27; letter-spacing:.18em; text-transform:uppercase; line-height:1.3; }
.lona-type { margin-top:calc(6px * var(--ly)); font-size:calc(15px * var(--scale)); font-weight:600; color:#F8BE26; letter-spacing:.08em; text-transform:uppercase; }
.lona-badge { display:inline-block; margin-top:calc(12px * var(--ly)); background:#081C27; color:#fff; font-size:calc(12px * var(--scale)); font-weight:700; letter-spacing:.14em; text-transform:uppercase; padding:calc(5px * var(--ly)) calc(14px * var(--lx)); }
.lona-specs { margin-top:calc(20px * var(--ly)); display:flex; }
.lona-spec { flex:1; border:1px solid #c3c7cb; padding:calc(12px * var(--ly)) calc(6px * var(--lx)) calc(10px * var(--ly)); text-align:center; margin-right:calc(8px * var(--lx)); }
.lona-spec:last-child { margin-right:0; }
.lona-spec .num { font-family:'Libre Caslon Text',serif; font-weight:700; font-size:calc(26px * var(--scale)); color:#081C27; }
.lona-spec .lbl { font-size:calc(9px * var(--scale)); color:#43474b; letter-spacing:.14em; text-transform:uppercase; margin-top:calc(2px * var(--ly)); }
.lona-services { margin-top:calc(16px * var(--ly)); display:flex; flex-wrap:wrap; overflow:hidden; }
.lona-svc { display:inline-block; background:#f9f9f7; color:#081C27; border:1px solid #081C27; font-size:calc(10px * var(--scale)); font-weight:600; letter-spacing:.06em; text-transform:uppercase; padding:calc(4px * var(--ly)) calc(9px * var(--lx)); margin:calc(4px * var(--ly)) calc(5px * var(--lx)) 0 0; }
.lona-bottom { position:absolute; left:0; right:0; bottom:0; height:calc(140px * var(--ly)); background:#081C27; padding:0 calc(40px * var(--lx)); display:flex; align-items:center; justify-content:space-between; z-index:2; gap:calc(12px * var(--lx)); }
.lona-contact-title { font-weight:700; font-size:calc(20px * var(--scale)); color:#F8BE26; line-height:1.2; }
.lona-contact { font-size:calc(12px * var(--scale)); margin-top:calc(4px * var(--ly)); color:rgba(255,255,255,.85); letter-spacing:.04em; line-height:1.3; }
.lona-qrwrap { display:flex; align-items:center; flex-shrink:0; }
.lona-qr { width:calc(120px * var(--scale)); height:calc(120px * var(--scale)); background:#fff; padding:calc(8px * var(--scale)); display:block; }
.lona-qrtext { color:#fff; font-size:calc(10px * var(--scale)); letter-spacing:.14em; text-transform:uppercase; max-width:calc(130px * var(--scale)); line-height:1.6; margin-left:calc(14px * var(--lx)); }
.lona-toolbar .form-label { font-size:.7rem; }
</style>

<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.1/build/qrcode.min.js"></script>
<script>
var lonaProps = <?php echo json_encode($lonaProps); ?>;
var lonaLogo = <?php echo json_encode($lonaLogo); ?>;
var lonaCurrentId = null;
var lonaTopText = 'En Venta';
// Medidas exactas state
var lonaActualW = 1134; // px at 96 DPI preview (300cm * 96/2.54 ≈ 11338 but we cap for initial? No use 1200 default? We'll recalc)
var lonaActualH = 756;
var lonaDisplayW = 1200;
var lonaDisplayH = 800;

function lonaEscape(s) {
    var d = document.createElement('div');
    d.appendChild(document.createTextNode(s == null ? '' : String(s)));
    return d.innerHTML;
}

function lonaFind(id) {
    for (var i = 0; i < lonaProps.length; i++) { if (lonaProps[i].id === id) return lonaProps[i]; }
    return null;
}

function lonaToCm(val, unit) {
    var v = parseFloat(val);
    if (isNaN(v) || v <= 0) return 0;
    if (unit === 'm') return v * 100;
    if (unit === 'mm') return v / 10;
    if (unit === 'inch') return v * 2.54;
    if (unit === 'px') return v * 2.54 / 96;
    return v; // cm
}
function lonaFromCm(cm, unit) {
    if (unit === 'm') return cm / 100;
    if (unit === 'mm') return cm * 10;
    if (unit === 'inch') return cm / 2.54;
    if (unit === 'px') return cm * 96 / 2.54;
    return cm;
}
function lonaCmToPx(cm, dpi) {
    return cm * dpi / 2.54;
}
function lonaPxToCm(px, dpi) {
    return px * 2.54 / dpi;
}

function lonaApplySize() {
    var wInput = document.getElementById('lonaWidth');
    var hInput = document.getElementById('lonaHeight');
    var unitSel = document.getElementById('lonaUnit');
    var dpiSel = document.getElementById('lonaDpi');
    var info = document.getElementById('lonaSizeInfo');
    var canvas = document.getElementById('lonaCanvas');
    if (!wInput || !hInput || !unitSel || !dpiSel || !canvas) return;

    var unit = unitSel.value;
    var dpi = parseInt(dpiSel.value, 10) || 300;
    var wVal = parseFloat(wInput.value);
    var hVal = parseFloat(hInput.value);
    if (!(wVal > 0) || !(hVal > 0)) {
        if (info) info.textContent = 'Introduce ancho y alto válidos.';
        return;
    }
    var wCm = lonaToCm(wVal, unit);
    var hCm = lonaToCm(hVal, unit);
    // px at 96 DPI for preview (actual physical at 96)
    var previewW = lonaCmToPx(wCm, 96);
    var previewH = lonaCmToPx(hCm, 96);
    // export pixels at selected DPI
    var exportW = Math.round(lonaCmToPx(wCm, dpi));
    var exportH = Math.round(lonaCmToPx(hCm, dpi));
    // Clamp preview to avoid insane DOM (max 5000px) but keep actual for export
    // For display we store actual, but if actual > 4000 we will use zoom fit
    lonaActualW = previewW;
    lonaActualH = previewH;

    // Update size info
    var wCmFixed = wCm.toFixed(2).replace(/\.00$/, '');
    var hCmFixed = hCm.toFixed(2).replace(/\.00$/, '');
    var wM = (wCm/100).toFixed(2);
    var hM = (hCm/100).toFixed(2);
    var wIn = (wCm/2.54).toFixed(1);
    var hIn = (hCm/2.54).toFixed(1);
    if (info) {
        info.innerHTML = '<strong>Impresión:</strong> ' + wCmFixed + ' × ' + hCmFixed + ' cm'
            + ' &middot; ' + wM + ' × ' + hM + ' m'
            + ' &middot; ' + wIn + ' × ' + hIn + '″'
            + ' &middot; <strong>' + exportW + ' × ' + exportH + ' px</strong> @ ' + dpi + ' DPI'
            + ' &middot; Vista: ' + Math.round(previewW) + ' × ' + Math.round(previewH) + ' px @96 DPI';
        if (previewW > 3000 || previewH > 3000) {
            info.innerHTML += ' <span class="text-warning"><i class="bi bi-exclamation-triangle ms-2"></i> Lona grande: la vista se ajustará automáticamente.</span>';
        }
    }

    // Apply zoom/display size
    lonaApplyZoom();
}

function lonaApplyZoom() {
    var canvas = document.getElementById('lonaCanvas');
    var viewport = document.getElementById('lonaViewport');
    var zoomSel = document.getElementById('lonaZoom');
    if (!canvas || !viewport) return;
    var zoomVal = zoomSel ? zoomSel.value : 'fit';
    var displayW, displayH;
    if (zoomVal === 'fit') {
        var availW = viewport.clientWidth - 32;
        var availH = viewport.clientHeight - 32;
        if (availW <= 0) availW = 1200;
        if (availH <= 0) availH = 600;
        var scale = Math.min(availW / lonaActualW, availH / lonaActualH, 1);
        // Avoid tiny scale unreadable: minimum 0.25
        if (scale < 0.12) scale = 0.12;
        displayW = lonaActualW * scale;
        displayH = lonaActualH * scale;
    } else {
        var factor = parseFloat(zoomVal) || 1;
        displayW = lonaActualW * factor;
        displayH = lonaActualH * factor;
    }
    lonaDisplayW = displayW;
    lonaDisplayH = displayH;
    canvas.style.width = displayW + 'px';
    canvas.style.height = displayH + 'px';
    // Update CSS variables for scaling
    var lx = displayW / 1200;
    var ly = displayH / 800;
    var scale = Math.min(lx, ly);
    // Keep fonts readable: clamp scale between 0.4 and 5
    if (scale < 0.35) scale = 0.35;
    canvas.style.setProperty('--lx', lx);
    canvas.style.setProperty('--ly', ly);
    canvas.style.setProperty('--scale', scale);
}

function lonaRender(p) {
    lonaCurrentId = p.id;
    var c = document.getElementById('lonaCanvas');
    if (!c) return;

    var svcHtml = '';
    for (var i = 0; i < p.services.length; i++) {
        svcHtml += '<span class="lona-svc">' + lonaEscape(p.services[i]) + '</span>';
    }
    c.innerHTML =
        '<div class="lona-top">' +
            '<img class="logo" src="' + lonaLogo + '" alt="Bardial Inmobiliaria" crossorigin="anonymous">' +
            '<div class="lona-venta">' + lonaEscape(lonaTopText) + '</div>' +
        '</div>' +
        '<div class="lona-photo" style="background-image:url(\'' + lonaEscape(p.img) + '\');"></div>' +
        '<div class="lona-info">' +
            '<div class="lona-location">' + lonaEscape(p.location) + '</div>' +
            (p.type ? '<div class="lona-type">' + lonaEscape(p.type) + '</div>' : '') +
            '<div class="lona-specs">' +
                '<div class="lona-spec"><div class="num">' + p.bed + '</div><div class="lbl">Rec&aacute;maras</div></div>' +
                '<div class="lona-spec"><div class="num">' + p.bath + '</div><div class="lbl">Ba&ntilde;os</div></div>' +
                '<div class="lona-spec"><div class="num">' + p.sqm + '</div><div class="lbl">m&sup2;</div></div>' +
            '</div>' +
            (svcHtml ? '<div class="lona-services">' + svcHtml + '</div>' : '') +
        '</div>' +
        '<div class="lona-bottom">' +
            '<div>' +
                '<div class="lona-contact-title">Bardial Inmobiliaria</div>' +
                '<div class="lona-contact">Vida exquisita, definida por la excelencia.</div>' +
                '<div class="lona-contact">+34 900 123 456 &middot; info@bardial.com</div>' +
            '</div>' +
            '<div class="lona-qrwrap">' +
                '<img class="lona-qr" id="lonaQr" src="" alt="QR" crossorigin="anonymous">' +
                '<div class="lona-qrtext">Escanee para ver los detalles de esta propiedad</div>' +
            '</div>' +
        '</div>';

    // Generate QR as image (more reliable for html2canvas)
    var qrImg = document.getElementById('lonaQr');
    if (qrImg) {
        QRCode.toDataURL(p.url, {
            width: 256,
            margin: 1,
            errorCorrectionLevel: 'H',
            color: { dark: '#081C27FF', light: '#FFFFFFFF' }
        }, function (err, url) {
            if (!err && url) qrImg.src = url;
        });
    }

    var im = new Image();
    im.crossOrigin = 'anonymous';
    im.onload = function () { /* image ready for capture */ };
    im.onerror = function () { /* continue capture */ };
    im.src = p.img;
}

document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('lonaModal');
    if (!modal) return;

    var presetSel = document.getElementById('lonaPreset');
    var wInput = document.getElementById('lonaWidth');
    var hInput = document.getElementById('lonaHeight');
    var unitSel = document.getElementById('lonaUnit');
    var dpiSel = document.getElementById('lonaDpi');
    var zoomSel = document.getElementById('lonaZoom');

    function handlePreset() {
        if (!presetSel) return;
        var v = presetSel.value;
        if (v === 'custom') return;
        var parts = v.split('x');
        var wCm = parseFloat(parts[0]);
        var hCm = parseFloat(parts[1]);
        var unit = unitSel ? unitSel.value : 'cm';
        // Preset values are in cm, convert to current unit for inputs
        var wDisp = lonaFromCm(wCm, unit);
        var hDisp = lonaFromCm(hCm, unit);
        // Round nicely
        if (unit === 'm') { wDisp = (wCm/100); hDisp = (hCm/100); }
        if (unit === 'px') { wDisp = Math.round(wDisp); hDisp = Math.round(hDisp); }
        else { wDisp = Math.round(wDisp*10)/10; hDisp = Math.round(hDisp*10)/10; }
        if (wInput) wInput.value = wDisp;
        if (hInput) hInput.value = hDisp;
        lonaApplySize();
    }

    function handleUnitChange() {
        // Keep physical size constant, convert input values to new unit
        var oldUnit = unitSel.getAttribute('data-prev') || 'cm';
        var newUnit = unitSel.value;
        if (oldUnit !== newUnit && wInput && hInput) {
            var wVal = parseFloat(wInput.value);
            var hVal = parseFloat(hInput.value);
            if (!isNaN(wVal) && !isNaN(hVal)) {
                var wCm = lonaToCm(wVal, oldUnit);
                var hCm = lonaToCm(hVal, oldUnit);
                var wNew = lonaFromCm(wCm, newUnit);
                var hNew = lonaFromCm(hCm, newUnit);
                if (newUnit === 'px') { wNew = Math.round(wNew); hNew = Math.round(hNew); }
                else if (newUnit === 'm') { wNew = Math.round(wNew*100)/100; hNew = Math.round(hNew*100)/100; }
                else { wNew = Math.round(wNew*10)/10; hNew = Math.round(hNew*10)/10; }
                wInput.value = wNew;
                hInput.value = hNew;
            }
        }
        unitSel.setAttribute('data-prev', newUnit);
        // Reset preset to custom since user changed unit manually
        if (presetSel) presetSel.value = 'custom';
        lonaApplySize();
    }

    if (unitSel) unitSel.setAttribute('data-prev', unitSel.value);

    if (presetSel) presetSel.addEventListener('change', handlePreset);

    var topInput = document.getElementById('lonaTopText');
    if (topInput) {
        topInput.addEventListener('change', function () {
            lonaTopText = topInput.value || 'En Venta';
            if (lonaCurrentId) {
                var pp = lonaFind(lonaCurrentId);
                if (pp) { lonaRender(pp); lonaApplySize(); }
            }
        });
    }
    if (wInput) wInput.addEventListener('input', function(){ if(presetSel) presetSel.value='custom'; lonaApplySize(); });
    if (hInput) hInput.addEventListener('input', function(){ if(presetSel) presetSel.value='custom'; lonaApplySize(); });
    if (unitSel) unitSel.addEventListener('change', handleUnitChange);
    if (dpiSel) dpiSel.addEventListener('change', lonaApplySize);
    if (zoomSel) zoomSel.addEventListener('change', lonaApplyZoom);

    var swapBtn = document.getElementById('lonaSwap');
    if (swapBtn) {
        swapBtn.addEventListener('click', function(){
            if (!wInput || !hInput) return;
            var tmp = wInput.value;
            wInput.value = hInput.value;
            hInput.value = tmp;
            if (presetSel) presetSel.value = 'custom';
            lonaApplySize();
        });
    }

    // Initial compute
    lonaApplySize();
    window.addEventListener('resize', function(){ if (zoomSel && zoomSel.value==='fit') lonaApplyZoom(); });

    modal.addEventListener('shown.bs.modal', function (e) {
        var btn = e.relatedTarget;
        if (!btn) return;
        var p = lonaFind(parseInt(btn.getAttribute('data-id'), 10));
        if (p) {
            lonaTopText = p.operation === 'Renta' ? 'En Renta' : 'En Venta';
            var topInput = document.getElementById('lonaTopText');
            if (topInput) topInput.value = lonaTopText;
            lonaRender(p);
            // Re-apply size/zoom after render to ensure vars correct
            lonaApplySize();
        }
    });

    var dl = document.getElementById('lonaDownload');
    if (dl) {
        dl.addEventListener('click', function (e) {
            e.preventDefault();
            var p = lonaFind(lonaCurrentId);
            if (!p) return;
            var canvasEl = document.getElementById('lonaCanvas');
            var dpi = parseInt(document.getElementById('lonaDpi').value, 10) || 300;
            var extraScale = parseFloat(document.getElementById('lonaScale').value) || 1;
            // Save display state
            var prevW = canvasEl.style.width;
            var prevH = canvasEl.style.height;
            var prevLx = canvasEl.style.getPropertyValue('--lx');
            var prevLy = canvasEl.style.getPropertyValue('--ly');
            var prevScale = canvasEl.style.getPropertyValue('--scale');
            // Temporarily set to actual print size at selected DPI * extraScale
            // actual preview was at 96 DPI; we now need at dpi
            // Compute actual print pixels
            var unit = document.getElementById('lonaUnit').value;
            var wVal = parseFloat(document.getElementById('lonaWidth').value);
            var hVal = parseFloat(document.getElementById('lonaHeight').value);
            var wCm = lonaToCm(wVal, unit);
            var hCm = lonaToCm(hVal, unit);
            var printW = lonaCmToPx(wCm, dpi) * extraScale;
            var printH = lonaCmToPx(hCm, dpi) * extraScale;
            var dpi96W = lonaCmToPx(wCm, 96);
            var dpi96H = lonaCmToPx(hCm, 96);
            var renderScale = (dpi / 96) * extraScale;
            // Safety: evita canvas gigante que crashea el navegador (> 48 MP o lado > 16000px)
            var estimatedMP = (printW * printH) / 1000000;
            var maxSide = 16000;
            var wasCapped = false;
            if (estimatedMP > 48 || printW > maxSide || printH > maxSide) {
                // Intenta bajar calidad extra primero
                if (extraScale > 1) {
                    extraScale = 1;
                    renderScale = (dpi / 96) * extraScale;
                    printW = lonaCmToPx(wCm, dpi) * extraScale;
                    printH = lonaCmToPx(hCm, dpi) * extraScale;
                    estimatedMP = (printW * printH) / 1000000;
                    document.getElementById('lonaScale').value = '1';
                }
                if (estimatedMP > 48 || printW > maxSide || printH > maxSide) {
                    var scaleDown = Math.min(maxSide / printW, maxSide / printH, Math.sqrt(48 / estimatedMP));
                    var newW = Math.round(printW * scaleDown);
                    var newH = Math.round(printH * scaleDown);
                    alert('La lona a ' + dpi + ' DPI resultaría en ' + Math.round(printW) + '×' + Math.round(printH) + ' px (' + estimatedMP.toFixed(1) + ' MP), demasiado grande para el navegador. Se descargará con el tamaño máximo seguro: ' + newW + '×' + newH + ' px. Para medidas exactas, usa DPI 150 o menor, o reduce la medida física.');
                    printW = newW;
                    printH = newH;
                    renderScale = renderScale * scaleDown;
                    dpi96W = printW / renderScale;
                    dpi96H = printH / renderScale;
                    wasCapped = true;
                }
            }
            if (!wasCapped) {
                // recalc dpi96 if not capped (keep original)
                dpi96W = lonaCmToPx(wCm, 96);
                dpi96H = lonaCmToPx(hCm, 96);
            }
            // For html2canvas we will render at dpi96 size scaled by dpi/96 * extraScale
            // Simpler: set canvas to dpi96 size, then html2canvas scale = dpi/96 * extraScale
            // But to get crisp text, we can set canvas to print size and scale=1
            // Choose: set to dpi96 size + use scale for to avoid huge DOM for 300 DPI (printW could be 35430px)
            // Using scale avoids needing to set huge DOM synchronously
            var useScaleMethod = printW > 4200 || printH > 4200; // threshold: use scale to avoid huge DOM
            if (useScaleMethod) {
                // Keep DOM at dpi96 size, let html2canvas upscale
                canvasEl.style.width = dpi96W + 'px';
                canvasEl.style.height = dpi96H + 'px';
                var lx2 = dpi96W / 1200;
                var ly2 = dpi96H / 800;
                var sc2 = Math.min(lx2, ly2);
                if (sc2 < 0.35) sc2 = 0.35;
                canvasEl.style.setProperty('--lx', lx2);
                canvasEl.style.setProperty('--ly', ly2);
                canvasEl.style.setProperty('--scale', sc2);
                tryCapture();
            } else {
                // Set DOM directly to print size for best quality
                canvasEl.style.width = printW + 'px';
                canvasEl.style.height = printH + 'px';
                var lx3 = printW / 1200;
                var ly3 = printH / 800;
                var sc3 = Math.min(lx3, ly3);
                if (sc3 < 0.35) sc3 = 0.35;
                canvasEl.style.setProperty('--lx', lx3);
                canvasEl.style.setProperty('--ly', ly3);
                canvasEl.style.setProperty('--scale', sc3);
                renderScale = 1; // already at print size
                // QR already generated as image; ensure it is loaded before capture
                tryCapture();
            }

            var imageReady = false;
            function tryCapture() {
                if (!imageReady) return;
                var qrImg = document.getElementById('lonaQr');
                if (qrImg && !qrImg.complete) {
                    qrImg.onload = function () { qrImg.onload = null; tryCapture(); };
                    return;
                }
                Promise.all([document.fonts.ready]).then(function () {
                    setTimeout(function(){
                        html2canvas(canvasEl, {
                            scale: renderScale,
                            useCORS: true,
                            backgroundColor: '#f9f9f7',
                            logging: false
                        }).then(function (c2) {
                            var a = document.createElement('a');
                            a.href = c2.toDataURL('image/png');
                            // filename includes medidas
                            var unitLbl = unit === 'px' ? 'px' : wCm.toFixed(0) + 'x' + hCm.toFixed(0) + 'cm';
                            a.download = 'bardial-lona-prop-' + p.id + '-' + unitLbl + '-' + dpi + 'dpi.png';
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            // Restore display size
                            canvasEl.style.width = prevW;
                            canvasEl.style.height = prevH;
                            canvasEl.style.setProperty('--lx', prevLx);
                            canvasEl.style.setProperty('--ly', prevLy);
                            canvasEl.style.setProperty('--scale', prevScale);
                            // Re-render QR at display scale
                            setTimeout(function(){ if(lonaCurrentId) { var pp=lonaFind(lonaCurrentId); if(pp) lonaRender(pp); lonaApplyZoom(); } }, 100);
                        }).catch(function (err) {
                            console.error(err);
                            canvasEl.style.width = prevW;
                            canvasEl.style.height = prevH;
                            canvasEl.style.setProperty('--lx', prevLx);
                            canvasEl.style.setProperty('--ly', prevLy);
                            canvasEl.style.setProperty('--scale', prevScale);
                        });
                    }, 300);
                });
            }
            var im = new Image();
            im.crossOrigin = 'anonymous';
            im.onload = im.onerror = function () { imageReady = true; tryCapture(); };
            if (useScaleMethod) { tryCapture(); }
            im.src = p.img;
        });
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
