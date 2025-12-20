<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <!-- Dashboard Widgets -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Gestión de Ventas</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalVenta">
                    <span class="material-symbols-sharp me-2" style="vertical-align: middle;">add</span> Nueva Venta
                </button>
            </div>

            <?php require('src/Assets/layout/notificaciones.php') ?>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>$<?= number_format($totalGananciasUsd ?? 0, 2) ?></h3>
                            <p>Ingresos USD</p>
                        </div>
                        <div class="stats-icon bg-pastel-mint">
                            <span class="material-symbols-sharp">attach_money</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>Bs <?= number_format($totalGananciasBs ?? 0, 2) ?></h3>
                            <p>Ingresos BS</p>
                        </div>
                        <div class="stats-icon bg-pastel-lavender">
                            <span class="material-symbols-sharp">currency_exchange</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="custom-table" id="myTable">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center no-ordenar">#</th>
                                <th class="no-ordenar">Codigo</th>
                                <th class="no-ordenar">Cliente</th>
                                <th class="no-ordenar">Fecha</th>
                                <th class="no-ordenar">Total USD</th>
                                <th class="no-ordenar">Total BS</th>
                                <th width="10%" class="text-center no-ordenar">Estado</th>
                                <th width="15%" class="text-center no-ordenar">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($ventas) && !empty($ventas)): ?>
                                <?php $contador = 1; ?>
                                <?php foreach ($ventas as $venta): ?>
                                    <tr>
                                        <td class="text-center"><?= $contador++ ?></td>
                                        <td><?= $venta->codigo ?></td>
                                        <td><?= $venta->cliente ?></td>
                                        <td><?= date('d/m/Y', strtotime($venta->fecha)) ?></td>
                                        <td>$<?= number_format($venta->total_usd, 2) ?></td>
                                        <td>Bs <?= number_format($venta->total_bs, 2) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-<?= $venta->estado == 'Completado' ? 'success' : 'warning' ?>"><?= $venta->estado ?></span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-success text-white" onclick="prepararPago(<?= $venta->id ?>)" title="Registrar Pago">
                                                <span class="material-symbols-sharp">credit_card</span>
                                            </button>
                                            <a href="<?= RUTA_BASE ?>ventas/ver/<?= $venta->id ?>" class="btn btn-sm btn-info text-white" title="Ver Detalle">
                                                <span class="material-symbols-sharp">visibility</span>
                                            </a>
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

    <?php require('src/Assets/layout/ventas/modal.php') ?>
    <script>
        const RUTA_BASE = '<?= RUTA_BASE ?>';
        const tortasDisponibles = <?= json_encode(array_map(function ($torta) {
                                        return [
                                            'id' => $torta->id,
                                            'nombre' => $torta->nombre,
                                            'precio' => $torta->precio,
                                            'stock' => $torta->stock,
                                            'imagen' => $torta->img,
                                        ];
                                    }, $tortas)); ?>;
        const clientesDisponibles = <?= json_encode(array_map(function ($cliente) {
                                        return [
                                            'id' => $cliente->id,
                                            'nombre' => $cliente->nombre,
                                            'apellido' => $cliente->apellido,
                                            'estado' => $cliente->estado,
                                        ];
                                    }, $clientes)); ?>;
    </script>
    <?php require('src/Assets/layout/script-footer.php') ?>
</body>
<script src="<?= RUTA_BASE ?>src/Assets/js/ventas/ventas.js"></script>

</html>