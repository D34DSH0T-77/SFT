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
                                <th class="no-ordenar">Codigo</th>
                                <th width="10%" class="text-center no-ordenar">Fecha</th>
                                <th width="15%" class="text-center no-ordenar">Local</th>
                                <th width="15%" class="text-center no-ordenar">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>asdasd</td>
                                <td class="text-center">12/12/2022</td>
                                <td class="text-center">Local 1</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info text-white"><span class="material-symbols-sharp">visibility</span></button>
                                </td>
                            </tr>
                            <?php if (isset($entradas) && !empty($entradas)): ?>
                                <?php $contador = 1; ?>
                                <?php foreach ($entradas as $entrada): ?>
                                    <tr>
                                        <td class="text-center"><?= $contador++ ?></td>
                                        <td><?= $entrada->codigo ?></td>
                                        <td class="text-center"><?= $entrada->fecha ?></td>
                                        <td class="text-center"><?= $entrada->local ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning text-white"><span class="material-symbols-sharp">edit</span></button>
                                            <button class="btn btn-sm btn-danger"><span class="material-symbols-sharp">delete</span></button>
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
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
    <script src="<?= RUTA_BASE ?>src/Assets/js/entradas/modal.js"></script>
</body>

</html>