<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Reporte de Capital</h2>
                <div class="date-filter d-flex gap-2">
                    <button class="btn btn-primary"><span class="material-symbols-sharp">download</span> Exportar</button>
                </div>
            </div>



        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>