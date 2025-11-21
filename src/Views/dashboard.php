<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <!-- Dashboard Widgets -->
        <div class="container-fluid">
            <?php require('src/Assets/layout/dashboard/tarjetas.php') ?>

            <?php require('src/Assets/layout/dashboard/ordenes.php') ?>
        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>