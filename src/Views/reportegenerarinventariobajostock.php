<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Stock Mínimo</title>

    <style>
        /* --- 1. Variables y Base --- */
        :root {
            --bg-body: #121212;
            --bg-sidebar: #1e1e1e;
            --bg-card: #252525;
            --text-main: #e0e0e0;
            --text-muted: #a0a0a0;
            --border-color: #333;
            --pastel-pink: #ffb7b2;
            --pastel-mint: #b5ead7;
            --pastel-lavender: #c7ceea;
            --pastel-peach: #ffdac1;
            --pastel-blue: #a0c4ff;
        }

        @page {
            margin: 20px;
            background-color: #121212;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #121212;
            color: #e0e0e0;
            padding: 20px;
        }

        /* Títulos */
        h2 {
            margin-bottom: 5px;
            font-weight: 600;
            color: #ffb7b2;
            /* Alert color for title */
            text-align: left;
        }

        .subtitle {
            font-size: 0.9rem;
            color: #a0a0a0;
            margin-bottom: 25px;
        }

        /* --- 2. Tabla --- */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #252525;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .report-table th,
        .report-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        .report-table th {
            background-color: #1e1e1e;
            color: #ffb7b2;
            /* pastel pink for alert context */
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .report-table tr:last-child td {
            border-bottom: none;
        }

        .report-table tr:hover {
            background-color: rgba(255, 255, 255, 0.02);
        }

        /* Celdas específicas */
        .cell-index {
            width: 50px;
            text-align: center;
            color: #777;
        }

        .cell-name {
            font-weight: 500;
            color: #e0e0e0;
        }

        .cell-numeric {
            text-align: right;
            font-family: monospace;
            font-size: 0.95rem;
        }

        .text-usd {
            color: #a0c4ff;
        }

        .low-stock {
            color: #ffb7b2;
            font-weight: bold;
            background-color: rgba(255, 183, 178, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #b5ead7;
            /* Success text color */
            font-size: 1.1rem;
        }
    </style>
</head>

<body>

    <h2>Reporte de Stock Mínimo</h2>
    <div class="subtitle">Productos con existencias bajas (≤ 5 unidades)</div>

    <?php if (isset($inventario) && !empty($inventario)): ?>
        <table class="report-table">
            <thead>
                <tr>
                    <th class="cell-index">#</th>
                    <th>Producto</th>
                    <th style="text-align: center;">Stock Actual</th>
                    <th style="text-align: right;">Precio Unitario</th>
                    <th style="text-align: right;">Valor Total Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php $contador = 1; ?>
                <?php foreach ($inventario as $item): ?>
                    <tr>
                        <td class="cell-index"><?= $contador++ ?></td>
                        <td class="cell-name"><?= $item->nombre ?></td>
                        <td style="text-align: center;">
                            <span class="low-stock"><?= number_format($item->total_stock) ?></span>
                        </td>
                        <td class="cell-numeric text-usd">$<?= number_format($item->precio, 2) ?></td>
                        <td class="cell-numeric text-usd">$<?= number_format($item->total_valor_usd, 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">
            <span style="font-size: 2rem;">✅</span><br><br>
            ¡Excelente! No hay productos con bajo stock.
        </div>
    <?php endif; ?>

</body>

</html>