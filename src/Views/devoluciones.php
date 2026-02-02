<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Gestión de Devoluciones</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDevolucion">
                    <span class="material-symbols-sharp me-2" style="vertical-align: middle;">add</span> Nueva Devolución
                </button>
            </div>

            <?php require('src/Assets/layout/notificaciones.php') ?>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>$0.00</h3>
                            <p>Total Devoluciones USD</p>
                        </div>
                        <div class="stats-icon bg-pastel-red">
                            <span class="material-symbols-sharp">money_off</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>Bs 0.00</h3>
                            <p>Total Devoluciones BS</p>
                        </div>
                        <div class="stats-icon bg-pastel-orange">
                            <span class="material-symbols-sharp">remove_shopping_cart</span>
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
                                <th class="no-ordenar">Codigo Venta</th>
                                <th class="no-ordenar">Cliente</th>
                                <th class="no-ordenar">Fecha</th>
                                <th class="no-ordenar">Total Reembolsado $</th>
                                <th class="no-ordenar">Total Reembolsado Bs</th>
                                <th class="no-ordenar">Motivo</th>
                                <th width="15%" class="text-center no-ordenar">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($devoluciones) && !empty($devoluciones)): ?>
                                <?php $contador = 1; ?>
                                <?php foreach ($devoluciones as $devolucion): ?>
                                    <tr>
                                        <td class="text-center"><?= $contador++ ?></td>
                                        <td><?= $devolucion->codigo ?></td>
                                        <td><?= $devolucion->nombre ?> <?= $devolucion->apellido ?></td>
                                        <td><?= date('d/m/Y', strtotime($devolucion->fecha)) ?></td>
                                        <td>$<?= number_format($devolucion->total_devuelto_dolar, 2) ?></td>
                                        <td>Bs <?= number_format($devolucion->total_devuelto_bolivar, 2) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-success"><?= $devolucion->motivo ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= RUTA_BASE ?>Devoluciones/ver/<?= $devolucion->id ?>" class="btn btn-sm btn-info text-white" title="Ver Detalle">
                                                <span class="material-symbols-sharp">visibility</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">No hay devoluciones registradas</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Placeholder -->
    <div class="modal fade" id="modalDevolucion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nueva Devolución</h5>
                    <div class="ms-auto me-3 text-muted">
                        <small>Tasa: <strong>Bs <span id="tasaCambioDisplay">0.00</span></strong></small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formDevolucion" method="POST" action="<?= RUTA_BASE ?>Devoluciones/guardarDevolucion">
                        <!-- Hidden Inputs -->
                        <input type="hidden" name="codigo" id="inputCodigoVentaHidden">
                        <input type="hidden" name="total_devuelto_bolivar" id="inputTotalBsHidden" value="0">
                        <input type="hidden" name="total_devuelto_dolar" id="inputTotalUsdHidden" value="0">
                        <div class="row mb-3">
                            <div class="col-md-6 position-relative">
                                <label class="form-label">Buscar Venta</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="inputBusquedaVentas" placeholder="Código de venta o Cliente" autocomplete="off">
                                    <button class="btn btn-outline-secondary" type="button" id="btnMostrarTodasVentas"><i class="material-symbols-sharp">expand_more</i></button>
                                </div>
                                <div id="resultadosBusquedaVentas" class="list-group position-absolute w-100 mt-1" style="z-index: 1000; display: none; max-height: 200px; overflow-y: auto;"></div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha</label>
                                <input type="date" class="form-control" name="fecha" value="<?= date('Y-m-d') ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Motivo de Devolución</label>
                            <select class="form-select" id="selectMotivo" name="motivo">
                                <option value="" selected disabled>Seleccione un motivo</option>
                                <option value="Vencido">Vencido</option>
                                <option value="Dañado">Dañado</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="mb-3" id="divRegresarInventario" style="display: none;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="checkRegresarInventario" name="regresar_inventario">
                                <label class="form-check-label" for="checkRegresarInventario">
                                    Regresar al inventario
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6>Items a Devolver</h6>
                            <div id="itemsDevolucionContainer">
                                <div class="alert alert-info">Seleccione una venta para ver los items disponibles.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Devolución</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
    <script>
        const RUTA_BASE = '<?= RUTA_BASE ?>';
        const ventasDisponibles = <?= json_encode($ventas ?? []) ?>;
    </script>
    <script src="<?= RUTA_BASE ?>src/Assets/js/devoluciones/devoluciones.js"></script>
    <?php require('src/Assets/layout/notificaciones.php') ?>
</body>


</html>