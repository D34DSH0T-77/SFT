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
   <div class="modal fade" id="modalClientesEditar" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content" style="background-color: var(--bg-card); color: var(--text-main);">
               <div class="modal-header" style="border-bottom-color: var(--border-color);">
                   <h5 class="modal-title">Editar Cliente</h5>
                   <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form id="formClientesEditar" action="<?= RUTA_BASE ?>Clientes/editar" method="post">
                       <div class="row">
                           <div class="col-md-6 mb-3">
                               <label for="editarnombre" class="form-label">Nombre</label>
                               <input type="text" class="form-control" id="editarnombre" name="editarnombre" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" placeholder="Ej: nombre..." required>
                           </div>
                           <div class="col-md-6 mb-3">
                               <label for="editarapellido" class="form-label">Apellido</label>
                               <input type="text" class="form-control" id="editarapellido" name="editarapellido" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" placeholder="Ej: apellido..." required>
                           </div>
                       </div>
                       <div class="mb-3">
                           <label for="editarestado" class="form-label">Estado</label>
                           <select name="editarestado" id="editarestado" class="form-select" name="editarestado" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" required>
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

   <div class="modal fade" id="modalClientesEliminar" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content" style="background-color: var(--bg-card); color: var(--text-main);">
               <div class="modal-header" style="border-bottom-color: var(--border-color);">
                   <h5 class="modal-title">Eliminar Cliente</h5>
                   <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form id="formClientesEliminar" action="<?= RUTA_BASE ?>Clientes/eliminar" method="post">
                       <div class="mb-3">
                           <label for="eliminarid" class="form-label">ID</label>
                           <input type="text" class="form-control" id="eliminarid" name="eliminarid" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);" placeholder="Ej: id..." required>
                       </div>
                       <div class="modal-footer" style="border-top-color: var(--border-color);">
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                           <button type="submit" class="btn btn-primary">Eliminar</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
   </div>