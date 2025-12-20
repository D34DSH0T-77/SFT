<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Reporte de Inventario</h2>
                <div class="date-filter d-flex gap-2">
                    <button class="btn btn-primary"><span class="material-symbols-sharp">download</span> Exportar</button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3><?= number_format($totalUnidades) ?></h3>
                            <p>Unidades en Stock</p>
                        </div>
                        <div class="stats-icon bg-pastel-purple">
                            <span class="material-symbols-sharp">inventory_2</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>$<?= number_format($totalValorUsd, 2) ?></h3>
                            <p>Valor Total Inventario (USD)</p>
                        </div>
                        <div class="stats-icon bg-pastel-mint">
                            <span class="material-symbols-sharp">attach_money</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3 class="<?= $itemsBajoStock > 0 ? 'text-danger' : 'text-success' ?>"><?= $itemsBajoStock ?></h3>
                            <p>Items con Bajo Stock</p>
                        </div>
                        <div class="stats-icon bg-pastel-orange">
                            <span class="material-symbols-sharp">warning</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card card-custom">
                <div class="card-header-custom">
                    Estado del Inventario
                </div>
                <div class="card-body-custom">
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="custom-table" id="myTable">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center no-ordenar">#</th>
                                        <th class="text-start no-ordenar">Producto</th>
                                        <th width="15%" class="text-end no-ordenar">Precio Unit. (USD)</th>
                                        <th width="15%" class="text-center no-ordenar">Stock Actual</th>
                                        <th width="15%" class="text-end no-ordenar">Valor Total (USD)</th>
                                        <th width="15%" class="text-center no-ordenar">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($inventario) && !empty($inventario)): ?>
                                        <?php $contador = 1; ?>
                                        <?php foreach ($inventario as $item): ?>
                                            <tr>
                                                <td class="text-center"><?= $contador++ ?></td>
                                                <td class="text-start fw-bold"><?= $item->nombre ?></td>
                                                <td class="text-end">$<?= number_format($item->precio, 2) ?></td>
                                                <td class="text-center">
                                                    <span class="badge rounded-pill bg-<?= $item->total_stock > 5 ? 'primary' : ($item->total_stock > 0 ? 'warning' : 'danger') ?>">
                                                        <?= $item->total_stock ?>
                                                    </span>
                                                </td>
                                                <td class="text-end text-success">$<?= number_format($item->total_valor_usd, 2) ?></td>
                                                <td class="text-center">
                                                    <?php if ($item->total_stock == 0): ?>
                                                        <span class="badge bg-danger">Agotado</span>
                                                    <?php elseif ($item->total_stock <= 5): ?>
                                                        <span class="badge bg-warning text-dark">Bajo Stock</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">En Stock</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>