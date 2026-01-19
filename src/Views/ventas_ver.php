<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- Main Container -->
                    <div class="card shadow-sm mb-4" style="background-color: var(--bg-card); color: var(--text-main);">
                        <div class="card-body p-4">

                            <!-- Header / Title -->
                            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom border-secondary pb-3">
                                <h2 class="text-light mb-0">
                                    <i class="material-symbols-sharp me-2">receipt_long</i>Detalle de Venta #<?= $factura->id ?>
                                </h2>
                                <a href="<?= RUTA_BASE ?>ventas" class="btn btn-outline-secondary text-light">
                                    <i class="material-symbols-sharp me-1">arrow_back</i> Volver
                                </a>
                            </div>

                            <!-- Info Section -->
                            <div class="row g-4 mb-5">
                                <!-- Cliente -->
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center p-3 rounded" style="background-color: rgba(255,255,255,0.05);">
                                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle p-3 me-3">
                                            <i class="material-symbols-sharp fs-3">person</i>
                                        </div>
                                        <div>
                                            <label class="text-muted small mb-1">Cliente</label>
                                            <h5 class="mb-0 text-white"><?= $factura->cliente ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fecha -->
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center p-3 rounded" style="background-color: rgba(255,255,255,0.05);">
                                        <div class="icon-box bg-info bg-opacity-10 text-info rounded-circle p-3 me-3">
                                            <i class="material-symbols-sharp fs-3">calendar_today</i>
                                        </div>
                                        <div>
                                            <label class="text-muted small mb-1">Fecha de Emisión</label>
                                            <h5 class="mb-0 text-white"><?= date('d/m/Y H:i', strtotime($factura->fecha)) ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- Estado -->
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center p-3 rounded" style="background-color: rgba(255,255,255,0.05);">
                                        <div class="icon-box bg-<?= $factura->estado == 'Completado' ? 'success' : 'warning' ?> bg-opacity-10 text-<?= $factura->estado == 'Completado' ? 'success' : 'warning' ?> rounded-circle p-3 me-3">
                                            <i class="material-symbols-sharp fs-3"><?= $factura->estado == 'Completado' ? 'check_circle' : 'pending' ?></i>
                                        </div>
                                        <div>
                                            <label class="text-muted small mb-1">Estado</label>
                                            <h5 class="mb-0">
                                                <span class="badge bg-<?= $factura->estado == 'Completado' ? 'success' : 'warning' ?>"><?= $factura->estado ?></span>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Summary -->
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="card bg-success text-white h-100 border-0 shadow-sm">
                                        <div class="card-body d-flex justify-content-between align-items-center p-4">
                                            <div>
                                                <h6 class="text-white-50 mb-2">Total en Dólares</h6>
                                                <h3 class="mb-0 fw-bold">$ <?= number_format($factura->total_usd, 2) ?></h3>
                                            </div>
                                            <i class="material-symbols-sharp fs-1 opacity-25">attach_money</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-primary-custom text-white h-100 border-0 shadow-sm">
                                        <div class="card-body d-flex justify-content-between align-items-center p-4">
                                            <div>
                                                <h6 class="text-white-50 mb-2">Total en Bs</h6>
                                                <h3 class="mb-0 fw-bold">Bs <?= number_format($factura->total_bs, 2) ?></h3>
                                            </div>
                                            <i class="material-symbols-sharp fs-1 opacity-25">currency_exchange</i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Products Table -->
                            <div class="mb-5">
                                <h5 class="text-white mb-3 border-bottom border-secondary pb-2"><i class="material-symbols-sharp me-2 align-middle">inventory_2</i>Productos Facturados</h5>
                                <div class="table-responsive rounded">
                                    <table class="table table-dark table-hover mb-0 align-middle">
                                        <thead class="bg-dark text-uppercase small text-muted">
                                            <tr>
                                                <th class="ps-4 py-3">Producto</th>
                                                <th class="text-center py-3">Cantidad</th>
                                                <th class="text-end py-3">Precio U. ($)</th>
                                                <th class="text-end py-3">Precio U. (Bs)</th>
                                                <th class="text-end pe-4 py-3">Subtotal ($)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($detalles) && !empty($detalles)): ?>
                                                <?php foreach ($detalles as $detalle): ?>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-white">
                                                            <?= $detalle['tortas'] ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <span class="badge bg-secondary rounded-pill"><?= number_format($detalle['cantidad'], 2) ?></span>
                                                        </td>
                                                        <td class="text-end text-muted">$ <?= number_format($detalle['precio_usd'], 2) ?></td>
                                                        <td class="text-end text-muted">Bs <?= number_format($detalle['precio_bs'], 2) ?></td>
                                                        <td class="text-end pe-4 fw-bold text-success">$ <?= number_format($detalle['cantidad'] * $detalle['precio_usd'], 2) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="5" class="text-center py-4 text-muted">
                                                        <i class="material-symbols-sharp fs-1 d-block mb-2">remove_shopping_cart</i>
                                                        No hay productos registrados.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Payments Table -->
                            <?php if (isset($pagos) && !empty($pagos)): ?>
                                <div class="mb-4">
                                    <h5 class="text-white mb-3 border-bottom border-secondary pb-2"><i class="material-symbols-sharp me-2 align-middle">payments</i>Historial de Pagos</h5>
                                    <div class="table-responsive rounded">
                                        <table class="table table-dark table-hover mb-0 align-middle">
                                            <thead class="bg-dark text-uppercase small text-muted">
                                                <tr>
                                                    <th class="ps-4 py-3">Método</th>
                                                    <th class="text-end py-3">Monto</th>
                                                    <th class="text-end pe-4 py-3">Fecha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pagos as $pago): ?>
                                                    <?php
                                                    $esDivisa = $pago['metodo'] === 'Divisa' || $pago['metodo'] === 'Efectivo USD';
                                                    $montoUsd = floatval($pago['monto']);
                                                    $tasaPago = isset($pago['tasa']) && floatval($pago['tasa']) > 0 ? floatval($pago['tasa']) : 0;
                                                    $montoOriginalDb = isset($pago['monto_original']) ? floatval($pago['monto_original']) : 0;
                                                    $montoBs = ($montoOriginalDb > 0 && !$esDivisa) ? $montoOriginalDb : ($montoUsd * ($tasaPago > 0 ? $tasaPago : 1));
                                                    ?>
                                                    <tr>
                                                        <td class="ps-4">
                                                            <div class="d-flex align-items-center">
                                                                <i class="material-symbols-sharp me-2 text-info">
                                                                    <?= $esDivisa ? 'attach_money' : 'currency_exchange' ?>
                                                                </i>
                                                                <?= $pago['metodo'] ?>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <?php if ($esDivisa): ?>
                                                                <span class="fw-bold text-success">$<?= number_format($montoUsd, 2) ?></span>
                                                                <?php if ($tasaPago > 0): ?>
                                                                    <div class="small text-muted">
                                                                        (<?= number_format($montoBs, 2) ?> Bs @ <?= number_format($tasaPago, 2) ?>)
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <span class="fw-bold text-info"><?= number_format($montoBs, 2) ?> Bs</span>
                                                                <div class="small text-muted">
                                                                    ($<?= number_format($montoUsd, 2) ?> @ <?= number_format($tasaPago, 2) ?>)
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="text-end pe-4 text-muted">
                                                            <?= date('d/m/Y H:i', strtotime($pago['fecha'])) ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Footer Actions -->
                            <div class="d-flex justify-content-end gap-2 mt-5">
                                <a href="<?= RUTA_BASE ?>reportes/generarFacturaDetalle/<?= $factura->id ?>" class="btn btn-success d-flex align-items-center px-4 py-2" target="_blank" title="Generar Reporte PDF">
                                    <i class="material-symbols-sharp me-2">picture_as_pdf</i> Descargar PDF
                                </a>
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