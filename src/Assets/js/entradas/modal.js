document.addEventListener('DOMContentLoaded', function () {
    // Elementos del Buscador
    const inputBusqueda = document.getElementById('inputBusquedaProductos');
    const btnMostrarTodo = document.getElementById('btnMostrarTodo');
    const resultadosContainer = document.getElementById('resultadosBusqueda');
    const tortaSelectHidden = document.getElementById('tortaSelect'); // Hidden input for compatibility or just state

    const cantidadInput = document.getElementById('cantidadInput');
    const btnAgregar = document.getElementById('btnAgregar');
    const listaTortas = document.getElementById('listaTortas');
    const emptyMessage = document.getElementById('emptyMessage');
    const btnGuardar = document.getElementById('btnGuardar');
    const form = document.getElementById('formEntrada');

    let productoSeleccionado = null;

    // -------------------------------------------------------------------------
    // BUSCADOR LOGIC
    // -------------------------------------------------------------------------
    if (inputBusqueda) {
        inputBusqueda.addEventListener('input', (e) => filtrarProductos(e.target.value));
        
        // Close search when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('#resultadosBusqueda') && !e.target.closest('#inputBusquedaProductos') && !e.target.closest('#btnMostrarTodo')) {
                if (resultadosContainer) resultadosContainer.style.display = 'none';
            }
        });
    }

    if (btnMostrarTodo) {
        btnMostrarTodo.addEventListener('click', mostrarTodo);
    }

    function filtrarProductos(termino) {
        if (!termino || termino.trim() === '') {
            resultadosContainer.style.display = 'none';
            return;
        }
        termino = termino.toLowerCase();
        // tortasDisponibles defined in the view
        const resultados = typeof tortasDisponibles !== 'undefined' 
            ? tortasDisponibles.filter((p) => p.nombre.toLowerCase().includes(termino)) 
            : [];
        mostrarResultados(resultados);
    }

    function mostrarTodo() {
         if (inputBusqueda) inputBusqueda.focus();
         if (typeof tortasDisponibles !== 'undefined') {
             mostrarResultados(tortasDisponibles);
         }
    }

    function mostrarResultados(resultados) {
        resultadosContainer.innerHTML = '';
        if (resultados.length === 0) {
            resultadosContainer.innerHTML = '<div class="list-group-item">No se encontraron productos</div>';
            resultadosContainer.style.display = 'block';
            return;
        }

        resultados.forEach((p) => {
            // Check stock if available
            const stockInfo = p.stock !== undefined ? `Stock: ${p.stock}` : '';

            const item = document.createElement('div');
            item.className = 'list-group-item list-group-item-action cursor-pointer';
            item.style.cursor = 'pointer';
            item.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${p.nombre}</strong><br>
                        <small class="text-muted">${stockInfo}</small>
                    </div>
                </div>
            `;
            item.addEventListener('click', () => seleccionarProducto(p));
            resultadosContainer.appendChild(item);
        });
        resultadosContainer.style.display = 'block';
    }

    function seleccionarProducto(producto) {
        productoSeleccionado = producto;
        
        // Update Search Input to show selection
        if (inputBusqueda) inputBusqueda.value = producto.nombre;
        
        // Update Hidden Input (if still needed)
        if (tortaSelectHidden) tortaSelectHidden.value = producto.id;

        resultadosContainer.style.display = 'none';
        
        // Auto-focus quantity
        if (cantidadInput) {
            cantidadInput.focus();
            cantidadInput.select();
        }
    }

    // -------------------------------------------------------------------------
    // OTHER LOGIC
    // -------------------------------------------------------------------------

    // Elementos del Modal de Confirmación
    const modalConfirmacionEl = document.getElementById('modalConfirmacion');
    const btnConfirmarEnvio = document.getElementById('btnConfirmarEnvio');
    const totalBsInput = document.getElementById('totalBsInput');
    const totalUsdInput = document.getElementById('totalUsdInput');
    const tasaInput = document.getElementById('tasaInput');

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
        if (!productoSeleccionado) {
             Swal.fire({
                title: 'Error!',
                text: 'Por favor busque y seleccione una torta.',
                icon: 'error',
                background: '#252525',
                color: '#fff'
            });
            return;
        }

        const idTorta = productoSeleccionado.id;
        const nombreTorta = productoSeleccionado.nombre;
        const cantidad = parseInt(cantidadInput.value);

        const bolivares = 0;
        const dolar = 0;

        if (!idTorta || isNaN(cantidad) || cantidad <= 0) {
            Swal.fire({
                title: 'Error!',
                text: 'Por favor seleccione una torta y una cantidad válida.',
                icon: 'error',
                background: '#252525',
                color: '#fff'
            });
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
        inputBusqueda.value = '';
        if (tortaSelectHidden) tortaSelectHidden.value = '';
        productoSeleccionado = null;
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
                Swal.fire({
                    title: 'Error!',
                    text: 'La lista está vacía. Agregue al menos una torta.',
                    icon: 'error',
                    background: '#252525',
                    color: '#fff'
                });
                return;
            }

            if (!form.codigo.value || !form.fecha.value || !form.local.value) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Por favor complete todos los datos de la entrada (Código, Fecha, Local)',
                    icon: 'error',
                    background: '#252525',
                    color: '#fff'
                });
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
                Swal.fire({
                    title: 'Error!',
                    text: 'Por favor ingrese montos válidos para el total.',
                    icon: 'error',
                    background: '#252525',
                    color: '#fff'
                });
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
