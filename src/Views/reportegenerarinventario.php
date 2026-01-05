<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Inventario General</title>

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
            color: #ffffff;
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
            color: #b5ead7;
            /* pastel mint for inventory */
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

        /* pastel blue */
        .text-bs {
            color: #ffdac1;
        }

        /* pastel peach */

        .total-row {
            background-color: #1e1e1e;
            font-weight: bold;
        }

        .total-row td {
            border-top: 2px solid #333;
            color: #ffffff;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #777;
        }
    </style>
</head>

<body>

    <h2>Reporte de Inventario General</h2>
    <div class="subtitle">Estado actual del stock y valoración de productos</div>

    <?php if (isset($inventario) && !empty($inventario)): ?>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style="text-align: right;">Precio Unitario</th>
                    <th style="text-align: center;">Stock</th>
                    <th style="text-align: right;">Valor Total (USD)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalStock = 0;
                $totalValor = 0;
                ?>
                <?php foreach ($inventario as $item): ?>
                    <?php
                    $totalStock += $item->total_stock;
                    $totalValor += $item->total_valor_usd;
                    ?>
                    <tr>
                        <td class="cell-name"><?= $item->nombre ?></td>
                        <td class="cell-numeric text-usd">$<?= number_format($item->precio, 2) ?></td>
                        <td style="text-align: center; font-weight: bold;"><?= $item->total_stock ?></td>
                        <td class="cell-numeric text-usd">$<?= number_format($item->total_valor_usd, 2) ?></td>
                    </tr>
                <?php endforeach; ?>

                <tr class="total-row">
                    <td>TOTAL GENERAL</td>
                    <td></td>
                    <td style="text-align: center;"><?= $totalStock ?></td>
                    <td class="cell-numeric text-usd">$<?= number_format($totalValor, 2) ?></td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">
            No hay registros de inventario.
        </div>
    <?php endif; ?>

</body>

</html>