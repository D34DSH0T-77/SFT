<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario - Stock Mínimo</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #d9534f;
            /* Alert Red */
            margin-bottom: 20px;
        }

        h3 {
            text-align: center;
            color: #555;
            margin-bottom: 10px;
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

        .text-danger {
            color: #d9534f;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1>Reporte de Inventario - Stock Mínimo</h1>
    <h3>Productos con stock igual o menor a 5 unidades</h3>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="40%">Producto</th>
                <th width="15%" class="text-center">Stock Actual</th>
                <th width="20%" class="text-right">Precio Unitario</th>
                <th width="20%" class="text-right">Valor Total Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($inventario) && !empty($inventario)): ?>
                <?php $contador = 1; ?>
                <?php foreach ($inventario as $item): ?>
                    <tr>
                        <td class="text-center"><?= $contador++ ?></td>
                        <td><?= $item->nombre ?></td>
                        <td class="text-center text-danger"><?= number_format($item->total_stock) ?></td>
                        <td class="text-right">$<?= number_format($item->precio, 2) ?></td>
                        <td class="text-right">$<?= number_format($item->total_valor_usd, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">¡Excelente! No hay productos con bajo stock.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>