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
                                    <i class="material-symbols-sharp me-2">keyboard_return</i>Detalle de Devolución #<?= $devolucion->codigo ?>
                                </h2>
                                <a href="<?= RUTA_BASE ?>devoluciones" class="btn btn-outline-secondary text-light">
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
                                            <h5 class="mb-0 text-white">
                                                <?= !empty($devolucion->nombre) ? $devolucion->nombre . ' ' . $devolucion->apellido : 'N/A' ?>
                                            </h5>
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
                                            <h5 class="mb-0 text-white"><?= date('d/m/Y', strtotime($devolucion->fecha)) ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- Motivo (Estado) -->
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center p-3 rounded" style="background-color: rgba(255,255,255,0.05);">
                                        <div class="icon-box bg-success bg-opacity-10 text-success rounded-circle p-3 me-3">
                                            <i class="material-symbols-sharp fs-3">check_circle</i>
                                        </div>
                                        <div>
                                            <label class="text-muted small mb-1">Motivo</label>
                                            <h5 class="mb-0 text-white"><?= $devolucion->motivo ?></h5>
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
                                                <h6 class="text-white-50 mb-2">Total Devuelto (USD)</h6>
                                                <h3 class="mb-0 fw-bold">$ <?= number_format($devolucion->total_devuelto_dolar, 2) ?></h3>
                                            </div>
                                            <i class="material-symbols-sharp fs-1 opacity-25">attach_money</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-primary-custom text-white h-100 border-0 shadow-sm">
                                        <div class="card-body d-flex justify-content-between align-items-center p-4">
                                            <div>
                                                <h6 class="text-white-50 mb-2">Total Devuelto (Bs)</h6>
                                                <h3 class="mb-0 fw-bold">Bs <?= number_format($devolucion->total_devuelto_bolivar, 2) ?></h3>
                                            </div>
                                            <i class="material-symbols-sharp fs-1 opacity-25">currency_exchange</i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Products Table -->
                            <div class="mb-5">
                                <h5 class="text-white mb-3 border-bottom border-secondary pb-2"><i class="material-symbols-sharp me-2 align-middle">inventory_2</i>Productos Devueltos</h5>
                                <div class="table-responsive rounded">
                                    <table class="table table-dark table-hover mb-0 align-middle">
                                        <thead class="bg-dark text-uppercase small text-muted">
                                            <tr>
                                                <th class="ps-4 py-3">Producto</th>
                                                <th class="text-center py-3" style="width: 15%;">Cantidad Devuelta</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($detalles) && !empty($detalles)): ?>
                                                <?php foreach ($detalles as $detalle): ?>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-white"><?= $detalle->nombre_torta ?></td>
                                                        <td class="text-center">
                                                            <span class="badge bg-danger rounded-pill"><?= $detalle->cantidad_devuelta ?></span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="2" class="text-center py-4 text-muted">
                                                        <i class="material-symbols-sharp fs-1 d-block mb-2">remove_shopping_cart</i>
                                                        No hay detalles registrados para esta devolución.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div class="d-flex justify-content-end gap-2 mt-5">
                                <a href="<?= RUTA_BASE ?>devoluciones" class="btn btn-secondary px-4 py-2">Volver</a>
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