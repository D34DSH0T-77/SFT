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

            <?php if (!empty($mensaje)): ?>
                <div class="alert alert-<?= htmlspecialchars($mensaje['tipo']) ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($mensaje['texto'] ?? '') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

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
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalClientes" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: var(--bg-card); color: var(--text-main);">
                <div class="modal-header" style="border-bottom-color: var(--border-color);">
                    <h5 class="modal-title">Nuevo Cliente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formClientes" action="<?= RUTA_BASE ?>Clientes/agregar" method="post">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" placeholder="Ej: nombre..." required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" placeholder="Ej: apellido..." required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" id="estado" class="form-select" name="estado" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" required>
                                <option value="Activo" selected>Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="modal-footer" style="border-top-color: var(--border-color);">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>