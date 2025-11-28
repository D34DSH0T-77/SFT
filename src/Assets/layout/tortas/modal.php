  <!-- Modal -->
  <div class="modal fade" id="modalTortas" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content" style="background-color: var(--bg-card); color: var(--text-main);">
              <div class="modal-header" style="border-bottom-color: var(--border-color);">
                  <h5 class="modal-title">Nueva Torta</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form id="formTortas" action="<?= RUTA_BASE ?>Tortas/agregar" method="post" enctype="multipart/form-data">
                      <div class="mb-3">
                          <label for="nombre" class="form-label">Nombre</label>
                          <input type="text" class="form-control" id="nombre" name="nombre" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" placeholder="Ej: Torta de Chocolate..." required>
                      </div>

                      <div class="row">
                          <div class="col-md-6 mb-3">
                              <label for="precio" class="form-label">Precio</label>
                              <input type="number" step="0.01" class="form-control" id="precio" name="precio" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" placeholder="Ej: 2.50" required>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label for="stock" class="form-label">Estado</label>
                              <select name="estado" id="estado" class="form-select" name="estado" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" required>
                                  <option value="Activo" selected>Activo</option>
                                  <option value="Inactivo">Inactivo</option>
                              </select>
                          </div>
                      </div>
                      <div class="mb-3">
                          <label for="formFileSm" class="form-label">Imagen</label>
                          <input class="form-control form-control-sm" id="formFileSm" name="imagen" type="file" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);">
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

  <!--editar-->
  <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content" style="background-color: var(--bg-card); color: var(--text-main);">
              <div class="modal-header" style="border-bottom-color: var(--border-color);">
                  <h5 class="modal-title">Editar Torta</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form id="formTortaseditar" method="post">
                      <div class="mb-3">
                          <input type="hidden" name="id" id="id_edit">
                          <label for="editarnombre" class="form-label">Nombre</label>
                          <input type="text" class="form-control" id="editarnombre" name="editarnombre" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" placeholder="Ej: Torta de Chocolate..." required>
                      </div>

                      <div class="row">
                          <div class="col-md-6 mb-3">
                              <label for="editarprecio" class="form-label">Precio</label>
                              <input type="number" step="0.01" class="form-control" id="editarprecio" name="editarprecio" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" placeholder="Ej: 2.50" required>
                          </div>
                          <div class="col-md-6 mb-3">
                              <label for="editarestado" class="form-label">Estado</label>
                              <select name="editarestado" id="editarestado" class="form-select" name="editarestado" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" required>
                                  <option value="Activo" selected>Activo</option>
                                  <option value="Inactivo">Inactivo</option>
                              </select>
                          </div>
                      </div>
                      <div class="mb-3">
                          <label for="editarimagen" class="form-label">Imagen</label>
                          <input class="form-control form-control-sm" id="editarimagen" name="editarimagen" type="file" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);">
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

  <!-- Eliminar Modal -->
  <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content" style="background-color: var(--bg-card); color: var(--text-main);">
              <div class="modal-header" style="border-bottom-color: var(--border-color);">
                  <h5 class="modal-title">Eliminar Torta</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <p>¿Estas seguro de eliminar la torta?</p>
                  <form id="formTortaseliminar" method="post">
                      <input type="hidden" name="id" id="id_eliminar">
                      <div class="modal-footer" style="border-top-color: var(--border-color);">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                          <button type="submit" class="btn btn-primary">Eliminar</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>