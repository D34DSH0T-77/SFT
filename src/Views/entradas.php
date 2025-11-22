<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <!-- Dashboard Widgets -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Gestión de Entradas</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEntrada">
                    <span class="material-symbols-sharp me-2" style="vertical-align: middle;">add</span> Nueva Entrada
                </button>
            </div>



            <?php require('src/Assets/layout/entradas/modal.php') ?>
        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
    <script src="<?= RUTA_BASE ?>src/Assets/js/entradas/modal.js"></script>
</body>

</html>