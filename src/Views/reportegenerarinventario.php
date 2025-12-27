<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario</title>
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

    <h1>Reporte de Inventario</h1>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-right">Precio Unitario (USD)</th>
                <th class="text-center">Stock</th>
                <th class="text-right">Valor Total (USD)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($inventario) && !empty($inventario)): ?>
                <?php
                $totalStock = 0;
                $totalValor = 0;
                ?>
                <?php foreach ($inventario as $item): ?>
                    <?php
                    $totalStock += $item->total_stock;
                    $totalValor += $item->total_valor_usd; // Calculated in controller
                    ?>
                    <tr>
                        <td><?= $item->nombre ?></td>
                        <td class="text-right">$<?= number_format($item->precio, 2) ?></td>
                        <td class="text-center"><?= $item->total_stock ?></td>
                        <td class="text-right">$<?= number_format($item->total_valor_usd, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td>Total</td>
                    <td></td>
                    <td class="text-center"><?= $totalStock ?></td>
                    <td class="text-right">$<?= number_format($totalValor, 2) ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No hay registros de inventario</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>