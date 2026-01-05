<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Reporte de Inventario</h2>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3><?= number_format($totalUnidades) ?></h3>
                            <p>Unidades en Stock</p>
                        </div>
                        <div class="stats-icon bg-pastel-purple">
                            <span class="material-symbols-sharp">inventory_2</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>$<?= number_format($totalValorUsd, 2) ?></h3>
                            <p>Valor Total Inventario (USD)</p>
                        </div>
                        <div class="stats-icon bg-pastel-mint">
                            <span class="material-symbols-sharp">attach_money</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3 class="<?= $itemsBajoStock > 0 ? 'text-danger' : 'text-success' ?>"><?= $itemsBajoStock ?></h3>
                            <p>Items con Bajo Stock</p>
                        </div>
                        <div class="stats-icon bg-pastel-orange">
                            <span class="material-symbols-sharp">warning</span>
                        </div>
                    </div>
                </div>
            </div>

            <form action="tiposdereporte" method="post" class="card card-custom p-4 mb-4">
                <div class="row g-3">
                    <!-- Producto Input -->
                    <div class="col-md-6" id="div_producto">
                        <label for="producto" class="form-label text-light">Producto</label>
                        <select name="producto" id="producto" class="form-select">
                            <option value="">Seleccione un producto</option>
                            <?php if (isset($productos) && !empty($productos)): ?>
                                <?php foreach ($productos as $p): ?>
                                    <option value="<?= $p ?>">
                                        <?= $p ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Tipo de Reporte -->
                    <div class="col-md-6">
                        <label for="tipos_inv" class="form-label text-light">Tipo de reporte</label>
                        <select name="reportes" id="tipos_inv" class="form-select" required>
                            <option value="inventario_general" selected>Reporte General</option>
                            <option value="inventario_bajo_stock">Reporte Stock Mínimo</option>
                        </select>
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
                    const tipoSelect = document.getElementById('tipos_inv');
                    const divProducto = document.getElementById('div_producto');
                    const divFechaInicio = document.getElementById('div_fecha_inicio_inv');
                    const divFechaFinal = document.getElementById('div_fecha_final_inv');


                    function toggleInputsInv() {
                        if (tipoSelect.value === 'inventario_general' || tipoSelect.value === 'inventario_bajo_stock') {
                            divProducto.style.display = 'none';
                            divFechaInicio.style.display = 'none';
                            divFechaFinal.style.display = 'none';
                        } else {
                            // "Reporte por Producto"
                            divProducto.style.display = 'block';
                            divFechaInicio.style.display = 'block';
                            divFechaFinal.style.display = 'block';
                        }
                    }

                    // Initial check
                    toggleInputsInv();

                    // Listen for changes
                    tipoSelect.addEventListener('change', toggleInputsInv);
                });
            </script>

            <!-- Stats Cards -->


        </div>

    </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>