document.addEventListener('DOMContentLoaded', function () {
    const tortaSelect = document.getElementById('tortaSelect');
    const cantidadInput = document.getElementById('cantidadInput');
    const btnAgregar = document.getElementById('btnAgregar');
    const listaTortas = document.getElementById('listaTortas');
    const emptyMessage = document.getElementById('emptyMessage');
    const btnGuardar = document.getElementById('btnGuardar');

    let detalles = [];

    btnAgregar.addEventListener('click', function () {
        const idTorta = tortaSelect.value;
        const nombreTorta = tortaSelect.options[tortaSelect.selectedIndex]?.dataset.nombre;
        const cantidad = parseInt(cantidadInput.value);

        if (!idTorta || isNaN(cantidad) || cantidad <= 0) {
            alert('Por favor seleccione una torta y una cantidad válida.');
            return;
        }

        // Check for duplicates
        const existingIndex = detalles.findIndex((item) => item.id === idTorta);

        if (existingIndex !== -1) {
            detalles[existingIndex].cantidad += cantidad;
        } else {
            detalles.push({
                id: idTorta,
                nombre: nombreTorta,
                cantidad: cantidad
            });
        }

        renderTable();

        // Reset inputs
        tortaSelect.value = '';
        cantidadInput.value = 1;
    });

    function renderTable() {
        listaTortas.innerHTML = '';

        if (detalles.length === 0) {
            emptyMessage.style.display = 'block';
        } else {
            emptyMessage.style.display = 'none';

            detalles.forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                                    <td>${item.nombre}</td>
                                    <td class="text-center">${item.cantidad}</td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-danger btn-remove" data-index="${index}">
                                            <span class="material-symbols-sharp" style="font-size: 1rem;">delete</span>
                                        </button>
                                    </td>
                                `;
                listaTortas.appendChild(row);
            });

            // Add event listeners to remove buttons
            document.querySelectorAll('.btn-remove').forEach((btn) => {
                btn.addEventListener('click', function () {
                    const index = this.dataset.index;
                    detalles.splice(index, 1);
                    renderTable();
                });
            });
        }
    }

    btnGuardar.addEventListener('click', function () {
        if (detalles.length === 0) {
            alert('La lista está vacía. Agregue al menos una torta.');
            return;
        }

        // Here you would typically submit the data via AJAX or a hidden form
        console.log('Guardando entrada:', detalles);
        alert('Funcionalidad de guardado pendiente de implementar en el backend.\nDatos a enviar: ' + JSON.stringify(detalles));
    });
});
