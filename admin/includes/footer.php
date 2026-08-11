</div><!-- .main-content -->

<footer class="text-center py-3 text-muted small" style="border-top:1px solid rgba(0,0,0,.04);font-size:.75rem;letter-spacing:.3px;">
Bardial Inmobiliaria &copy; <?php echo date('Y'); ?> — v2.0 · Panel de Administración
</footer>
</div><!-- .main-wrapper -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sidebarOverlay').classList.toggle('open');
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebarOverlay').classList.remove('open');
    }
});
</script>
</body>
</html>
