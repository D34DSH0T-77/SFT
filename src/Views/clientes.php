<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <!-- Dashboard Widgets -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Gestión de Clientes</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalClientes">
                    <span class="material-symbols-sharp me-2" style="vertical-align: middle;">add</span> Agregar Cliente
                </button>
            </div>

            <?php require('src/Assets/layout/notificaciones.php') ?>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="custom-table" id="myTable">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center no-ordenar">#</th>
                                <th class="no-ordenar">Cliente</th>
                                <th width="10%" class="text-center no-ordenar">Estado</th>
                                <th width="15%" class="text-center no-ordenar">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($clientes) && !empty($clientes)): ?>
                                <?php $contador = 1; ?>
                                <?php foreach ($clientes as $cliente): ?>
                                    <tr>
                                        <td class="text-center"><?= $contador++ ?></td>
                                        <td><?= $cliente->nombre . ' ' . $cliente->apellido ?></td>
                                        <td class="text-center"><span class="badge <?= $cliente->estado === 'Activo' ? 'bg-success' : 'bg-danger' ?>"><?= $cliente->estado ?></span></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#modalClientesEditar" data-bs-id="<?= $cliente->id ?>" data-bs-nombre="<?= $cliente->nombre ?>" data-bs-apellido="<?= $cliente->apellido ?>" data-bs-estado="<?= $cliente->estado ?>"><span class="material-symbols-sharp">edit</span></button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalClientesEliminar" data-bs-id="<?= $cliente->id ?>"><span class="material-symbols-sharp">delete</span></button>
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

    <?php require('src/Assets/layout/clientes/modal.php') ?>

    <script src="<?= RUTA_BASE ?>src/Assets/js/clientes/clientes.js"></script>


    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>