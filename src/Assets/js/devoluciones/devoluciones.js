document.addEventListener('DOMContentLoaded', () => {
    const inputBusqueda = document.getElementById('inputBusquedaVentas');
    if (inputBusqueda) {
        inputBusqueda.addEventListener('input', (e) => filtrarVentas(e.target.value));
    }

    // Listener para cerrar resultados al hacer click fuera
    document.addEventListener('click', (e) => {
        if (!e.target.closest('#resultadosBusquedaVentas') && !e.target.closest('#inputBusquedaVentas')) {
            const res = document.getElementById('resultadosBusquedaVentas');
            if (res) res.style.display = 'none';
        }
    });
});

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
            })
            .catch((error) => {
                console.error('Error:', error);
                itemsContainer.innerHTML = '<div class="alert alert-danger">Error al cargar los detalles de la venta.</div>';
            });
    }

    document.getElementById('resultadosBusquedaVentas').style.display = 'none';
}
