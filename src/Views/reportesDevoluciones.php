<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Reporte de Devoluciones</h2>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3><?= $totalDevoluciones ?? 0 ?></h3>
                            <p>Total Devoluciones</p>
                        </div>
                        <div class="stats-icon bg-pastel-purple">
                            <span class="material-symbols-sharp">auto_delete</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>$<?= number_format($totalUsd ?? 0, 2) ?></h3>
                            <p>Total Devuelto (USD)</p>
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
                            <p>Total Devuelto (BS)</p>
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
                            <option value="devoluciones_general" selected>Reporte General</option>
                            <option value="devoluciones_vencido">Vencido</option>
                            <option value="devoluciones_danado">Dañado</option>
                            <option value="devoluciones_otro">Otro</option>
                        </select>
                    </div>

                    <div class="col-md-4" id="div_fecha_inicio">
                        <label for="fecha_inicio" class="form-label text-light">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control bg-dark text-light border-secondary">
                    </div>

                    <div class="col-md-4" id="div_fecha_final">
                        <label for="fecha_final" class="form-label text-light">Fecha Final</label>
                        <input type="date" name="fecha_final" id="fecha_final" class="form-control bg-dark text-light border-secondary">
                    </div>

                    <div class="col-md-12 d-flex align-items-end mt-3">
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
                    const divFechaInicio = document.getElementById('div_fecha_inicio');
                    const divFechaFinal = document.getElementById('div_fecha_final');

                    function toggleInputs() {
                        const selectedValue = selectReporte.value;

                        if (selectedValue === 'devoluciones_general') {
                            divFechaInicio.style.display = 'none';
                            divFechaFinal.style.display = 'none';
                        } else {
                            divFechaInicio.style.display = 'block';
                            divFechaFinal.style.display = 'block';
                        }
                    }

                    toggleInputs(); // Call on page load
                    selectReporte.addEventListener('change', toggleInputs);
                });
            </script>

        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>