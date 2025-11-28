<!-- Modal Usuarios -->
<div class="modal fade" id="modalUsuarios" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="usuarios/guardar" method="POST">
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