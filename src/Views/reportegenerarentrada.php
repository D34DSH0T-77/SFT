<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Entradas</title>
    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .entry-card {
            border: 2px solid #333;
            border-radius: 15px;
            margin-bottom: 20px;
            padding: 0;
            /* Remove padding to flush header */
            overflow: hidden;
            /* For header radius */
            page-break-inside: avoid;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #333;
            background-color: #a0c4ff;
            /* Pastel Blue */
        }

        .header-table td {
            padding: 8px;
            font-weight: bold;
            text-align: center;
            border-right: 2px solid #333;
            color: #121212;
        }

        .header-table td:last-child {
            border-right: none;
        }

        .products-container {
            padding: 10px;
        }

        .products-table-container {
            border: 2px solid #333;
            border-radius: 10px;
            overflow: hidden;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table td {
            padding: 5px 10px;
            border-bottom: 1px solid #ccc;
        }

        .products-table tr:last-child td {
            border-bottom: none;
        }

        .product-name {
            text-align: left;
            border-right: 2px solid #333;
        }

        .product-qty {
            text-align: center;
            width: 80px;
            font-weight: bold;
        }

        .amounts-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .amount-box {
            border: 2px solid #333;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            width: 60%;
            margin: 0 auto;
            font-weight: bold;
            font-size: 14px;
        }

        .bg-pastel-pink {
            background-color: #ffb7b2;
            /* Pastel Pink */
        }

        .bg-pastel-mint {
            background-color: #b5ead7;
            /* Pastel Mint */
        }
    </style>
</head>

<body>

    <h2 style="text-align: center;">Reporte de Entradas</h2>

    <?php if (isset($entradas) && !empty($entradas)): ?>
        <?php foreach ($entradas as $entrada): ?>
            <div class="entry-card">
                <!-- Header: Code | Local | Date -->
                <table class="header-table">
                    <tr>
                        <td width="20%">COD: <?= $entrada->codigo ?? $entrada->id ?></td>
                        <td width="55%">Local: <?= $entrada->local ?></td>
                        <td width="25%">Fecha: <?= date('d/m/Y', strtotime($entrada->fecha)) ?></td>
                    </tr>
                </table>

                <!-- Products List -->
                <div class="products-container">
                    <div class="products-table-container">
                        <table class="products-table">
                            <?php
                            $detalles = isset($entrada->detalles) ? $entrada->detalles : [];
                            if (empty($detalles) && isset($entrada->total_items)) {
                                echo "<tr><td colspan='2' style='text-align:center;'>Detalles no disponibles (Items: {$entrada->total_items})</td></tr>";
                            } elseif (!empty($detalles)) {
                                foreach ($detalles as $detalle):
                            ?>
                                    <tr>
                                        <td class="product-name"><?= $detalle->nombre_torta ?></td>
                                        <td class="product-qty"><?= $detalle->cantidad ?></td>
                                    </tr>
                            <?php
                                endforeach;
                            } else {
                                echo "<tr><td colspan='2' style='text-align:center;'>Sin productos</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>

                <!-- Footer: Amounts -->
                <table class="amounts-table">
                    <tr>
                        <td align="center">
                            <div class="amount-box bg-pastel-pink">
                                Bs <?= number_format($entrada->precio_bs, 2) ?>
                            </div>
                        </td>
                        <td align="center">
                            <div class="amount-box bg-pastel-mint">
                                $ <?= number_format($entrada->precio_usd, 2) ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center;">No se encontraron registros para el rango seleccionado.</p>
    <?php endif; ?>

</body>

</html>