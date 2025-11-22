<!-- Modal Nueva Entrada -->
<div class="modal fade" id="modalEntrada" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--bg-card); color: var(--text-main);">
            <div class="modal-header" style="border-bottom-color: var(--border-color);">
                <h5 class="modal-title">Registrar Entrada de Tortas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tortaSelect" class="form-label">Torta</label>
                        <select id="tortaSelect" class="form-select" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);">
                            <option value="" selected disabled>Seleccione una torta...</option>
                            <?php if (isset($tortas) && !empty($tortas)): ?>
                                <?php foreach ($tortas as $torta): ?>
                                    <option value="<?= $torta->id ?>" data-nombre="<?= $torta->nombre ?>"><?= $torta->nombre ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="cantidadInput" class="form-label">Cantidad</label>
                        <input type="number" id="cantidadInput" class="form-control" min="1" value="1" style="background-color: var(--bg-body); color: var(--text-main); border-color: var(--border-color);">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-success w-100" id="btnAgregar">
                            <span class="material-symbols-sharp">add</span>
                        </button>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-dark table-hover" id="tablaDetalles">
                        <thead>
                            <tr>
                                <th>Torta</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="listaTortas">
                            <!-- Items will be added here -->
                        </tbody>
                    </table>
                </div>

                <div id="emptyMessage" class="text-center text-muted my-3">
                    No hay tortas agregadas a la lista.
                </div>
            </div>
            <div class="modal-footer" style="border-top-color: var(--border-color);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnGuardar">Guardar Entrada</button>
            </div>
        </div>
    </div>
</div>