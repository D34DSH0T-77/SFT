<!-- Modal Nueva Venta -->
<script>
    const BASE_URL = '<?= RUTA_BASE ?>';
</script>
<div class="modal fade" id="modalVenta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-modal">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Left Column: Client & Search -->
                        <div class="col-md-3">
                            <!-- Client Card -->
                            <div class="card card-custom mb-3">
                                <div class="card-header-custom d-flex justify-content-between align-items-center">
                                    <span>Cliente</span>
                                    <button class="btn btn-outline-secondary btn-sm btn-custom">+ Nuevo</button>
                                </div>
                                <select id="clienteSelect" class="form-select" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);">
                                    <option value="" selected disabled>Seleccione un cliente...</option>
                                    <?php if (isset($clientes) && !empty($clientes)): ?>
                                        <?php foreach ($clientes as $cliente): ?>
                                            <option value="<?= $cliente->id ?>" data-nombre="<?= $cliente->nombre ?>"><?= $cliente->nombre ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Search Products Card -->
                            <!-- Search Products Card -->
                            <div class="card mb-3 border border-secondary">
                                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                                    <span class="fw-bold">Buscar Torta</span>
                                </div>
                                <div class="card-body p-2" style="overflow: visible;">
                                    <div class="position-relative">
                                        <input type="text" id="tortaSearch" class="form-control" placeholder="Escriba para buscar..." autocomplete="off">
                                        <div id="searchResults" class="list-group position-absolute w-100 shadow-lg" style="z-index: 10000; top: 100%; left: 0; max-height: 250px; overflow-y: auto; display: none; background-color: #ffffff !important; border: 1px solid #ccc;">
                                            <!-- Results here -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Paused Sales Card -->
                            <!-- <div class="card card-custom">
                                <div class="card-header-custom">
                                    Ventas en Pausa
                                </div>
                                <div class="card-body-custom text-center text-muted py-4">
                                    No hay ventas en pausa
                                </div>
                            </div> -->
                        </div>


                        <!-- Middle Column: Products List -->
                        <div class="col-md-6">
                            <div class="card card-custom h-100">
                                <div class="card-header-custom d-flex justify-content-between align-items-center">
                                    <span>Tortas a vender</span>
                                    <div>
                                        <button class="btn btn-outline-secondary btn-sm btn-custom btn-add-cart"><span class="material-symbols-sharp">add</span> Agregar</button>
                                        <button class="btn btn-outline-secondary btn-sm btn-custom btn-clear-cart"><span class="material-symbols-sharp">delete</span> Limpiar</button>
                                    </div>
                                </div>
                                <div class="card-body-custom">
                                    <div class="table-responsive" style="height: calc(100vh - 250px); overflow-y: auto;">
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
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- Totals Card -->
                            <div class="card card-custom mb-3">
                                <div class="card-header-custom">
                                    Totales
                                </div>
                                <div class="card-body-custom">
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Subtotal USD</small>
                                            <span class="fw-bold fs-5 subtotal-usd">0.00</span>
                                        </div>
                                        <div class="col-6 text-end">
                                            <small class="text-muted d-block">Subtotal BS</small>
                                            <span class="fw-bold fs-5 subtotal-bs">0.00</span>
                                        </div>
                                    </div>
                                    <div class="row total-box mx-0">
                                        <div class="col-6 p-0">
                                            <small class="d-block opacity-75">Total USD</small>
                                            <span class="fw-bold fs-4 total-usd">0.00</span>
                                        </div>
                                        <div class="col-6 p-0 text-end">
                                            <small class="d-block opacity-75">Total BS</small>
                                            <span class="fw-bold fs-4 total-bs">0.00</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="text-center mb-3">
                                    <!-- Button triggers new modal -->
                                    <button class="action-btn btn-process-payment" data-bs-toggle="modal" data-bs-target="#modalPagos">
                                        <i class="material-symbols-sharp align-middle me-2">payments</i> Procesar Pago
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pagos -->
<div class="modal fade" id="modalPagos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Procesar Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card card-custom">
                    <div class="card-body-custom">
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <select class="form-select form-control-custom">
                                    <option>Efectivo</option>
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
                        <button class="btn btn-outline-secondary btn-sm w-100 btn-add-payment mb-3">Agregar Pago</button>

                        <div class="row mb-3 border-top pt-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Pagado USD</small>
                                <span class="fw-bold text-success paid-usd">0.00</span>
                            </div>
                            <div class="col-6 text-end">
                                <small class="text-muted d-block">Pagado BS</small>
                                <span class="fw-bold text-success paid-bs">0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <button class="btn btn-success w-100 btn-register" style="height: 50px; font-size: 1.2rem;">
                        <i class="material-symbols-sharp align-middle me-2">check_circle</i> Finalizar Venta
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>