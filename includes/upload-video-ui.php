<style>
.video-upload-zone {
  border: 2px dashed #d1d5db; padding: 20px; text-align: center;
  cursor: pointer; transition: border-color .3s, background .3s;
}
.video-upload-zone:hover,
.video-upload-zone.dragover {
  border-color: var(--gold, #F8BE26); background: #fef9e7;
}
.video-upload-zone.has-video {
  border-style: solid; border-color: #22c55e;
}
.video-progress { height: 6px; background: #e5e7eb; border-radius: 3px; overflow: hidden; margin-top: 10px; display: none; }
.video-progress .bar { height: 100%; width: 0%; background: var(--gold, #F8BE26); transition: width .3s; }
.video-status { font-size: .8rem; margin-top: 4px; display: none; }
</style>

<div class="video-upload-zone" id="videoZone">
  <div id="videoPlaceholder">
    <span class="material-symbols-outlined" style="font-size:2rem;color:#9ca3af;">video_file</span>
    <p class="small text-muted mb-0">Haz clic o arrastra un video aquí</p>
    <small class="text-muted">MP4, WebM, MOV, AVI — sin límite de tamaño</small>
  </div>
  <div id="videoInfo" style="display:none;">
    <span class="material-symbols-outlined" style="font-size:2rem;color:#22c55e;">check_circle</span>
    <p class="small text-success mb-0" id="videoFileName"></p>
  </div>
  <div class="video-progress" id="videoProgress"><div class="bar" id="videoProgressBar"></div></div>
  <div class="video-status" id="videoStatus"></div>
</div>
<input id="video_hidden" name="video" type="hidden" value="<?php echo htmlspecialchars($currentVideo ?? ''); ?>">

<script>
(function() {
  'use strict';
  var zone = document.getElementById('videoZone');
  var fileInput = document.createElement('input');
  fileInput.type = 'file';
  fileInput.accept = 'video/*';
  fileInput.style.display = 'none';
  zone.appendChild(fileInput);

  var placeholder = document.getElementById('videoPlaceholder');
  var info = document.getElementById('videoInfo');
  var fileName = document.getElementById('videoFileName');
  var progress = document.getElementById('videoProgress');
  var progressBar = document.getElementById('videoProgressBar');
  var status = document.getElementById('videoStatus');
  var hidden = document.getElementById('video_hidden');

  var existing = <?php echo json_encode($currentVideo ?? ''); ?>;
  if (existing) {
    placeholder.style.display = 'none';
    info.style.display = '';
    fileName.textContent = existing;
    zone.classList.add('has-video');
  }

  zone.addEventListener('click', function() { fileInput.click(); });

  zone.addEventListener('dragover', function(e) { e.preventDefault(); zone.classList.add('dragover'); });
  zone.addEventListener('dragleave', function() { zone.classList.remove('dragover'); });
  zone.addEventListener('drop', function(e) {
    e.preventDefault();
    zone.classList.remove('dragover');
    if (e.dataTransfer.files.length > 0) startUpload(e.dataTransfer.files[0]);
  });

  fileInput.addEventListener('change', function() {
    if (this.files.length > 0) startUpload(this.files[0]);
    this.value = '';
  });

  function startUpload(file) {
    placeholder.style.display = 'none';
    info.style.display = '';
    fileName.textContent = file.name;
    zone.classList.add('has-video');
    progress.style.display = '';
    progressBar.style.width = '0%';
    status.style.display = '';
    status.textContent = 'Iniciando...';
    status.className = 'video-status';

    var chunkSize = 5 * 1024 * 1024; // 5MB
    var totalChunks = Math.ceil(file.size / chunkSize);
    var currentChunk = 0;
    var uniqueId = Date.now() + '_' + Math.random().toString(36).substr(2, 9);

    function uploadNext() {
      var start = currentChunk * chunkSize;
      var end = Math.min(start + chunkSize, file.size);
      var chunk = file.slice(start, end);
      var fd = new FormData();
      fd.append('file', chunk);
      fd.append('chunkIndex', currentChunk);
      fd.append('totalChunks', totalChunks);
      fd.append('uniqueId', uniqueId);
      fd.append('filename', file.name);

      var pct = Math.round(((currentChunk) / totalChunks) * 100);
      progressBar.style.width = pct + '%';
      status.textContent = 'Subiendo... ' + pct + '% (' + formatBytes(start) + ' de ' + formatBytes(file.size) + ')';

      fetch('upload-video-chunk.php', { method: 'POST', body: fd })
        .then(function(r) { return r.json(); })
        .then(function(data) {
          if (data.error) {
            status.textContent = 'Error: ' + data.error;
            status.className = 'video-status text-danger';
            return;
          }
          if (data.path) {
            progressBar.style.width = '100%';
            status.textContent = 'Video subido correctamente.';
            status.className = 'video-status text-success';
            hidden.value = data.path;
            fileName.textContent = data.path;
          } else {
            currentChunk++;
            if (currentChunk < totalChunks) {
              uploadNext();
            }
          }
        })
        .catch(function() {
          status.textContent = 'Error de conexión. Intenta de nuevo.';
          status.className = 'video-status text-danger';
        });
    }

    uploadNext();
  }

  function formatBytes(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(1) + ' MB';
  }
})();
</script>
