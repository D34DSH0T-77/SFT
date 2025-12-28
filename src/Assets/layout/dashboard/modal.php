<!-- Modal Pagos Pendientes -->
<div class="modal fade" id="modalPagosPendientes" tabindex="-1" aria-labelledby="modalPagosPendientesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPagosPendientesLabel">Pagos Pendientes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Total USD</th>
                                <th class="text-center">Total BS</th>
                                <th class="text-center">Ver para Pagar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($pagosPendientes) && !empty($pagosPendientes)): ?>
                                <?php foreach ($pagosPendientes as $pago): ?>
                                    <tr class="align-middle">
                                        <td class="text-center"><?= date('d/m/Y', strtotime($pago->fecha)) ?></td>
                                        <td class="text-center"><?= $pago->cliente ?></td>
                                        <td class="text-center">$<?= number_format($pago->total_usd, 2) ?></td>
                                        <td class="text-center">Bs <?= number_format($pago->total_bs, 2) ?></td>
                                        <td class="text-center">
                                            <a href="<?= RUTA_BASE ?>ventas/ver/<?= $pago->id ?>" class="btn btn-sm btn-info">
                                                <i class="material-symbols-sharp">visibility</i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay pagos pendientes.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <small>Saldo pendiente: <span id="totalPendienteBs">Bs <?= number_format($totalPendienteBs, 2) ?></span> | USD <?= number_format($totalPendienteUsd, 2) ?></small>
                    <input type="hidden" id="pendingUsdAmount" value="<?= $totalPendienteUsd ?>">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>