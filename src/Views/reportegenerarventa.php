<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Ventas</title>

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
            margin-bottom: 20px;
            font-weight: 600;
            color: #ffffff;
            text-align: left;
        }

        /* --- 2. Grid y Tarjetas de Reporte --- */
        .report-ticket-card {
            background-color: #252525;
            border: 1px solid #333;
            border-radius: 15px;
            margin-bottom: 25px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            page-break-inside: avoid;
        }

        /* Encabezado: Código | Cliente | Fecha */
        .ticket-header {
            width: 100%;
            padding: 15px 20px;
            background-color: rgba(255, 255, 255, 0.03);
            border-bottom: 1px dashed #333;
            font-size: 0.9rem;
            color: #a0a0a0;
            display: table;
        }

        .ticket-header-cell {
            display: table-cell;
            vertical-align: middle;
        }

        .ticket-code {
            font-weight: bold;
            color: #ffb7b2;
            /* pastel pink */
            text-align: left;
            width: 33%;
        }

        .ticket-client {
            text-align: center;
            color: #e0e0e0;
            font-weight: 600;
            width: 33%;
        }

        .ticket-date {
            text-align: right;
            font-family: monospace;
            width: 33%;
        }

        /* Cuerpo: Lista */
        .ticket-body {
            padding: 20px;
        }

        .ticket-product-list {
            background-color: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            padding: 10px;
            border: 1px solid #333;
        }

        .ticket-item {
            display: table;
            width: 100%;
            padding: 10px;
            border-bottom: 1px solid #333;
            font-size: 0.95rem;
            color: #e0e0e0;
        }

        .ticket-item:last-child {
            border-bottom: none;
        }

        .ticket-item-name {
            display: table-cell;
            text-align: left;
        }

        .ticket-item-qty {
            display: table-cell;
            color: #b5ead7;
            /* pastel mint */
            font-weight: bold;
            padding-left: 15px;
            border-left: 1px solid #333;
            width: 80px;
            text-align: center;
        }

        /* Pie: Totales */
        .ticket-footer {
            padding: 15px 20px;
            background-color: rgba(0, 0, 0, 0.1);
            border-top: 1px dashed #333;
            display: table;
            width: 100%;
            border-spacing: 15px 0;
            border-collapse: separate;
        }

        .ticket-total-box {
            display: table-cell;
            width: 50%;
            border-radius: 10px;
            padding: 12px 5px;
            text-align: center;
            vertical-align: middle;
        }

        /* Estilo Bolívares */
        .ticket-total-box.bs {
            background-color: rgba(255, 218, 193, 0.1);
            border: 1px solid rgba(255, 218, 193, 0.2);
        }

        .ticket-total-box.bs .label {
            color: #ffdac1;
            /* pastel peach */
        }

        /* Estilo Dólares */
        .ticket-total-box.usd {
            background-color: rgba(160, 196, 255, 0.1);
            border: 1px solid rgba(160, 196, 255, 0.2);
        }

        .ticket-total-box.usd .label {
            color: #a0c4ff;
            /* pastel blue */
        }

        .ticket-total-box .label {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            margin-bottom: 4px;
            letter-spacing: 1px;
        }

        .ticket-total-box .amount {
            display: block;
            color: #e0e0e0;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #777;
        }
    </style>
</head>

<body>

    <h2><?= isset($tituloReporte) ? $tituloReporte : 'Reporte de Ventas General' ?></h2>

    <div class="reports-grid">

        <?php if (isset($ventas) && !empty($ventas)): ?>
            <?php foreach ($ventas as $venta): ?>
                <div class="report-ticket-card">

                    <!-- Header -->
                    <div class="ticket-header">
                        <div class="ticket-header-cell ticket-code">
                            #<?= $venta->codigo ?>
                        </div>
                        <div class="ticket-header-cell ticket-client">
                            <!-- User/Client Icon -->
                            <span style="font-family: sans-serif;">👤</span> <?= $venta->cliente ?>
                        </div>
                        <div class="ticket-header-cell ticket-date">
                            <?= date('d/m/Y', strtotime($venta->fecha)) ?>
                        </div>
                    </div>

                    <!-- Body -->
                    <div class="ticket-body">
                        <div class="ticket-product-list">
                            <?php
                            $detalles = isset($venta->detalles) ? $venta->detalles : [];
                            if (!empty($detalles)):
                                foreach ($detalles as $detalle):
                                    // Alias might be 'tortas' or 'nombre_torta' depending on model, assuming 'tortas' based on DetallesFacturas
                            ?>
                                    <div class="ticket-item">
                                        <div class="ticket-item-name"><?= $detalle['tortas'] ?? $detalle['nombre_torta'] ?? 'Producto Desconocido' ?></div>
                                        <div class="ticket-item-qty">x <?= $detalle['cantidad'] ?></div>
                                    </div>
                                <?php
                                endforeach;
                            else:
                                ?>
                                <div class="ticket-item">
                                    <div class="ticket-item-name" style="font-style:italic; color: #777;">
                                        Detalles no disponibles
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="ticket-footer">
                        <div class="ticket-total-box bs">
                            <span class="label">Bolívares</span>
                            <span class="amount">Bs. <?= number_format($venta->total_bs, 2, ',', '.') ?></span>
                        </div>
                        <div class="ticket-total-box usd">
                            <span class="label">Dólares</span>
                            <span class="amount">$ <?= number_format($venta->total_usd, 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-data">
                No se encontraron registros de ventas para el rango seleccionado.
            </div>
        <?php endif; ?>

    </div>

</body>

</html>