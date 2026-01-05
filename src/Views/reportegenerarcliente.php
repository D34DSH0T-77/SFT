<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General de Clientes</title>

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
            color: #ffb7b2;
            /* pastel pink accent */
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

        .cell-status {
            text-align: center;
            width: 100px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: rgba(181, 234, 215, 0.15);
            /* pastel mint alpha */
            color: #b5ead7;
            border: 1px solid rgba(181, 234, 215, 0.3);
        }

        .status-inactive {
            background-color: rgba(255, 183, 178, 0.15);
            /* pastel pink alpha */
            color: #ffb7b2;
            border: 1px solid rgba(255, 183, 178, 0.3);
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

        .no-data {
            text-align: center;
            padding: 30px;
            color: #777;
        }
    </style>
</head>

<body>

    <h2>Reporte General de Clientes</h2>
    <div class="subtitle">Listado de clientes registrados y estadísticas generales</div>

    <?php if (isset($clientes) && !empty($clientes)): ?>
        <table class="report-table">
            <thead>
                <tr>
                    <th class="cell-index">#</th>
                    <th>Cliente</th>
                    <th style="text-align: center;">Estado</th>
                    <th style="text-align: center;">Compras</th>
                    <th style="text-align: right;">Total (USD)</th>
                    <th style="text-align: right;">Total (BS)</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($clientes as $cliente): ?>
                    <tr>
                        <td class="cell-index"><?= $i++ ?></td>
                        <td class="cell-name">
                            <?= $cliente->nombre . ' ' . $cliente->apellido ?>
                        </td>
                        <td class="cell-status">
                            <?php
                            $statusClass = (strcasecmp($cliente->estado, 'Activo') === 0) ? 'status-active' : 'status-inactive';
                            ?>
                            <span class="status-badge <?= $statusClass ?>">
                                <?= $cliente->estado ?>
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <?= $cliente->total_compras ?? 0 ?>
                        </td>
                        <td class="cell-numeric text-usd">
                            $ <?= number_format($cliente->total_gastado_usd ?? 0, 2, ',', '.') ?>
                        </td>
                        <td class="cell-numeric text-bs">
                            Bs. <?= number_format($cliente->total_gastado_bs ?? 0, 2, ',', '.') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">
            No se encontraron clientes registrados.
        </div>
    <?php endif; ?>

</body>

</html>