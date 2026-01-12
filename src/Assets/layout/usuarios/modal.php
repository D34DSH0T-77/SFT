<!-- Modal Usuarios -->
<div class="modal fade" id="modalUsuarios" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUsuarios" action="usuarios/guardar" method="POST">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <h3><i class="material-symbols-sharp me-2">person</i> Información Personal</h3>
                        </div>
                        <div class="col-md-4">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre..." required>
                        </div>
                        <div class="col-md-4">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Tu apellido..." required>
                        </div>
                        <div class="col-md-4">
                            <label for="cedula" class="form-label">Cédula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" placeholder="Tu cédula..." required>
                        </div>
                        <div class="col-md-12 mt-3">
                            <h3><i class="material-symbols-sharp me-2">lock</i> Información de Acceso</h3>
                        </div>
                        <div class="col-md-4">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Tu usuario..." required>
                        </div>
                        <div class="col-md-4">
                            <label for="rol" class="form-label">Rol</label>
                            <select class="form-select" id="rol" name="rol" required>
                                <option value="" selected disabled>Seleccione...</option>
                                <option value="Admin">Admin</option>
                                <option value="Usuario">Usuario</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="Activo" selected>Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!---- Modal Editar ---->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUsuariosEditar" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="idEditar" name="id">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <h3><i class="material-symbols-sharp me-2">person</i> Información Personal</h3>
                        </div>
                        <div class="col-md-4">
                            <label for="nombreEditar" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreEditar" name="nombre" required>
                        </div>
                        <div class="col-md-4">
                            <label for="apellidoEditar" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellidoEditar" name="apellido" required>
                        </div>
                        <div class="col-md-4">
                            <label for="cedulaEditar" class="form-label">Cédula</label>
                            <input type="text" class="form-control" id="cedulaEditar" name="cedula" required>
                        </div>
                        <div class="col-md-12 mt-3">
                            <h3><i class="material-symbols-sharp me-2">lock</i> Información de Acceso</h3>
                        </div>
                        <div class="col-md-4">
                            <label for="usuarioEditar" class="form-label">Usuario</label>
                            <input type="text" class="form-control" id="usuarioEditar" name="usuario" required>
                        </div>
                        <div class="col-md-4">
                            <label for="rolEditar" class="form-label">Rol</label>
                            <select class="form-select" id="rolEditar" name="rol" required>
                                <option value="Admin">Admin</option>
                                <option value="Usuario">Usuario</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="editarestado" class="form-label">Estado</label>
                            <select class="form-select" id="editarestado" name="estado" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!---- Modal Eliminar ---->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de eliminar este usuario?</p>
                <form id="formUsuariosEliminar" method="POST">
                    <input type="hidden" id="id_eliminar" name="id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= RUTA_BASE ?>src/Assets/js/usuarios/usuarios.js"></script>