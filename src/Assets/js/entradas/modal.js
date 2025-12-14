document.addEventListener('DOMContentLoaded', function () {
    const tortaSelect = document.getElementById('tortaSelect');
    const cantidadInput = document.getElementById('cantidadInput');
    // Removed individual price inputs
    const btnAgregar = document.getElementById('btnAgregar');
    const listaTortas = document.getElementById('listaTortas');
    const emptyMessage = document.getElementById('emptyMessage');
    const btnGuardar = document.getElementById('btnGuardar');
    const form = document.getElementById('formEntrada');

    // New elements for confirmation
    const modalConfirmacionEl = document.getElementById('modalConfirmacion');
    const btnConfirmarEnvio = document.getElementById('btnConfirmarEnvio');
    const totalBsInput = document.getElementById('totalBsInput');
    const totalUsdInput = document.getElementById('totalUsdInput');
    let modalConfirmacion = null;

    if (modalConfirmacionEl) {
        modalConfirmacion = new bootstrap.Modal(modalConfirmacionEl);
    }

    // Set default date to today and generate code
    const fechaInput = document.getElementById('fechaInput');
    const codigoInput = document.getElementById('codigoInput');

    if (fechaInput) {
        const today = new Date();
        const yyyy = today.getFullYear();
        const yy = String(yyyy).slice(-2);
        const mm = String(today.getMonth() + 1).padStart(2, '0');
        const dd = String(today.getDate()).padStart(2, '0');

        fechaInput.value = `${yyyy}-${mm}-${dd}`;

        if (codigoInput) {
            const randomStr = Math.random().toString(36).substring(2, 7).toUpperCase();
            codigoInput.value = `ENT-${dd}${mm}${yy}-${randomStr}`;
        }
    }

    let detalles = [];

    btnAgregar.addEventListener('click', function () {
        const idTorta = tortaSelect.value;
        const nombreTorta = tortaSelect.options[tortaSelect.selectedIndex]?.dataset.nombre;
        const cantidad = parseInt(cantidadInput.value);

        // Prices are now 0 initially, will be calculated at the end
        const bolivares = 0;
        const dolar = 0;

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
                cantidad: cantidad,
                bolivares: bolivares,
                dolar: dolar
            });
        }

        // Clear input values
        tortaSelect.value = '';
        cantidadInput.value = '1';

        renderTable();
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

    if (btnGuardar) {
        btnGuardar.addEventListener('click', function (e) {
            e.preventDefault();

            if (detalles.length === 0) {
                alert('La lista está vacía. Agregue al menos una torta.');
                return;
            }

            // Validate main fields
            if (!form.codigo.value || !form.fecha.value || !form.local.value) {
                alert('Por favor complete todos los datos de la entrada (Código, Fecha, Local)');
                return;
            }

            // Show confirmation modal
            if (modalConfirmacion) {
                modalConfirmacion.show();
            } else {
                // Fallback if bootstrap modal fails
                if (confirm('Confirmar envío? (No se puede ingresar precio total sin el modal)')) {
                    submitForm(0, 0);
                }
            }
        });
    }

    if (btnConfirmarEnvio) {
        btnConfirmarEnvio.addEventListener('click', function () {
            const totalBs = parseFloat(totalBsInput.value);
            const totalUsd = parseFloat(totalUsdInput.value);

            if (isNaN(totalBs) || totalBs < 0 || isNaN(totalUsd) || totalUsd < 0) {
                alert('Por favor ingrese montos válidos para el total.');
                return;
            }

            submitForm(totalBs, totalUsd);
        });
    }

    function submitForm(totalBs, totalUsd) {
        // Distribute prices
        // Strategy: Calculate average unit price based on TOTAL QUANTITY of items
        let totalItemsQty = detalles.reduce((sum, item) => sum + item.cantidad, 0);

        if (totalItemsQty > 0) {
            const unitBs = totalBs / totalItemsQty;
            const unitUsd = totalUsd / totalItemsQty;

            // Update details with calculated unit prices
            detalles = detalles.map((item) => {
                return {
                    ...item,
                    bolivares: unitBs, // This is unit price.
                    dolar: unitUsd
                };
            });
        }

        // Create hidden inputs for arrays
        detalles.forEach((item) => {
            addHiddenInput('id_torta[]', item.id);
            addHiddenInput('cantidad[]', item.cantidad);
            // The controller expects UNIT PRICE? Or Total Line Price?
            // "precio_bs" usually is unit price in 'Detalles'.
            // Let's assume Unit Price because we multiplied by quantity in average.
            addHiddenInput('precio_bs[]', item.bolivares);
            addHiddenInput('precio_usd[]', item.dolar);
        });

        // Add total prices to the form
        addHiddenInput('precio_bs', totalBs);
        addHiddenInput('precio_usd', totalUsd);

        form.submit();
    }

    function addHiddenInput(name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        form.appendChild(input);
    }
});
