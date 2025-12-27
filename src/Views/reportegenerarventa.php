<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            color: #333;
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

        .total-row {
            font-weight: bold;
            background-color: #fafafa;
        }

        .status-badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 10px;
        }
    </style>
</head>

<body>

    <h1><?= isset($tituloReporte) ? $tituloReporte : 'Reporte de Ventas General' ?></h1>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">Fecha</th>
                <th width="15%">Código</th>
                <th width="30%">Cliente</th>
                <th width="10%">Estado</th>
                <th width="12%" class="text-right">Monto USD</th>
                <th width="12%" class="text-right">Monto BS</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($ventas) && !empty($ventas)): ?>
                <?php
                $contador = 1;
                $totalUsd = 0;
                $totalBs = 0;
                ?>
                <?php foreach ($ventas as $venta): ?>
                    <?php
                    // Only sum non-cancelled sales
                    if ($venta->estado != 'Anulado') {
                        $totalUsd += $venta->total_usd;
                        $totalBs += $venta->total_bs;
                    }
                    ?>
                    <tr>
                        <td class="text-center"><?= $contador++ ?></td>
                        <td class="text-center"><?= date('d/m/Y', strtotime($venta->fecha)) ?></td>
                        <td class="text-center"><?= $venta->codigo ?></td>
                        <td><?= $venta->cliente ?></td>
                        <td class="text-center"><?= $venta->estado ?></td>
                        <td class="text-right">$<?= number_format($venta->total_usd, 2) ?></td>
                        <td class="text-right">Bs <?= number_format($venta->total_bs, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="5" class="text-right">Total General</td>
                    <td class="text-right">$<?= number_format($totalUsd, 2) ?></td>
                    <td class="text-right">Bs <?= number_format($totalBs, 2) ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No hay registros de ventas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>