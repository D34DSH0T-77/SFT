<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <!-- Dashboard Widgets -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Gestión de Entradas</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEntrada">
                    <span class="material-symbols-sharp me-2" style="vertical-align: middle;">add</span> Nueva Entrada
                </button>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="custom-table" id="myTable">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center no-ordenar">#</th>
                                <th class="text-start no-ordenar">Codigo</th>
                                <th width="10%" class="text-center no-ordenar">Fecha</th>
                                <th width="15%" class="text-center no-ordenar">Local</th>
                                <th width="15%" class="text-center no-ordenar">Acciones</th>
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

            <?php require('src/Assets/layout/entradas/modal.php') ?>
        </div>
        <script>
            const RUTA_BASE = '<?= RUTA_BASE ?>';
            const tortasDisponibles = <?= json_encode(array_map(function ($torta) {
                                            return [
                                                'id' => $torta->id,
                                                'nombre' => $torta->nombre,

                                            ];
                                        }, $tortas)); ?>;
        </script>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
    <script src="<?= RUTA_BASE ?>src/Assets/js/entradas/modal.js"></script>
</body>

</html>