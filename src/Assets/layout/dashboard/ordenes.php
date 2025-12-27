<!-- Recent Orders Table -->

<div class="table-container">
    <h4 class="mb-3">Facturas Completadas</h4>
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Estado</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($ultimasFacturas) && !empty($ultimasFacturas)): ?>
                    <?php foreach ($ultimasFacturas as $factura): ?>
                        <tr>
                            <td>#<?= $factura->id ?></td> <!-- Or $factura->codigo if preferred -->
                            <td><?= $factura->cliente ?></td>
                            <td><?= !empty($factura->productos) ? $factura->productos : 'Sin productos' ?></td>
                            <td>
                                <?php
                                $badgeClass = 'bg-secondary';
                                if ($factura->estado == 'Entregado' || $factura->estado == 'Completado') {
                                    $badgeClass = 'status-completed';
                                } elseif ($factura->estado == 'Pendiente') {
                                    $badgeClass = 'status-pending';
                                } elseif ($factura->estado == 'Anulado') {
                                    $badgeClass = 'status-cancelled bg-danger';
                                } elseif ($factura->estado == 'En proceso' || $factura->estado == 'En Proceso') {
                                    $badgeClass = 'status-pending bg-info'; // Reuse pending style or custom
                                }
                                ?>
                                <span class="status-badge <?= $badgeClass ?>"><?= $factura->estado ?></span>
                            </td>
                            <td>$<?= number_format($factura->total_usd, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay facturas recientes.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>