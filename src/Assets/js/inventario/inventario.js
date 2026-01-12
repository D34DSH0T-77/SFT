document.addEventListener('DOMContentLoaded', function () {
    var modalAjustar = document.getElementById('modalAjustar');
    if (!modalAjustar) return;

    modalAjustar.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        if (!button) return;

        var id = button.getAttribute('data-bs-id');
        var inputId = document.getElementById('ajustar_ID_item');
        if (inputId) inputId.value = id;

        // Container
        var container = document.getElementById('lotes-container');
        container.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';

        // Fetch lots
        fetch(BASE_URL + 'Inventario/getLotes/' + id)
            .then((response) => response.json())
            .then((data) => {
                if (Array.isArray(data) && data.length > 0) {
                    renderLotesTable(data, container);
                } else if (Object.keys(data).length > 0) {
                    // Sometimes fetchAll(PDO::FETCH_ASSOC) returns array of rows.
                    // But if fetchAll was used with matching rows, it is an array.
                    // The previous code returned [id => quantity] because of fetchAll(KEY_PAIR)?
                    // No, I changed it to FETCH_ASSOC. So it should be array of objects.
                    renderLotesTable(data, container);
                } else {
                    container.innerHTML = '<div class="alert alert-info">No se encontraron lotes para este producto.</div>';
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                container.innerHTML = '<div class="alert alert-danger">Error al cargar lo lotes.</div>';
            });
    });

    function renderLotesTable(data, container) {
        var html = '<div class="table-responsive"><table class="table table-dark table-sm">';
        html += '<thead><tr><th>ID/Fecha</th><th>Cantidad</th><th>Acción</th></tr></thead><tbody>';

        // Data is expected to be array of objects: [{id, id_torta, cantidad, ...}, ...]
        // If data is just one object (unlikely with fetchAll), wrap it.
        if (!Array.isArray(data)) data = [data];

        data.forEach((lote) => {
            // User requested specific format "lote 1 20" (i.e. Name Quantity).
            // We will display "Lote {id}" in the name column.
            var label = 'Lote ' + lote.id;
            if (lote.created_at) {
                // optionally keep date if useful, but user emphasized "lote 1", "lote 2"
                // label += ' <small class="text-muted">(' + new Date(lote.created_at).toLocaleDateString() + ')</small>';
            }

            html += `<tr>
                <td class="align-middle">${label} <small class="text-muted">(${lote.id})</small></td>
                <td>
                    <input type="number" class="form-control form-control-sm bg-dark text-light" style="max-width: 100px;" 
                           value="${lote.cantidad}" id="qty-${lote.id}">
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-success btn-update-lote" data-id="${lote.id}">
                        Actualizar
                    </button>
                </td>
             </tr>`;
        });

        html += '</tbody></table></div>';
        container.innerHTML = html;

        // Attach event listeners to new buttons
        container.querySelectorAll('.btn-update-lote').forEach((btn) => {
            btn.addEventListener('click', function () {
                var id = this.getAttribute('data-id');
                var qtyInput = document.getElementById('qty-' + id);
                var newQty = qtyInput.value;
                updateLote(id, newQty, this);
            });
        });
    }

    function updateLote(id, cantidad, btn) {
        Swal.fire({
            title: 'Actualizando lote...',
            text: 'Por favor espere mientras se actualiza el lote',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            background: '#252525',
            color: '#fff',
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(BASE_URL + 'Inventario/updateLote', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id, cantidad: cantidad })
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: 'Éxito!',
                        text: 'Lote actualizado correctamente',
                        icon: 'success',
                        background: '#252525',
                        color: '#fff'
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'No se pudo actualizar el lote. Tenga en cuenta que el inventario no se actualiza, solo el lote.',
                        icon: 'error',
                        background: '#252525',
                        color: '#fff'
                    });
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Error de conexión',
                    icon: 'error',
                    background: '#252525',
                    color: '#fff'
                });
            });
    }
});
