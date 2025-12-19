<!-- Modal Nueva Venta -->
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
                                <div class="card-body-custom">
                                    <div class="position-relative">
                                        <div class="input-group">
                                            <input type="text" id="inputBusquedaClientes" class="form-control form-control-custom" placeholder="Buscar cliente..." autocomplete="off">
                                            <button class="btn btn-outline-secondary" type="button" id="btnMostrarTodoClientes"><i class="material-symbols-sharp">expand_more</i></button>
                                        </div>
                                        <div id="resultadosBusquedaClientes" class="list-group position-absolute w-100 search-results-container" style="z-index: 2000; display: none;"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Products Card -->
                            <div class="card card-custom mb-3">
                                <div class="card-header-custom">
                                    Buscar tortas
                                </div>
                                <div class="card-body-custom">
                                    <div class="position-relative">
                                        <div class="input-group">
                                            <input type="text" id="inputBusquedaProductos" class="form-control form-control-custom" placeholder="Buscar producto o escanear código..." autocomplete="off">
                                            <button class="btn btn-outline-secondary" type="button" id="btnMostrarTodo"><i class="material-symbols-sharp">expand_more</i></button>
                                        </div>
                                        <div id="resultadosBusqueda" class="list-group position-absolute w-100 search-results-container" style="z-index: 2000; display: none;"></div>
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
                                    <span class="text-muted small">Tasa: <strong id="tasaCambioDisplay">0.00</strong> BS</span>
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
                                            <tbody id="tablaProductosVenta">
                                                <!-- Los productos se agregarán aquí dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Totals & Payments -->
                        <div class="col-md-3">
                            <!-- Totals Card -->
                            <div class="card card-custom mb-3">
                                <div class="card-header-custom">
                                    Totales
                                </div>
                                <div class="card-body-custom">
                                    <div class="row total-box mx-0">
                                        <div class="col-6 p-0">
                                            <small class="d-block opacity-75">Total USD</small>
                                            <span class="fw-bold fs-4" id="totalVentaUsd">0.00</span>
                                        </div>
                                        <div class="col-6 p-0 text-end">
                                            <small class="d-block opacity-75">Total BS</small>
                                            <span class="fw-bold fs-4" id="totalVentaBs">0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cobrar Button -->
                            <div class="d-grid mt-3">
                                <button class="btn btn-primary btn-lg py-3" data-bs-toggle="modal" data-bs-target="#modalPagos">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fs-5">COBRAR</span>
                                        <i class="material-symbols-sharp">payments</i>
                                    </div>
                                </button>
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
            <form id="formVenta" method="POST" action="<?= RUTA_BASE ?>Ventas/registrar">
                <div class="modal-body bg-modal-secondary">
                    <!-- Hidden inputs container -->
                    <div id="hiddenInputsContainer"></div>
                    <input type="hidden" name="id_cliente" id="inputClienteId">
                    <input type="hidden" name="id_factura" id="inputFacturaId">

                    <div class="card card-custom">
                        <div class="card-header-custom d-flex justify-content-between align-items-center">
                            <span>Pagos</span>
                        </div>
                        <div class="card-body-custom">
                            <div class="row g-2 mb-2">
                                <div class="col-6">
                                    <select class="form-select form-control-custom" id="pagoMetodo" name="pago_metodo[]">
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Pago Movil">Pago Movil</option>
                                        <option value="Punto">Punto de Venta</option>
                                        <option value="Divisa">Divisa</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <!-- Use name="pago_monto[]" array format -->
                                        <input type="number" class="form-control form-control-custom" placeholder="Monto" id="pagoMonto" name="pago_monto[]" step="0.01">
                                        <span class="input-group-text">BS</span>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-secondary w-100 btn-custom mb-3">
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

                            <button type="submit" class="action-btn btn-register" id="btnRegistrarVenta">
                                <i class="material-symbols-sharp align-middle me-2">check_circle</i> Registrar Venta
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>