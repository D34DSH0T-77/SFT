<?php

/**
 * Modal para ajustar lote
 * Archivo: src/Assets/layout/inventario/ajustar.php
 * Contiene un modal Bootstrap con un solo input para ajustar lote.
 */
?>

<!-- Modal Ajustar Lote -->
<div class="modal fade" id="modalAjustar" tabindex="-1" aria-labelledby="modalAjustarLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--bg-card); color: var(--text-main);">
            <form id="formAjustar" action="#" method="post">
                <div class="modal-header" style="border-bottom-color: var(--border-color);">
                    <h5 class="modal-title" id="modalAjustarLoteLabel">Ajustar Lote</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="ID_item" id="ajustar_ID_item" value="">

                    <div id="lotes-container">
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top-color: var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarAjuste">Guardar ajuste</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Rellenar input oculto y enfocar el input al abrir el modal
    document.addEventListener('DOMContentLoaded', function() {
        var modalEl = document.getElementById('modalAjustar');
        if (!modalEl) return;
        modalEl.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // botón que disparó el modal
            var id = button ? button.getAttribute('data-bs-id') : null;
            var inputId = document.getElementById('ajustar_ID_item');
            var inputLote = document.getElementById('ajustar_lote');
            if (inputId && id) inputId.value = id;
            if (inputLote) {
                inputLote.value = '';
                setTimeout(function() {
                    inputLote.focus();
                }, 50);
            }
        });
    });
</script>