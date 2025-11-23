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
                                        <td class="text-center"><img src="<?= !empty($torta->img) ? RUTA_BASE . $torta->img : RUTA_BASE . 'src/Assets/img/placeholder.png' ?> " style="width: 50px; height: 50px;" alt="Torta de Chocolate" class="img-fluid align-middle"></td>
                                        <td><?= $torta->nombre ?></td>
                                        <td><?= $torta->precio ?></td>
                                        <td class="text-center"><span class="badge <?= $torta->estado === 'Activo' ? 'bg-success' : 'bg-danger' ?>"><?= $torta->estado ?></span></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning text-white"  data-bs-toggle="modal" data-bs-target="#modalEditar" data-bs-id="<?= $torta->id ?>" data-bs-nombre="<?= $torta->nombre ?>" data-bs-precio="<?= $torta->precio ?>" data-bs-estado="<?= $torta->estado ?>" data-bs-img="<?= $torta->img ?>"><span class="material-symbols-sharp">edit</span></button>
                                            <button class="btn btn-sm btn-danger"  data-bs-toggle="modal" data-bs-target="#modalEliminar" data-bs-id="<?= $torta->id ?>"><span class="material-symbols-sharp" >delete</span></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalTortas" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: var(--bg-card); color: var(--text-main);">
                    <div class="modal-header" style="border-bottom-color: var(--border-color);">
                        <h5 class="modal-title">Nueva Torta</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formTortas" action="<?= RUTA_BASE ?>Tortas/agregar" method="post">
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
                        <form id="formTortaseditar"  method="post">
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
           <!--eliminar-->

                         <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background-color: var(--bg-card); color: var(--text-main);">
                    <div class="modal-header" style="border-bottom-color: var(--border-color);">
                        <h5 class="modal-title">Eliminar Torta</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estas seguro de eliminar la torta?</p>
                            </div>  
                            <div>
                            <form id="formTortaseliminar"  method="post">
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

            



    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function(){
      let editarModal = document.getElementById('modalEditar')  
      let eliminarModal = document.getElementById('modalEliminar')
      editarModal.addEventListener('shown.bs.modal', function(event){
        let button = event.relatedTarget
        let id = button.getAttribute('data-bs-id')
        let nombre = button.getAttribute('data-bs-nombre')
        let precio = button.getAttribute('data-bs-precio')
        let estado = button.getAttribute('data-bs-estado')
        let img = button.getAttribute('data-bs-img')
        let inputId = editarModal.querySelector('.modal-body #id_edit')
        let inputNombre = editarModal.querySelector('.modal-body #editarnombre')
        let inputPrecio = editarModal.querySelector('.modal-body #editarprecio')
        let inputEstado = editarModal.querySelector('.modal-body #editarestado')
        let inputImagen = editarModal.querySelector('.modal-body #editarimagen')
        inputId.value = id 
        inputNombre.value = nombre
        inputPrecio.value = precio
        inputEstado.value = estado
        inputImagen.value = img
        let formEditar = document.getElementById('formTortaseditar')
        formEditar.action =`/SFT/tortas/editar/${id}`
                         })   
                         let inputIdEliminar = eliminarModal.querySelector('.modal-body #id_eliminar')
        eliminarModal.addEventListener('shown.bs.modal', function(event){
            let button = event.relatedTarget
            let id = button.getAttribute('data-bs-id')
            inputIdEliminar.value = id
            let formEliminar = document.getElementById('formTortaseliminar')
            formEliminar.action =`/SFT/tortas/eliminar/${id}`
        })       
     })                          
    </script>
    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>