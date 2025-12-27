<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas Pendientes</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #d9534f;
            /* Red/Orange for Pending */
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge-pending {
            color: #d9534f;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1>Reporte de Ventas - En Proceso</h1>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">Fecha</th>
                <th width="15%">Código</th>
                <th width="30%">Cliente</th>
                <th width="15%">Estado</th>
                <th width="20%" class="text-right">Monto Total (USD)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($ventas) && !empty($ventas)): ?>
                <?php
                $contador = 1;
                $totalUsd = 0;
                ?>
                <?php foreach ($ventas as $venta): ?>
                    <?php
                    // Calculate totals
                    $totalUsd += $venta->total_usd;
                    ?>
                    <tr>
                        <td class="text-center"><?= $contador++ ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($venta->fecha)) ?></td>
                        <td class="text-center"><?= $venta->codigo ?></td>
                        <td><?= $venta->cliente ?></td>
                        <td class="text-center badge-pending"><?= $venta->estado ?></td>
                        <td class="text-right">$<?= number_format($venta->total_usd, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="5" class="text-right" style="font-weight:bold;">Total Pendiente</td>
                    <td class="text-right" style="font-weight:bold;">$<?= number_format($totalUsd, 2) ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No hay ventas pendientes</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>