<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Reporte de Entradas</h2>
                <div class="date-filter d-flex gap-2">
                    <input type="date" class="form-control" style="background: var(--bg-card); color: var(--text-main); border: 1px solid var(--border-color);">
                    <input type="date" class="form-control" style="background: var(--bg-card); color: var(--text-main); border: 1px solid var(--border-color);">
                    <button class="btn btn-primary"><span class="material-symbols-sharp">filter_alt</span></button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3><?= $totalEntradas ?></h3>
                            <p>Total Entradas</p>
                        </div>
                        <div class="stats-icon bg-pastel-purple">
                            <span class="material-symbols-sharp">post_add</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>$<?= number_format($totalUsd, 2) ?></h3>
                            <p>Total Gastado (USD)</p>
                        </div>
                        <div class="stats-icon bg-pastel-mint">
                            <span class="material-symbols-sharp">attach_money</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>Bs <?= number_format($totalBs, 2) ?></h3>
                            <p>Total Gastado (BS)</p>
                        </div>
                        <div class="stats-icon bg-pastel-lavender">
                            <span class="material-symbols-sharp">currency_exchange</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card card-custom">
                <div class="card-header-custom">
                    Historial de Entradas
                </div>
                <div class="card-body-custom">
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="custom-table" id="myTable">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center no-ordenar">#</th>
                                        <th class="text-start no-ordenar">Codigo</th>
                                        <th width="15%" class="text-center no-ordenar">Fecha</th>
                                        <th width="20%" class="text-center no-ordenar">Local</th>
                                        <th width="15%" class="text-end no-ordenar">Costo USD</th>
                                        <th width="15%" class="text-end no-ordenar">Costo BS</th>
                                        <th width="10%" class="text-center no-ordenar">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($entradas) && !empty($entradas)): ?>
                                        <?php $contador = 1; ?>
                                        <?php foreach ($entradas as $entrada): ?>
                                            <tr>
                                                <td class="text-center"><?= $contador++ ?></td>
                                                <td class="text-start"><?= $entrada->codigo ?></td>
                                                <td class="text-center"><?= date('d/m/Y', strtotime($entrada->fecha)) ?></td>
                                                <td class="text-center"><?= $entrada->local ?></td>
                                                <td class="text-end">$<?= number_format($entrada->precio_usd, 2) ?></td>
                                                <td class="text-end">Bs <?= number_format($entrada->precio_bs, 2) ?></td>
                                                <td class="text-center">
                                                    <a href="<?= RUTA_BASE ?>Entradas/ver/<?= $entrada->id ?>" class="btn btn-sm btn-info text-white"><span class="material-symbols-sharp">visibility</span></a>
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