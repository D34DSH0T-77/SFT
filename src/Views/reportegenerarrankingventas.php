<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= $titulo ?? 'Ranking de Ventas' ?></title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4a4a4a;
            margin-bottom: 5px;
        }

        h4 {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-weight: normal;
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
            color: #444;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1><?= $titulo ?? 'Reporte de Ranking' ?></h1>
    <h4>Período: <?= date('d/m/Y', strtotime($fechaInicio)) ?> - <?= date('d/m/Y', strtotime($fechaFinal)) ?></h4>

    <table>
        <thead>
            <tr>
                <th width="10%">Posición</th>
                <th width="40%">Producto</th>
                <th width="20%" class="text-center">Total Vendido (Unidades)</th>
                <th width="30%" class="text-right">Ingresos Generados (USD)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($datos) && !empty($datos)): ?>
                <?php
                $contador = 1;
                $totalIngresos = 0;
                ?>
                <?php foreach ($datos as $item): ?>
                    <?php $totalIngresos += $item->total_ingreso_usd; ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $contador++ ?></td>
                        <td><?= $item->nombre ?></td>
                        <td class="text-center"><?= number_format($item->total_vendido) ?></td>
                        <td class="text-right">$<?= number_format($item->total_ingreso_usd, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-right fw-bold">Total Ingresos en este período</td>
                    <td class="text-right fw-bold">$<?= number_format($totalIngresos, 2) ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No hay datos de ventas para este período.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>