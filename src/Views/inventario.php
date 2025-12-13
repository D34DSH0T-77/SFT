<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <!-- Dashboard Widgets -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Inventario de Tortas</h2>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php if (isset($tortas) && !empty($tortas)): ?>
                    <?php foreach ($tortas as $torta): ?>
                        <div class="col">
                            <div class="card h-100" style="background-color: var(--bg-card); color: var(--text-main); border-color: var(--border-color);">
                                <img src="<?= !empty($torta->img) ? RUTA_BASE . $torta->img : RUTA_BASE . 'src/Assets/img/placeholder.png' ?>" class="card-img-top" alt="<?= $torta->nombre ?>" style="width: 100%; aspect-ratio: 1/1; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $torta->nombre ?></h5>
                                    <p class="card-text">
                                        <strong>Stock:</strong> <?= $torta->stock ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-info">No hay tortas registradas en el inventario.</div>
                    </div>
                <?php endif; ?>
            </div>

            <?php require('src/Assets/layout/inventario/paginacion.php') ?>
        </div>
    </div>

    <script>
        function submitPagination(page) {
            document.getElementById('pageValue').value = page;
            document.getElementById('paginationForm').submit();
        }
    </script>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>