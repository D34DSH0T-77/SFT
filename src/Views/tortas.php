<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <!-- Dashboard Widgets -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Gestión de Tortas</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTortas">
                    <span class="material-symbols-sharp me-2" style="vertical-align: middle;">add</span> Agregar Torta
                </button>
            </div>
            <?php require('src/Assets/layout/notificaciones.php') ?>
            <div class="table-container">
                <div class="table-responsive">
                    <table class="custom-table" id="myTable">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center no-ordenar">#</th>
                                <th width="10%" class="text-center no-ordenar">Img</th>
                                <th class="no-ordenar">Nombre</th>
                                <th class="no-ordenar">Precio Compra</th>
                                <th width="10%" class="text-center no-ordenar">Estado</th>
                                <th class="no-ordenar">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($tortas) && !empty($tortas)): ?>
                                <?php $contador = 1; ?>
                                <?php foreach ($tortas as $torta): ?>
                                    <tr>
                                        <td class="text-center"><?= $contador++ ?></td>
                                        <td class="text-center"><img src="<?= !empty($torta->img) ? RUTA_BASE . $torta->img : RUTA_BASE . 'src/Assets/img/placeholder.png' ?> " style="width: 50px; height: 50px;" alt="<?= $torta->nombre ?>" class="img-fluid align-middle"></td>
                                        <td><?= $torta->nombre ?></td>
                                        <td><?= $torta->precio ?></td>
                                        <td class="text-center"><span class="badge <?= $torta->estado === 'Activo' ? 'bg-success' : 'bg-danger' ?>"><?= $torta->estado ?></span></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-id="<?= $torta->id ?>" data-bs-nombre="<?= $torta->nombre ?>" data-bs-precio="<?= $torta->precio ?>" data-bs-estado="<?= $torta->estado ?>" data-bs-img="<?= $torta->img ?>"><span class="material-symbols-sharp">edit</span></button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar" data-bs-id="<?= $torta->id ?>"><span class="material-symbols-sharp">delete</span></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php require('src/Assets/layout/tortas/modal.php') ?>
    </div>
    <script src="<?= RUTA_BASE ?>src/Assets/js/tortas/tortas.js"></script>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>