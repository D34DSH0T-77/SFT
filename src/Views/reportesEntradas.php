<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <!-- Header -->
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Reporte de Entradas</h2>
            </div>

            <form action="tiposdereporte" method="post" class="card card-custom p-4 mb-4">
                <div class="row g-3">
                    <!-- Local Input -->
                    <div class="col-md-6" id="div_local">
                        <label for="local" class="form-label text-light">Local</label>
                        <select name="local" id="local" class="form-select">
                            <option value="">Seleccione un local</option>
                            <?php if (isset($locales) && !empty($locales)): ?>
                                <?php foreach ($locales as $l): ?>
                                    <option value="<?= $l ?>">
                                        <?= $l ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Tipo de Reporte -->
                    <div class="col-md-6">
                        <label for="tipos" class="form-label text-light">Tipo de reporte</label>
                        <select name="reportes" id="tipos" class="form-select" required>
                            <option value="entradas_general" selected>Reporte General</option>
                            <option value="multiple_local">Reporte por Local</option>
                        </select>
                    </div>

                    <!-- Fecha Inicio -->
                    <div class="col-md-6" id="div_fecha_inicio">
                        <label for="fecha_inicio" class="form-label text-light">Fecha de inicio</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                    </div>

                    <!-- Fecha Final -->
                    <div class="col-md-6" id="div_fecha_final">
                        <label for="fecha_final" class="form-label text-light">Fecha de final</label>
                        <input type="date" name="fecha_final" id="fecha_final" class="form-control">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-grid gap-2 col-4 mx-auto mt-4">
                    <button type="submit" class="btn btn-primary">
                        <span class="material-symbols-sharp me-2" style="vertical-align: middle;">download</span>
                        Importar
                    </button>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const tipoSelect = document.getElementById('tipos');
                    const divLocal = document.getElementById('div_local');
                    const divFechaInicio = document.getElementById('div_fecha_inicio');
                    const divFechaFinal = document.getElementById('div_fecha_final');

                    function toggleInputs() {
                        if (tipoSelect.value === 'entradas_general') {
                            divLocal.style.display = 'none';
                            divFechaInicio.style.display = 'none';
                            divFechaFinal.style.display = 'none';
                        } else {
                            divLocal.style.display = 'block';
                            divFechaInicio.style.display = 'block';
                            divFechaFinal.style.display = 'block';
                        }
                    }

                    // Initial check
                    toggleInputs();

                    // Listen for changes
                    tipoSelect.addEventListener('change', toggleInputs);
                });
            </script>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3><?= $totalEntradas ?></h3>
                            <p>Total Entradas</p>
                        </div>
                        <div class="stats-icon bg-pastel-purple">
                            <span class="material-symbols-sharp">post_add</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>$<?= number_format($totalUsd, 2) ?></h3>
                            <p>Total Gastado (USD)</p>
                        </div>
                        <div class="stats-icon bg-pastel-mint">
                            <span class="material-symbols-sharp">attach_money</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>Bs <?= number_format($totalBs, 2) ?></h3>
                            <p>Total Gastado (BS)</p>
                        </div>
                        <div class="stats-icon bg-pastel-lavender">
                            <span class="material-symbols-sharp">currency_exchange</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="card card-custom">
                <div class="card-header-custom">
                    Historial de Entradas
                </div>
                <div class="card-body-custom">
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="custom-table" id="myTable">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center no-ordenar">#</th>
                                        <th class="text-start no-ordenar">Codigo</th>
                                        <th width="15%" class="text-center no-ordenar">Fecha</th>
                                        <th width="20%" class="text-center no-ordenar">Local</th>
                                        <th width="15%" class="text-end no-ordenar">Costo USD</th>
                                        <th width="15%" class="text-end no-ordenar">Costo BS</th>
                                        <th width="10%" class="text-center no-ordenar">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (isset($entradas) && !empty($entradas)): ?>
                                        <?php $contador = 1; ?>
                                        <?php foreach ($entradas as $entrada): ?>
                                            <tr>
                                                <td class="text-center"><?= $contador++ ?></td>
                                                <td class="text-start"><?= $entrada->codigo ?></td>
                                                <td class="text-center"><?= date('d/m/Y', strtotime($entrada->fecha)) ?></td>
                                                <td class="text-center"><?= $entrada->local ?></td>
                                                <td class="text-end">$<?= number_format($entrada->precio_usd, 2) ?></td>
                                                <td class="text-end">Bs <?= number_format($entrada->precio_bs, 2) ?></td>
                                                <td class="text-center">
                                                    <a href="<?= RUTA_BASE ?>Entradas/ver/<?= $entrada->id ?>" class="btn btn-sm btn-info text-white"><span class="material-symbols-sharp">visibility</span></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>