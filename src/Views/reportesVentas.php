<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Reporte de Ventas</h2>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3><?= $totalVentas ?? 0 ?></h3>
                            <p>Total Ventas</p>
                        </div>
                        <div class="stats-icon bg-pastel-purple">
                            <span class="material-symbols-sharp">receipt_long</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>$<?= number_format($totalUsd ?? 0, 2) ?></h3>
                            <p>Total Ingresos (USD)</p>
                        </div>
                        <div class="stats-icon bg-pastel-mint">
                            <span class="material-symbols-sharp">attach_money</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>Bs <?= number_format($totalBs ?? 0, 2) ?></h3>
                            <p>Total Ingresos (BS)</p>
                        </div>
                        <div class="stats-icon bg-pastel-lavender">
                            <span class="material-symbols-sharp">currency_exchange</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Form -->
            <form action="tiposdereporte" method="post" class="card card-custom p-4 mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="reportes" class="form-label text-light">Tipo de Reporte</label>
                        <select name="reportes" id="reportes" class="form-select bg-dark text-light border-secondary">
                            <option value="ventas_general" selected>Reporte General</option>
                            <option value="ventas_estado">Reporte por Estado</option>
                        </select>
                    </div>

                    <div class="col-md-4" id="div_estado" style="display: none;">
                        <label for="estado" class="form-label text-light">Estado</label>
                        <select name="estado" id="estado" class="form-select bg-dark text-light border-secondary">
                            <option value="Completado">Completado</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Anulado">Anulado</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <span class="material-symbols-sharp me-2">download</span>
                            Generar PDF
                        </button>
                    </div>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const selectReporte = document.getElementById('reportes');
                    const divEstado = document.getElementById('div_estado');

                    function toggleInputs() {
                        if (selectReporte.value === 'ventas_estado') {
                            divEstado.style.display = 'block';
                        } else {
                            divEstado.style.display = 'none';
                        }
                    }

                    toggleInputs();
                    selectReporte.addEventListener('change', toggleInputs);
                });
            </script>

            <!-- Table -->
            <div class="card card-custom">
                <div class="card-header-custom">
                    Historial de Ventas
                </div>
                <div class="card-body-custom">
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="custom-table" id="myTable">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center no-ordenar">#</th>
                                        <th class="text-start no-ordenar">Código</th>
                                        <th width="15%" class="text-center no-ordenar">Fecha</th>
                                        <th width="20%" class="text-start no-ordenar">Cliente</th>
                                        <th width="15%" class="text-end no-ordenar">Total USD</th>
                                        <th width="15%" class="text-end no-ordenar">Total BS</th>
                                        <th width="10%" class="text-center no-ordenar">Estado</th>
                                        <th width="10%" class="text-center no-ordenar">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($ventas) && !empty($ventas)): ?>
                                        <?php $contador = 1; ?>
                                        <?php foreach ($ventas as $venta): ?>
                                            <tr>
                                                <td class="text-center"><?= $contador++ ?></td>
                                                <td class="text-start"><?= $venta->codigo ?? 'N/A' ?></td>
                                                <td class="text-center"><?= date('d/m/Y', strtotime($venta->fecha)) ?></td>
                                                <td class="text-start"><?= $venta->cliente ?? 'Cliente General' ?></td> <!-- Adjust property name if needed -->
                                                <td class="text-end text-success fw-bold">$<?= number_format($venta->total_usd, 2) ?></td>
                                                <td class="text-end">Bs <?= number_format($venta->total_bs, 2) ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    $estadoClass = 'bg-secondary';
                                                    if ($venta->estado == 'Completado') $estadoClass = 'bg-success';
                                                    if ($venta->estado == 'Pendiente') $estadoClass = 'bg-warning text-dark';
                                                    if ($venta->estado == 'Anulado') $estadoClass = 'bg-danger';
                                                    ?>
                                                    <span class="badge <?= $estadoClass ?>"><?= $venta->estado ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= RUTA_BASE ?>Ventas/ver/<?= $venta->id ?>" class="btn btn-sm btn-info text-white" title="Ver Detalles">
                                                        <span class="material-symbols-sharp">visibility</span>
                                                    </a>
                                                    <?php if ($venta->estado != 'Anulado'): ?>
                                                        <a href="<?= RUTA_BASE ?>Ventas/pdf/<?= $venta->id ?>" target="_blank" class="btn btn-sm btn-danger text-white ms-1" title="PDF">
                                                            <span class="material-symbols-sharp">picture_as_pdf</span>
                                                        </a>
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