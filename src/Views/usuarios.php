<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <!-- Dashboard Widgets -->
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-light">Gestión de Usuarios</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUsuarios">
                    <span class="material-symbols-sharp me-2" style="vertical-align: middle;">add</span> Agregar Usuario
                </button>
            </div>

            <?php require('src/Assets/layout/notificaciones.php') ?>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="custom-table" id="myTable">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center no-ordenar">#</th>
                                <th class="no-ordenar">Nombre</th>
                                <th class="no-ordenar">Usuario</th>
                                <th class="no-ordenar">Rol</th>
                                <th width="10%" class="text-center no-ordenar">Estado</th>
                                <th width="15%" class="text-center no-ordenar">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($usuarios) && !empty($usuarios)): ?>
                                <?php $contador = 1; ?>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td class="text-center"><?= $contador++ ?></td>
                                        <td><?= $usuario->nombre . ' ' . $usuario->apellido ?></td>
                                        <td><?= $usuario->usuario ?></td>
                                        <td><?= $usuario->rol ?></td>
                                        <td class="text-center"><span class="badge <?= $usuario->estado === 'Activo' ? 'bg-success' : 'bg-danger' ?>"><?= $usuario->estado ?></span></td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-id="<?= $usuario->id ?>" data-bs-nombre="<?= $usuario->nombre ?>" data-bs-apellido="<?= $usuario->apellido ?>" data-bs-usuario="<?= $usuario->usuario ?>" data-bs-rol="<?= $usuario->rol ?>" data-bs-cedula="<?= $usuario->cedula ?>" data-bs-estado="<?= $usuario->estado ?>"><span class="material-symbols-sharp">edit</span></button>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar" data-bs-id="<?= $usuario->id ?>"><span class="material-symbols-sharp">delete</span></button>
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

    <?php require('src/Assets/layout/usuarios/modal.php') ?>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>
<script src="<?= RUTA_BASE ?>src/Assets/js/usuarios/usuarios.js"></script>

</html>