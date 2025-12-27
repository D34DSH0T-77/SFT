<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Reporte de Ventas</h2>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3><?= $totalVentas ?? 0 ?></h3>
                            <p>Total Ventas</p>
                        </div>
                        <div class="stats-icon bg-pastel-purple">
                            <span class="material-symbols-sharp">receipt_long</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>$<?= number_format($totalUsd ?? 0, 2) ?></h3>
                            <p>Total Ingresos (USD)</p>
                        </div>
                        <div class="stats-icon bg-pastel-mint">
                            <span class="material-symbols-sharp">attach_money</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>Bs <?= number_format($totalBs ?? 0, 2) ?></h3>
                            <p>Total Ingresos (BS)</p>
                        </div>
                        <div class="stats-icon bg-pastel-lavender">
                            <span class="material-symbols-sharp">currency_exchange</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Form -->
            <form action="tiposdereporte" method="post" class="card card-custom p-4 mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="reportes" class="form-label text-light">Tipo de Reporte</label>
                        <select name="reportes" id="reportes" class="form-select bg-dark text-light border-secondary">
                            <option value="ventas_general" selected>Reporte General</option>
                            <option value="ventas_estado">Reporte por Estado</option>
                        </select>
                    </div>

                    <div class="col-md-4" id="div_estado" style="display: none;">
                        <label for="estado" class="form-label text-light">Estado</label>
                        <select name="estado" id="estado" class="form-select bg-dark text-light border-secondary">
                            <option value="Completado">Completado</option>
                            <option value="En proceso">En proceso</option>
                        </select>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <span class="material-symbols-sharp me-2">download</span>
                            Generar PDF
                        </button>
                    </div>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const selectReporte = document.getElementById('reportes');
                    const divEstado = document.getElementById('div_estado');

                    function toggleInputs() {
                        if (selectReporte.value === 'ventas_estado') {
                            divEstado.style.display = 'block';
                        } else {
                            divEstado.style.display = 'none';
                        }
                    }

                    toggleInputs();
                    selectReporte.addEventListener('change', toggleInputs);
                });
            </script>

        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>