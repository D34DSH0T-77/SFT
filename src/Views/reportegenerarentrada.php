<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Entradas</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
    </style>
</head>

<body>

    <h1>Reporte de Entradas</h1>

    <table>
        <thead>
            <tr>
                <th>Local</th>
                <th class="text-center">Cantidad Items</th>
                <th class="text-right">Monto (USD)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($entradas) && !empty($entradas)): ?>
                <?php
                $totalCantidad = 0;
                $totalMontoUsd = 0;
                ?>
                <?php foreach ($entradas as $entrada): ?>
                    <?php
                    $totalCantidad += $entrada->total_items;
                    $totalMontoUsd += $entrada->precio_usd;
                    ?>
                    <tr>
                        <td><?= $entrada->local ?></td>
                        <td class="text-center"><?= $entrada->total_items ?></td>
                        <td class="text-right">$<?= number_format($entrada->precio_usd, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td>Total</td>
                    <td class="text-center"><?= $totalCantidad ?></td>
                    <td class="text-right">$<?= number_format($totalMontoUsd, 2) ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No hay registros de entradas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>