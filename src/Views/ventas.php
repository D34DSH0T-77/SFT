<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <!-- Dashboard Widgets -->
        <div class="container-fluid">

            <h2 class="mb-4 fw-bold">Venta de Torta</h2>

            <div class="row">
                <!-- Left Column: Client & Search -->
                <div class="col-md-3">
                    <!-- Client Card -->
                    <div class="card card-custom">
                        <div class="card-header-custom d-flex justify-content-between align-items-center">
                            <span>Cliente</span>
                            <button class="btn btn-outline-secondary btn-sm btn-custom">+ Nuevo</button>
                        </div>
                        <div class="card-body-custom">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-custom" placeholder="Buscar cliente...">
                                <button class="btn btn-outline-secondary" type="button"><i class="material-symbols-sharp">close</i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Search Products Card -->
                    <div class="card card-custom">
                        <div class="card-header-custom">
                            Buscar Productos
                        </div>
                        <div class="card-body-custom">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-custom" placeholder="Buscar producto o escanear código...">
                                <button class="btn btn-outline-secondary" type="button"><i class="material-symbols-sharp">close</i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Paused Sales Card -->
                    <div class="card card-custom">
                        <div class="card-header-custom">
                            Ventas en Pausa
                        </div>
                        <div class="card-body-custom text-center text-muted py-4">
                            No hay ventas en pausa
                        </div>
                    </div>
                </div>

                <!-- Middle Column: Products List -->
                <div class="col-md-6">
                    <div class="card card-custom h-75">
                        <div class="card-header-custom d-flex justify-content-between align-items-center">
                            <span>Tortas a vender</span>
                            <button class="btn btn-outline-secondary btn-sm btn-custom"><i class="material-symbols-sharp align-middle" style="font-size: 16px;">delete</i> Limpiar</button>
                        </div>
                        <div class="card-body-custom">
                            <div class="table-responsive" style="min-height: 300px;">
                                <table class="table product-table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th style="width: 100px;">Cantidad</th>
                                            <th class="text-end">Precio</th>
                                            <th style="width: 50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Example Item -->
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-light rounded p-2 me-2">
                                                        <i class="material-symbols-sharp text-primary">inventory_2</i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">torta</div>
                                                        <small class="text-muted">Exento IVA</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm text-center" value="1">
                                            </td>
                                            <td class="text-end">
                                                <div>3.00 USD</div>
                                                <small class="text-muted">663.00 BS</small>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-sm"><i class="material-symbols-sharp" style="font-size: 16px;">delete</i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Right Column: Totals & Payments -->
                <div class="col-md-3">
                    <!-- Totals Card -->
                    <div class="card card-custom">
                        <div class="card-header-custom">
                            Totales
                        </div>
                        <div class="card-body-custom">
                            <div class="row mb-2">
                                <div class="col-6">
                                    <small class="text-muted d-block">Subtotal USD</small>
                                    <span class="fw-bold fs-5">3.00</span>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted d-block">Subtotal BS</small>
                                    <span class="fw-bold fs-5">663.00</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">IVA (0%) USD</small>
                                    <span class="fw-bold">0.00</span>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted d-block">IVA (0%) BS</small>
                                    <span class="fw-bold">0.00</span>
                                </div>
                            </div>
                            <div class="row total-box mx-0">
                                <div class="col-6 p-0">
                                    <small class="d-block opacity-75">Total USD</small>
                                    <span class="fw-bold fs-4">3.00</span>
                                </div>
                                <div class="col-6 p-0 text-end">
                                    <small class="d-block opacity-75">Total BS</small>
                                    <span class="fw-bold fs-4">663.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payments Card -->
                    <div class="card card-custom">
                        <div class="card-header-custom d-flex justify-content-between align-items-center">
                            <span>Pagos</span>
                            <button class="btn btn-outline-primary btn-sm btn-custom">Autocompletar</button>
                        </div>
                        <div class="card-body-custom">
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <select class="form-select form-control-custom">
                                        <option>Efectivo</option>
                                        <option>Tarjeta</option>
                                        <option>Pago Movil</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-custom" placeholder="Monto">
                                        <span class="input-group-text">BS</span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-outline-secondary w-100 btn-custom mb-3">
                                <i class="material-symbols-sharp align-middle" style="font-size: 18px;">add_circle</i> Agregar método de pago
                            </button>

                            <div class="row mb-3 border-top pt-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Pagado USD</small>
                                    <span class="fw-bold text-success">0.00</span>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted d-block">Pagado BS</small>
                                    <span class="fw-bold text-success">0.00</span>
                                </div>
                            </div>

                            <button class="action-btn btn-register">
                                <i class="material-symbols-sharp align-middle me-2">check_circle</i> Registrar Venta
                            </button>
                            <button class="action-btn btn-pause">
                                <i class="material-symbols-sharp align-middle me-2">pause_circle</i> Pausar Venta
                            </button>
                            <button class="action-btn btn-note">
                                <i class="material-symbols-sharp align-middle me-2">receipt</i> Nota de Entrega
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>