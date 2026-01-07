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
                            <div class="card card-custom mb-3" style="overflow: visible;">
                                <div class="card-header-custom d-flex justify-content-between align-items-center">
                                    <span>Cliente</span>
                                    <button class="btn btn-outline-secondary btn-sm btn-custom" id="btnNuevoCliente">+ Nuevo</button>
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
                            <div class="card card-custom mb-3" style="overflow: visible;">
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
                                <button class="btn btn-primary btn-lg py-3" id="btnCobrar">
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
                    <input type="hidden" name="codigo" id="inputCodigoFactura">

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
                                        <option value="Divisa">Divisa</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <!-- Use name="pago_monto[]" array format -->
                                        <input type="number" class="form-control form-control-custom" placeholder="Monto" id="pagoMonto" name="pago_monto[]" step="0.01">
                                        <span class="input-group-text" id="pagoMonedaLabel">BS</span>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3 border-top pt-3">
                                <div class="col-6">
                                    <small class="text-muted d-block">Restante USD</small>
                                    <span class="fw-bold text-danger cursor-pointer" id="restanteUsdDisplay" onclick="copiarMontoPago(this.textContent, 'USD')" title="Click para usar este monto">0.00</span>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="text-muted d-block">Restante BS</small>
                                    <span class="fw-bold text-danger cursor-pointer" id="restanteBsDisplay" onclick="copiarMontoPago(this.textContent, 'BS')" title="Click para usar este monto">0.00</span>
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

<!-- Modal Nuevo Cliente Ajax -->
<div class="modal fade" id="modalNuevoClienteAjax" tabindex="-1" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content" style="background-color: var(--bg-card); color: var(--text-main);">
            <div class="modal-header" style="border-bottom-color: var(--border-color);">
                <h5 class="modal-title">Nuevo Cliente Rápido</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevoClienteAjax">
                    <div class="mb-3">
                        <label for="nombreAjax" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombreAjax" required style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);">
                    </div>
                    <div class="mb-3">
                        <label for="apellidoAjax" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellidoAjax" required style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>