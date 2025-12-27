<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <!-- Dashboard Widgets -->
        <style>
            .btn-minimal {
                background: transparent;
                border: 1px solid var(--border-color);
                color: var(--text-main);
                border-radius: 30px;
                padding: 6px 20px;
                font-size: 0.85rem;
                font-weight: 500;
                transition: all 0.3s ease;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                letter-spacing: 0.5px;
            }

            .btn-minimal:hover {
                background: rgba(255, 255, 255, 0.05);
                border-color: rgba(255, 255, 255, 0.5);
                color: #fff;
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }

            .btn-minimal i {
                font-size: 0.9em;
                transition: transform 0.3s ease;
            }

            .btn-minimal:hover i {
                transform: rotate(180deg);
            }
        </style>
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
                                        <strong>Stock: <?= $torta->stock ?></strong>
                                    </p>
                                    <button type="button" class="btn-minimal btn-ajustar" data-bs-toggle="modal" data-bs-target="#modalAjustar" data-bs-id="<?= $torta->id ?>">
                                        <i class="fas fa-sliders-h"></i> Ajustar
                                    </button>
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
    <?php require('src/Assets/layout/inventario/ajustar.php') ?>
    <script>
        const BASE_URL = '<?= RUTA_BASE ?>';
    </script>
    <script src="<?= RUTA_BASE ?>src/Assets/js/inventario/inventario.js"></script>
</body>

</html>