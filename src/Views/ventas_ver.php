<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-light mb-4">Detalle de Venta #<?= $factura->id ?></h2>
                    <div class="card" style="background-color: var(--bg-card); color: var(--text-main);">
                        <div class="card-body">
                            <!-- Encabezado de la Factura -->
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label text-muted">Cliente</label>
                                    <p class="form-control-plaintext text-white fs-5"><?= $factura->cliente ?></p>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label text-muted">Fecha</label>
                                    <p class="form-control-plaintext text-white fs-5"><?= date('d/m/Y H:i', strtotime($factura->fecha)) ?></p>
                                </div>
                                <div class="col-md-3">
                                    <p class="form-control-plaintext text-white fs-5">
                                        <span class="badge bg-<?= $factura->estado == 'Completado' ? 'success' : 'warning' ?>"><?= $factura->estado ?></span>
                                    </p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Total (Bs)</label>
                                    <p class="form-control-plaintext text-white fs-4 fw-bold"><?= number_format($factura->total_bs, 2) ?> Bs</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Total ($)</label>
                                    <p class="form-control-plaintext text-white fs-4 fw-bold">$ <?= number_format($factura->total_usd, 2) ?></p>
                                </div>
                            </div>

                            <hr>

                            <!-- Detalles de Productos -->
                            <h4 class="text-light mb-3">Productos</h4>
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Cant.</th>
                                        <th class="text-end">Precio U. ($)</th>
                                        <th class="text-end">Precio U. (Bs)</th>
                                        <th class="text-end">Total ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($detalles) && !empty($detalles)): ?>
                                        <?php foreach ($detalles as $detalle): ?>
                                            <tr>
                                                <td>
                                                    <?= $detalle['tortas'] ?>
                                                </td>
                                                <td class="text-center"><?= number_format($detalle['cantidad'], 2) ?></td>
                                                <td class="text-end">$ <?= number_format($detalle['precio_usd'], 2) ?></td>
                                                <td class="text-end">Bs <?= number_format($detalle['precio_bs'], 2) ?></td>
                                                <td class="text-end">$ <?= number_format($detalle['cantidad'] * $detalle['precio_usd'], 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No hay productos registrados.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Detalles de Pagos -->
                        <?php if (isset($pagos) && !empty($pagos)): ?>
                            <hr>
                            <h4 class="text-light mb-3">Pagos Registrados</h4>
                            <div class="table-responsive">
                                <table class="table table-dark table-hover w-50">
                                    <thead>
                                        <tr>
                                            <th>Método</th>
                                            <th class="text-end">Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pagos as $pago): ?>
                                            <tr>
                                                <td><?= $pago['metodo'] ?></td>
                                                <td class="text-end"><?= number_format($pago['monto'], 2) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <div class="mt-4 d-flex justify-content-end">
                            <a href="<?= RUTA_BASE ?>ventas" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>