let TASA_CAMBIO = 60; // Valor inicial por defecto

document.addEventListener('DOMContentLoaded', () => {
    fetchTasaBCV();

    const inputBusqueda = document.getElementById('inputBusquedaVentas');
    if (inputBusqueda) {
        inputBusqueda.addEventListener('input', (e) => filtrarVentas(e.target.value));
    }

    const btnMostrarTodo = document.getElementById('btnMostrarTodasVentas');
    if (btnMostrarTodo) {
        btnMostrarTodo.addEventListener('click', (e) => {
            e.stopPropagation();
            mostrarTodasVentas();
        });
    }

    // Listener para cerrar resultados al hacer click fuera
    document.addEventListener('click', (e) => {
        if (!e.target.closest('#resultadosBusquedaVentas') && !e.target.closest('#inputBusquedaVentas') && !e.target.closest('#btnMostrarTodasVentas')) {
            const res = document.getElementById('resultadosBusquedaVentas');
            if (res) res.style.display = 'none';
        }
    });
});

async function fetchTasaBCV() {
    try {
        const response = await fetch('https://ve.dolarapi.com/v1/dolares/oficial');
        const data = await response.json();

        if (data && data.promedio) {
            TASA_CAMBIO = data.promedio;
            console.log('Tasa BCV actualizada:', TASA_CAMBIO);

            const display = document.getElementById('tasaCambioDisplay');
            if (display) display.textContent = TASA_CAMBIO.toFixed(2);

            // Recalculate if there are items
            // const inputs = document.querySelectorAll('.input-cantidad-devolver');
            // if (inputs.length > 0) { ... } // Optional, usually user flow starts empty
        }
    } catch (error) {
        console.warn('Error obteniendo tasa BCV, usando valor por defecto:', error);
    }
}

function filtrarVentas(termino) {
    const contenedor = document.getElementById('resultadosBusquedaVentas');
    if (!termino || termino.trim() === '') {
        contenedor.style.display = 'none';
        return;
    }

    termino = termino.toLowerCase();

    const resultados =
        typeof ventasDisponibles !== 'undefined'
            ? ventasDisponibles.filter((v) => (v.codigo && v.codigo.toLowerCase().includes(termino)) || (v.cliente && v.cliente.toLowerCase().includes(termino)))
            : [];

    mostrarResultadosVentas(resultados);
}

function mostrarTodasVentas() {
    const input = document.getElementById('inputBusquedaVentas');
    if (input) input.focus();

    const resultados = typeof ventasDisponibles !== 'undefined' ? ventasDisponibles : [];
    mostrarResultadosVentas(resultados);
}

function mostrarResultadosVentas(resultados) {
    const contenedor = document.getElementById('resultadosBusquedaVentas');
    contenedor.innerHTML = '';

    if (resultados.length === 0) {
        contenedor.innerHTML = '<div class="list-group-item">No se encontraron ventas</div>';
        contenedor.style.display = 'block';
        return;
    }

    resultados.forEach((v) => {
        const item = document.createElement('div');
        item.className = 'list-group-item list-group-item-action cursor-pointer';
        item.style.cursor = 'pointer';
        item.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>${v.codigo}</strong><br>
                    <small class="text-muted">Cliente: ${v.cliente}</small>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary rounded-pill">$${parseFloat(v.total_usd).toFixed(2)}</span>
                    <br>
                    <small class="text-muted">${v.fecha}</small>
                </div>
            </div>
        `;
        item.addEventListener('click', () => seleccionarVenta(v));
        contenedor.appendChild(item);
    });

    contenedor.style.display = 'block';
}

function seleccionarVenta(venta) {
    console.log('Venta seleccionada:', venta);

    const input = document.getElementById('inputBusquedaVentas');
    if (input) {
        input.value = `${venta.codigo} - ${venta.cliente}`;
    }

    // Populate hidden inputs
    const hiddenCodigo = document.getElementById('inputCodigoVentaHidden');
    if (hiddenCodigo) {
        hiddenCodigo.value = venta.codigo; // Send only the code
    }

    const itemsContainer = document.getElementById('itemsDevolucionContainer');
    if (itemsContainer) {
        itemsContainer.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Cargando...</span></div></div>';

        // Fetch detalles
        fetch(RUTA_BASE + 'Devoluciones/getDetallesVenta/' + venta.id)
            .then((response) => response.json())
            .then((data) => {
                if (data.status && data.detalles.length > 0) {
                    let html = `
                        <div class="alert alert-success mb-3">
                            Venta <strong>${venta.codigo}</strong> seleccionada.<br>
                            Cliente: ${venta.cliente}<br>
                            Total: $${parseFloat(venta.total_usd).toFixed(2)}
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Cant. Vendida</th>
                                        <th class="text-center">Precio Unit.</th>
                                        <th class="text-center" width="120px">Devolver</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;

                    data.detalles.forEach((d) => {
                        html += `
                            <tr>
                                <td>${d.tortas}</td>
                                <td class="text-center">${d.cantidad}</td>
                                <td class="text-center">$${parseFloat(d.precio_usd).toFixed(2)}</td>
                                <td class="text-center">
                                    <input type="number" class="form-control form-control-sm text-center input-cantidad-devolver" 
                                        name="detalles[${d.id}]"
                                        data-id-detalle="${d.id}" 
                                        data-max="${d.cantidad}" 
                                        min="0" max="${d.cantidad}" value="0">
                                </td>
                            </tr>
                        `;
                    });

                    html += `
                                </tbody>
                            </table>
                        </div>
                    `;
                    itemsContainer.innerHTML = html;
                } else {
                    itemsContainer.innerHTML = '<div class="alert alert-warning">No se encontraron detalles para esta venta o no tiene items.</div>';
                }

                // Add listeners for calculation
                const inputs = document.querySelectorAll('.input-cantidad-devolver');
                inputs.forEach(input => {
                    input.addEventListener('input', () => calcularTotalesDevolucion(data.detalles));
                });

            })
            .catch((error) => {
                console.error('Error:', error);
                itemsContainer.innerHTML = '<div class="alert alert-danger">Error al cargar los detalles de la venta.</div>';
            });
    }

    document.getElementById('resultadosBusquedaVentas').style.display = 'none';
}

function calcularTotalesDevolucion(detalles) {
    let totalUsd = 0;

    const inputs = document.querySelectorAll('.input-cantidad-devolver');
    inputs.forEach(input => {
        const idDetalle = input.dataset.idDetalle;
        const cantidad = parseFloat(input.value) || 0;

        // Find original price from details
        const detalle = detalles.find(d => d.id == idDetalle);
        if (detalle) {
            totalUsd += cantidad * parseFloat(detalle.precio_usd);
        }
    });

    // Use global TASA_CAMBIO updated by fetchTasaBCV
    const tasa = typeof TASA_CAMBIO !== 'undefined' ? TASA_CAMBIO : 60;
    const totalBs = totalUsd * tasa;

    // Update hidden inputs
    const inputBs = document.getElementById('inputTotalBsHidden');
    const inputUsd = document.getElementById('inputTotalUsdHidden');

    if (inputBs) inputBs.value = totalBs.toFixed(2);
    if (inputUsd) inputUsd.value = totalUsd.toFixed(2);

    console.log(`Totales calculados: $${totalUsd.toFixed(2)} / Bs ${totalBs.toFixed(2)}`);
}

