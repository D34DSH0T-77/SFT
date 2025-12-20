<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Reporte de Clientes</h2>
                <div class="date-filter d-flex gap-2">
                    <!-- Future: Date filters for sales calculation -->
                    <button class="btn btn-primary"><span class="material-symbols-sharp">download</span> Exportar</button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3><?= $totalClientes ?></h3>
                            <p>Clientes Registrados</p>
                        </div>
                        <div class="stats-icon bg-pastel-lavender">
                            <span class="material-symbols-sharp">group</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stats-card">
                        <div class="stats-info">
                            <?php if ($clienteTop): ?>
                                <h3 style="font-size: 1.5rem;"><?= $clienteTop->nombre . ' ' . $clienteTop->apellido ?></h3>
                                <p>Cliente Top (Mayor Compra)</p>
                            <?php else: ?>
                                <h3>N/A</h3>
                                <p>Sin Datos</p>
                            <?php endif; ?>
                        </div>
                        <div class="stats-icon bg-pastel-mint">
                            <span class="material-symbols-sharp">star</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card card-custom">
                <div class="card-header-custom">
                    Estadísticas por Cliente
                </div>
                <div class="card-body-custom">
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="custom-table" id="myTable">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center no-ordenar">#</th>
                                        <th class="text-start no-ordenar">Cliente</th>
                                        <th width="15%" class="text-center no-ordenar">Estado</th>
                                        <th width="15%" class="text-center no-ordenar">Compras</th>
                                        <th width="20%" class="text-end no-ordenar">Total Gastado USD</th>
                                        <th width="20%" class="text-end no-ordenar">Total Gastado BS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($clientes) && !empty($clientes)): ?>
                                        <?php $contador = 1; ?>
                                        <?php foreach ($clientes as $c): ?>
                                            <tr>
                                                <td class="text-center"><?= $contador++ ?></td>
                                                <td class="text-start">
                                                    <div class="d-flex align-items-center">
                                                        <span class="material-symbols-sharp me-2 text-muted">person</span>
                                                        <?= $c->nombre . ' ' . $c->apellido ?>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-<?= $c->estado == 'Activo' ? 'success' : 'secondary' ?>"><?= $c->estado ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary rounded-pill"><?= $c->total_compras ?></span>
                                                </td>
                                                <td class="text-end fw-bold text-success">$<?= number_format($c->total_gastado_usd, 2) ?></td>
                                                <td class="text-end">Bs <?= number_format($c->total_gastado_bs, 2) ?></td>
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