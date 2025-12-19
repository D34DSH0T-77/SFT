let TASA_CAMBIO = 65; // Valor inicial por defecto
let carrito = [];
let clienteSeleccionadoId = null;
let modoPago = 'nueva'; // 'nueva' o 'existente'
let idFacturaPago = null;

document.addEventListener('DOMContentLoaded', () => {
    const display = document.getElementById('tasaCambioDisplay');
    if (display) display.textContent = TASA_CAMBIO.toFixed(2);

    fetchTasaBCV();

    // -------------------------------------------------------------------------
    // BUSCADOR DE PRODUCTOS
    // -------------------------------------------------------------------------
    const inputBusqueda = document.getElementById('inputBusquedaProductos');
    if (inputBusqueda) {
        inputBusqueda.addEventListener('input', (e) => filtrarProductos(e.target.value));
    }

    // -------------------------------------------------------------------------
    // BUSCADOR DE CLIENTES
    // -------------------------------------------------------------------------
    const inputBusquedaClientes = document.getElementById('inputBusquedaClientes');
    if (inputBusquedaClientes) {
        inputBusquedaClientes.addEventListener('input', (e) => filtrarClientes(e.target.value));
    }

    // -------------------------------------------------------------------------
    // LISTENERS BOTONES MOSTRAR TODO
    // -------------------------------------------------------------------------
    const btnMostrarTodo = document.getElementById('btnMostrarTodo');
    if (btnMostrarTodo) {
        btnMostrarTodo.addEventListener('click', mostrarTodo);
    }

    const btnMostrarTodoClientes = document.getElementById('btnMostrarTodoClientes');
    if (btnMostrarTodoClientes) {
        btnMostrarTodoClientes.addEventListener('click', mostrarTodoClientes);
    }
    document.addEventListener('click', (e) => {
        // Productos
        if (!e.target.closest('#resultadosBusqueda') &&
            !e.target.closest('#inputBusquedaProductos') &&
            !e.target.closest('#btnMostrarTodo')) {
            const resProd = document.getElementById('resultadosBusqueda');
            if (resProd) resProd.style.display = 'none';
        }

        // Clientes
        if (!e.target.closest('#resultadosBusquedaClientes') &&
            !e.target.closest('#inputBusquedaClientes') &&
            !e.target.closest('#btnMostrarTodoClientes')) {
            const resCli = document.getElementById('resultadosBusquedaClientes');
            if (resCli) resCli.style.display = 'none';
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

            actualizarTablaCarrito();
        }
    } catch (error) {
        console.warn('Error obteniendo tasa BCV, usando valor por defecto:', error);
    }
}

// =============================================================================
// FUNCIONES PRODUCTOS
// =============================================================================

function filtrarProductos(termino) {
    const contenedor = document.getElementById('resultadosBusqueda');
    if (!termino || termino.trim() === '') {
        contenedor.style.display = 'none';
        return;
    }

    termino = termino.toLowerCase();

    const resultados = tortasDisponibles.filter(p =>
        p.nombre.toLowerCase().includes(termino) ||
        (p.id && p.id.toString().includes(termino))
    );

    mostrarResultados(resultados);
}

function mostrarResultados(resultados) {
    const contenedor = document.getElementById('resultadosBusqueda');
    contenedor.innerHTML = '';

    if (resultados.length === 0) {
        contenedor.innerHTML = '<div class="list-group-item">No se encontraron productos</div>';
        contenedor.style.display = 'block';
        return;
    }

    resultados.forEach(p => {
        const item = document.createElement('div');
        item.className = 'list-group-item list-group-item-action cursor-pointer';
        item.style.cursor = 'pointer';
        item.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>${p.nombre}</strong><br>
                    <small class="text-muted">Stock: ${p.stock ?? 'N/A'}</small>
                </div>
                <div class="text-end">
                    <span class="badge bg-primary rounded-pill">$${parseFloat(p.precio).toFixed(2)}</span>
                </div>
            </div>
        `;
        // Aqui agregaremos la logica de seleccion, por ahora solo log y limpiar
        item.addEventListener('click', () => seleccionarProducto(p));
        contenedor.appendChild(item);
    });

    contenedor.style.display = 'block';
}


function seleccionarProducto(producto) {
    console.log("Producto seleccionado:", producto);
    agregarAlCarrito(producto);

    // Limpiar input y cerrar resultados
    const input = document.getElementById('inputBusquedaProductos');
    if (input) {
        input.value = '';
        input.focus();
    }
    document.getElementById('resultadosBusqueda').style.display = 'none';
}

function mostrarTodo() {
    const input = document.getElementById('inputBusquedaProductos');
    if (input) {
        // No borramos el valor del input
        input.focus();
    }
    // Mostrar todas las tortas
    mostrarResultados(tortasDisponibles);
}

// =============================================================================
// FUNCIONES CARRITO
// =============================================================================

function agregarAlCarrito(producto) {
    const existe = carrito.find(p => p.id == producto.id);

    if (existe) {
        existe.cantidad++;
    } else {
        carrito.push({
            id: producto.id,
            nombre: producto.nombre,
            precio: parseFloat(producto.precio),
            stock: producto.stock, // Para validaciones futuras si se requiere
            cantidad: 1
        });
    }

    actualizarTablaCarrito();
}

function actualizarTablaCarrito() {
    const tbody = document.getElementById('tablaProductosVenta');
    if (!tbody) return;

    tbody.innerHTML = '';

    carrito.forEach((prod, index) => {
        const subtotalUsd = prod.precio * prod.cantidad;
        const subtotalBs = subtotalUsd * TASA_CAMBIO;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <div class="d-flex align-items-center">
                    <div class="bg-light rounded p-2 me-2">
                        <i class="material-symbols-sharp text-primary">inventory_2</i>
                    </div>
                    <div>
                        <div class="fw-bold">${prod.nombre}</div>
                        <small class="text-muted">Stock: ${prod.stock ?? 'N/A'}</small>
                    </div>
                </div>
            </td>
            <td>
                <input type="number" class="form-control form-control-sm text-center" 
                    value="${prod.cantidad}" min="1" 
                    onchange="actualizarCantidad(${index}, this.value)">
            </td>
            <td class="text-end">
                <div>${subtotalUsd.toFixed(2)} USD</div>
                <small class="text-muted">${subtotalBs.toFixed(2)} BS</small>
            </td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="eliminarDelCarrito(${index})">
                    <i class="material-symbols-sharp" style="font-size: 16px;">delete</i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });

    actualizarTotales();
}

function actualizarCantidad(index, cantidad) {
    cantidad = parseInt(cantidad);
    if (cantidad < 1) cantidad = 1;

    carrito[index].cantidad = cantidad;
    actualizarTablaCarrito();
}

function eliminarDelCarrito(index) {
    carrito.splice(index, 1);
    actualizarTablaCarrito();
}

function actualizarTotales() {
    let totalUsd = 0;

    carrito.forEach(p => {
        totalUsd += p.precio * p.cantidad;
    });

    const totalBs = totalUsd * TASA_CAMBIO;

    // Asumiendo que subtotal es igual a total (sin impuestos por ahora)
    // Actualizar Subtotales
    setObjetoTexto('totalSubtotalUsd', totalUsd.toFixed(2));
    setObjetoTexto('totalSubtotalBs', totalBs.toFixed(2));

    // Actualizar Totales Finales
    setObjetoTexto('totalVentaUsd', totalUsd.toFixed(2));
    setObjetoTexto('totalVentaBs', totalBs.toFixed(2));
}

function setObjetoTexto(id, valor) {
    const el = document.getElementById(id);
    if (el) el.textContent = valor;
}

// =============================================================================
// FUNCIONES CLIENTES
// =============================================================================

function filtrarClientes(termino) {
    const contenedor = document.getElementById('resultadosBusquedaClientes');
    if (!termino || termino.trim() === '') {
        contenedor.style.display = 'none';
        return;
    }

    termino = termino.toLowerCase();

    const resultados = typeof clientesDisponibles !== 'undefined' ? clientesDisponibles.filter(c =>
        c.nombre.toLowerCase().includes(termino) ||
        c.apellido.toLowerCase().includes(termino) ||
        (c.id && c.id.toString().includes(termino))
    ) : [];

    mostrarResultadosClientes(resultados);
}

function mostrarResultadosClientes(resultados) {
    const contenedor = document.getElementById('resultadosBusquedaClientes');
    contenedor.innerHTML = '';

    if (resultados.length === 0) {
        contenedor.innerHTML = '<div class="list-group-item">No se encontraron clientes</div>';
        contenedor.style.display = 'block';
        return;
    }

    resultados.forEach(c => {
        const item = document.createElement('div');
        item.className = 'list-group-item list-group-item-action cursor-pointer';
        item.style.cursor = 'pointer';
        item.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>${c.nombre} ${c.apellido}</strong>
                </div>
            </div>
        `;
        item.addEventListener('click', () => seleccionarCliente(c));
        contenedor.appendChild(item);
    });

    contenedor.style.display = 'block';
}

function seleccionarCliente(cliente) {
    console.log("Cliente seleccionado:", cliente);

    const input = document.getElementById('inputBusquedaClientes');
    if (input) {
        input.value = `${cliente.nombre} ${cliente.apellido}`;
        clienteSeleccionadoId = cliente.id;
    }

    document.getElementById('resultadosBusquedaClientes').style.display = 'none';
}

function mostrarTodoClientes() {
    const input = document.getElementById('inputBusquedaClientes');
    if (input) {
        input.focus();
    }
    if (typeof clientesDisponibles !== 'undefined') {
        mostrarResultadosClientes(clientesDisponibles);
    }
}

// =============================================================================
// REGISTRAR VENTA / PAGO
// =============================================================================
document.addEventListener('DOMContentLoaded', () => {
    const btnRegistrar = document.getElementById('btnRegistrarVenta');
    if (btnRegistrar) {
        btnRegistrar.addEventListener('click', (e) => {
            e.preventDefault(); // Evitar submit automático
            if (modoPago === 'existente') {
                procesarPagoExistente();
            } else {
                registrarVenta();
            }
        });
    }

    // Resetear modo cuando se abre el modal de venta nueva (si aplica)
    const modalVentaEl = document.getElementById('modalVenta');
    if (modalVentaEl) {
        modalVentaEl.addEventListener('show.bs.modal', () => {
            modoPago = 'nueva';
            idFacturaPago = null;
        });
    }
});

window.prepararPago = function (idFactura) {
    modoPago = 'existente';
    idFacturaPago = idFactura;

    // Abrir modal de pagos directamnente
    const modalPagosEl = document.getElementById('modalPagos');
    const modal = new bootstrap.Modal(modalPagosEl);

    // Limpiar campos
    document.getElementById('pagoMonto').value = '';

    modal.show();
}

async function procesarPagoExistente() {
    const metodo = document.getElementById('pagoMetodo')?.value;
    const monto = parseFloat(document.getElementById('pagoMonto')?.value) || 0;

    if (monto <= 0) {
        alert('Ingrese un monto de pago válido');
        return;
    }

    // Conversión rápida si es BS a USD (asumiendo backend en USD y tasa front)
    let pagoReal = monto;
    if (metodo !== 'Divisa' && metodo !== 'Efectivo USD') {
        pagoReal = monto / TASA_CAMBIO;
    }

    try {
        const response = await fetch(`/SFT/Ventas/agregarPago`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id_factura: idFacturaPago,
                metodo: metodo,
                monto: pagoReal
            })
        });

        const data = await response.json();
        if (data.status) {
            alert('Pago registrado correctamente');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        console.error(error);
        alert('Error al registrar pago');
    }
}

async function registrarVenta() {
    if (carrito.length === 0) {
        alert('El carrito está vacío');
        return;
    }

    if (!clienteSeleccionadoId) {
        alert('Debe seleccionar un cliente');
        return;
    }

    const form = document.getElementById('formVenta');
    const hiddenContainer = document.getElementById('hiddenInputsContainer');
    hiddenContainer.innerHTML = ''; // Limpiar anteriores

    // 1. Agregar Cliente ID
    document.getElementById('inputClienteId').value = clienteSeleccionadoId;

    // 2. Agregar Productos del Carrito como inputs ocultos
    carrito.forEach((prod, index) => {
        // ID Torta
        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'id_torta[]';
        inputId.value = prod.id;
        hiddenContainer.appendChild(inputId);

        // Cantidad
        const inputCant = document.createElement('input');
        inputCant.type = 'hidden';
        inputCant.name = 'cantidad[]';
        inputCant.value = prod.cantidad;
        hiddenContainer.appendChild(inputCant);

        // Precio
        const inputPrecio = document.createElement('input');
        inputPrecio.type = 'hidden';
        inputPrecio.name = 'precio[]';
        inputPrecio.value = prod.precio; // Precio en USD (o base)
        hiddenContainer.appendChild(inputPrecio);
    });

    // Enviar Tasa de Cambio
    const inputTasa = document.createElement('input');
    inputTasa.type = 'hidden';
    inputTasa.name = 'tasa';
    inputTasa.value = TASA_CAMBIO;
    hiddenContainer.appendChild(inputTasa);

    // 3. Validar Monto (Opcional: Si el usuario quiere permitir vacio, no validamos > 0 estricto)
    // El backend ya maneja vacios como 0.

    // 4. Submit Form
    form.submit();
}
