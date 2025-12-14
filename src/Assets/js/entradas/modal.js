document.addEventListener('DOMContentLoaded', function () {
    const tortaSelect = document.getElementById('tortaSelect');
    const cantidadInput = document.getElementById('cantidadInput');
    const btnAgregar = document.getElementById('btnAgregar');
    const listaTortas = document.getElementById('listaTortas');
    const emptyMessage = document.getElementById('emptyMessage');
    const btnGuardar = document.getElementById('btnGuardar');
    const form = document.getElementById('formEntrada');

    // Elementos del Modal de Confirmación
    const modalConfirmacionEl = document.getElementById('modalConfirmacion');
    const btnConfirmarEnvio = document.getElementById('btnConfirmarEnvio');
    const totalBsInput = document.getElementById('totalBsInput');
    const totalUsdInput = document.getElementById('totalUsdInput');
    const tasaInput = document.getElementById('tasaInput'); // Nuevo elemento

    let modalConfirmacion = null;

    if (modalConfirmacionEl) {
        modalConfirmacion = new bootstrap.Modal(modalConfirmacionEl);
        fetchTasaBCV();
    }

    async function fetchTasaBCV() {
        try {
            const response = await fetch('https://ve.dolarapi.com/v1/dolares/oficial');
            const data = await response.json();

            if (data && data.promedio) {
                tasaInput.value = data.promedio;
                tasaInput.dispatchEvent(new Event('input'));
            }
        } catch (error) {
            console.warn('No se pudo obtener la tasa automática, ingrésela manual.', error);
        }
    }

    if (tasaInput) {
        tasaInput.addEventListener('input', function () {
            if (totalUsdInput.value > 0) {
                calculateFromUsd();
            } else if (totalBsInput.value > 0) {
                calculateFromBs();
            }
        });
    }

    if (totalBsInput) {
        totalBsInput.addEventListener('input', calculateFromBs);
    }

    if (totalUsdInput) {
        totalUsdInput.addEventListener('input', calculateFromUsd);
    }

    function calculateFromBs() {
        const bs = parseFloat(totalBsInput.value) || 0;
        const tasa = parseFloat(tasaInput.value) || 0;

        if (tasa > 0) {
            totalUsdInput.value = (bs / tasa).toFixed(2);
        }
    }

    function calculateFromUsd() {
        const usd = parseFloat(totalUsdInput.value) || 0;
        const tasa = parseFloat(tasaInput.value) || 0;

        if (tasa > 0) {
            totalBsInput.value = (usd * tasa).toFixed(2);
        }
    }

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

            if (!form.codigo.value || !form.fecha.value || !form.local.value) {
                alert('Por favor complete todos los datos de la entrada (Código, Fecha, Local)');
                return;
            }

            if (modalConfirmacion) {
                // Al abrir el modal, intentamos refrescar la tasa si está vacía
                if (!tasaInput.value) fetchTasaBCV();
                modalConfirmacion.show();
            } else {
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
        let totalItemsQty = detalles.reduce((sum, item) => sum + item.cantidad, 0);

        if (totalItemsQty > 0) {
            const unitBs = totalBs / totalItemsQty;
            const unitUsd = totalUsd / totalItemsQty;

            detalles = detalles.map((item) => {
                return {
                    ...item,
                    bolivares: unitBs,
                    dolar: unitUsd
                };
            });
        }

        detalles.forEach((item) => {
            addHiddenInput('id_torta[]', item.id);
            addHiddenInput('cantidad[]', item.cantidad);
            addHiddenInput('precio_bs[]', item.bolivares);
            addHiddenInput('precio_usd[]', item.dolar);
        });

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
