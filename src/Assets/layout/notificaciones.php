<?php if (!empty($mensaje)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '<?= $mensaje['tipo'] ?>',
                title: '<?= $mensaje['texto'] ?>',
                background: '#252525',
                color: '#fff',
                showConfirmButton: false,
                timer: 1500
            });
        });
    </script>
<?php endif; ?>