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
        btnMostrarTodo.addEventListener('click', (e) => {
            e.stopPropagation();
            mostrarTodo();
        });
    }

    const btnMostrarTodoClientes = document.getElementById('btnMostrarTodoClientes');
    if (btnMostrarTodoClientes) {
        btnMostrarTodoClientes.addEventListener('click', (e) => {
            e.stopPropagation();
            mostrarTodoClientes();
        });
    }
    document.addEventListener('click', (e) => {
        // Productos
        if (!e.target.closest('#resultadosBusqueda') && !e.target.closest('#inputBusquedaProductos') && !e.target.closest('#btnMostrarTodo')) {
            const resProd = document.getElementById('resultadosBusqueda');
            if (resProd) resProd.style.display = 'none';
        }

        // Clientes
        if (!e.target.closest('#resultadosBusquedaClientes') && !e.target.closest('#inputBusquedaClientes') && !e.target.closest('#btnMostrarTodoClientes')) {
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

    const resultados = tortasDisponibles.filter((p) => p.nombre.toLowerCase().includes(termino) || (p.id && p.id.toString().includes(termino)));

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

    resultados.forEach((p) => {
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
    console.log('Producto seleccionado:', producto);
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
    const existe = carrito.find((p) => p.id == producto.id);

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
                        <img src="${prod.imagen ? RUTA_BASE + 'img/tortas/' + prod.imagen : RUTA_BASE + 'src/Assets/img/icono.ico'}" 
                             alt="${prod.nombre}" 
                             class="img-fluid" 
                             style="max-width: 50px; height: auto;"
                             onerror="this.onerror=null; this.src='${RUTA_BASE}src/Assets/img/icono.ico';">
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

    carrito.forEach((p) => {
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

    // Si estamos en modo nueva venta, el restante es el total
    setObjetoTexto('restanteUsdDisplay', totalUsd.toFixed(2));
    setObjetoTexto('restanteBsDisplay', totalBs.toFixed(2));
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

    const resultados =
        typeof clientesDisponibles !== 'undefined'
            ? clientesDisponibles.filter(
                (c) => c.nombre.toLowerCase().includes(termino) || c.apellido.toLowerCase().includes(termino) || (c.id && c.id.toString().includes(termino))
            )
            : [];

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

    resultados.forEach((c) => {
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
    console.log('Cliente seleccionado:', cliente);

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
// NUEVO CLIENTE AJAX
// =============================================================================
document.addEventListener('DOMContentLoaded', () => {
    // Listener boton + Nuevo
    const btnNuevo = document.getElementById('btnNuevoCliente');
    if (btnNuevo) {
        btnNuevo.addEventListener('click', (e) => {
            e.preventDefault();
            // Abrir modal
            const el = document.getElementById('modalNuevoClienteAjax');
            if (el) {
                const modal = new bootstrap.Modal(el);
                modal.show();
            }
        });
    }

    // Listener Form Submit
    const formAjax = document.getElementById('formNuevoClienteAjax');
    if (formAjax) {
        formAjax.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Disable button and show loading
            const btnSubmit = formAjax.querySelector('button[type="submit"]');
            if (btnSubmit) btnSubmit.disabled = true;

            Swal.fire({
                title: 'Guardando cliente...',
                text: 'Por favor espere',
                didOpen: () => {
                    Swal.showLoading();
                },
                allowOutsideClick: false,
                background: '#252525',
                color: '#fff'
            });
            e.preventDefault();

            const nombre = document.getElementById('nombreAjax').value;
            const apellido = document.getElementById('apellidoAjax').value;

            try {
                const response = await fetch(RUTA_BASE + 'Clientes/agregarAjax', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nombre, apellido })
                });

                const data = await response.json();

                if (data.status) {
                    // 1. Cerrar Modal
                    const el = document.getElementById('modalNuevoClienteAjax');
                    const modal = bootstrap.Modal.getInstance(el);
                    modal.hide();

                    // 2. Agregar a la lista local
                    const newClient = {
                        id: data.data.id,
                        nombre: data.data.nombre,
                        apellido: data.data.apellido,
                        estado: 'Activo'
                    };

                    if (typeof clientesDisponibles !== 'undefined') {
                        clientesDisponibles.push(newClient);
                    }

                    // 3. Seleccionar automaticamente
                    seleccionarCliente(newClient);

                    // 4. Limpiar form
                    document.getElementById('nombreAjax').value = '';
                    document.getElementById('apellidoAjax').value = '';

                    Swal.fire({
                        title: 'Excelente!',
                        text: 'Cliente creado y seleccionado',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false,
                        background: '#252525',
                        color: '#fff'
                    });

                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message,
                        icon: 'error',
                        background: '#252525',
                        color: '#fff'
                    });
                }
            } catch (error) {
                console.error(error);
                Swal.fire({
                    title: 'Error',
                    text: 'Error de conexión',
                    icon: 'error',
                    background: '#252525',
                    color: '#fff'
                });
            }
        });
    }
});

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

    // LISTENER PARA EL BOTON COBRAR (VALIDAR CARITO VACIO)
    const btnCobrar = document.getElementById('btnCobrar');
    if (btnCobrar) {
        btnCobrar.addEventListener('click', (e) => {
            e.preventDefault();

            if (carrito.length === 0) {
                Swal.fire({
                    title: 'Carrito vacío!',
                    text: 'Debe agregar al menos una torta para cobrar.',
                    icon: 'warning',
                    background: '#252525',
                    color: '#fff'
                });
                return;
            }

            // Si hay productos, abrir el modal de pagos
            const modalPagosEl = document.getElementById('modalPagos');
            const modalPagos = new bootstrap.Modal(modalPagosEl);
            modalPagos.show();
        });
    }
});

let restanteUsdGlobal = 0; // Para validación

window.prepararPago = async function (idFactura) {
    modoPago = 'existente';
    idFacturaPago = idFactura;
    restanteUsdGlobal = 0; // Resetear

    // Abrir modal de pagos directamnente
    const modalPagosEl = document.getElementById('modalPagos');
    const modal = new bootstrap.Modal(modalPagosEl);

    // Limpiar campos
    document.getElementById('pagoMonto').value = '';

    // Resetear displays
    setObjetoTexto('restanteUsdDisplay', 'Cargando...');
    setObjetoTexto('restanteBsDisplay', '...');

    modal.show();

    // Fetch saldo real
    try {
        const response = await fetch(RUTA_BASE + 'Ventas/getSaldo/' + idFactura);
        const data = await response.json();

        if (data && data.status) {
            const restanteUsd = parseFloat(data.restante_usd);
            restanteUsdGlobal = restanteUsd; // Guardar referencia global
            const restanteBs = restanteUsd * TASA_CAMBIO;

            setObjetoTexto('restanteUsdDisplay', restanteUsd.toFixed(2));
            setObjetoTexto('restanteBsDisplay', restanteBs.toFixed(2));

            // Si está pagado, deshabilitar botón o mostrar mensaje?
            // Por ahora solo mostramos 0.00

            // Trigger validación visual inicial (limpia colores previos)
            validarMontoVisualmente();
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Error obteniendo saldo',
                icon: 'error',
                background: '#252525',
                color: '#fff'
            });
        }
    } catch (e) {
        console.error(e);
        Swal.fire({
            title: 'Error!',
            text: 'Error obteniendo saldo',
            icon: 'error',
            background: '#252525',
            color: '#fff'
        });
        setObjetoTexto('restanteUsdDisplay', 'Error');
    }

    // Listeners para validación visual en tiempo real
    const inputMonto = document.getElementById('pagoMonto');
    const inputMetodo = document.getElementById('pagoMetodo');

    if (inputMonto) {
        // Remover listeners previos para evitar duplicados si se llama varias veces
        // Aunque prepararPago asigna valores, los listeners se acumulan si no se tiene cuidado.
        // Mejor usar oninput directo o asegurar que solo se agregan una vez.
        inputMonto.oninput = validarMontoVisualmente;
    }
    if (inputMetodo) {
        inputMetodo.onchange = validarMontoVisualmente;
    }
};

function validarMontoVisualmente() {
    const inputMonto = document.getElementById('pagoMonto');
    const inputMetodo = document.getElementById('pagoMetodo');
    const displayUsd = document.getElementById('restanteUsdDisplay');
    const displayBs = document.getElementById('restanteBsDisplay');
    const labelMoneda = document.getElementById('pagoMonedaLabel');

    if (!inputMonto || !displayUsd) return;

    const monto = parseFloat(inputMonto.value) || 0;
    const metodo = inputMetodo ? inputMetodo.value : 'Divisa';

    // Conversión a USD para validar
    let pagoReal = monto;
    let monedaActual = 'BS';

    if (metodo !== 'Divisa' && metodo !== 'Efectivo USD') {
        pagoReal = monto / TASA_CAMBIO;
        monedaActual = 'BS';
    } else {
        // Es Divisa
        monedaActual = '$';
    }

    // Actualizar Label de Moneda
    if (labelMoneda) {
        labelMoneda.textContent = monedaActual;
    }

    // Lógica de colores check
    // REQUERIMIENTO USUARIO:
    // - Exacto match -> VERDE
    // - Diferente (Mayor o Menor) -> ROJO

    const diff = pagoReal - restanteUsdGlobal;

    // Reset basics
    displayUsd.classList.remove('text-success', 'text-danger');
    displayBs.classList.remove('text-success', 'text-danger');

    if (monto > 0) {
        // Usamos Math.abs para ver si es igual (con margen de error)
        if (Math.abs(diff) <= 0.01) {
            // Exacto -> VERDE
            displayUsd.classList.add('text-success');
            displayBs.classList.add('text-success');
        } else {
            // Diferente (Mayor o Menor) -> ROJO
            displayUsd.classList.add('text-danger');
            displayBs.classList.add('text-danger');

            // Si es mayor, podríamos mostrar alerta extra, pero ya el bloque de procesar lo hace al enviar
        }
    } else {
        // Nada escrito -> ROJO
        displayUsd.classList.add('text-danger');
        displayBs.classList.add('text-danger');
    }
}

async function procesarPagoExistente() {
    const metodo = document.getElementById('pagoMetodo')?.value;
    const monto = parseFloat(document.getElementById('pagoMonto')?.value) || 0;

    if (monto <= 0) {
        Swal.fire({
            title: 'Pago Invalidp!',
            text: 'Por faor ingrese un monto de pago válido',
            icon: 'error',
            background: '#252525',
            color: '#fff'
        });
        return;
    }

    // Conversión rápida si es BS a USD (asumiendo backend en USD y tasa front)
    let pagoReal = monto;
    if (metodo !== 'Divisa' && metodo !== 'Efectivo USD') {
        pagoReal = monto / TASA_CAMBIO;
    }

    // VALIDACION: No pagar más de lo que se debe
    // Usamos un pequeño margen de error para comparaciones de punto flotante
    if (pagoReal - restanteUsdGlobal > 0.01) {
        Swal.fire({
            title: 'Monto excedido!',
            text: `El monto ingresado excede la deuda pendiente.\nDeuda actual: $${restanteUsdGlobal.toFixed(2)}\nIntenta pagar: $${pagoReal.toFixed(2)}`,
            icon: 'error',
            background: '#252525',
            color: '#fff'
        });
        return;
    }

    try {
        const response = await fetch(RUTA_BASE + 'Ventas/agregarPago', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id_factura: idFacturaPago,
                metodo: metodo,
                monto: pagoReal,
                tasa: TASA_CAMBIO,
                monto_exacto: monto // El valor crudo del input
            })
        });

        const data = await response.json();
        if (data.status) {
            Swal.fire({
                title: 'Éxito!',
                text: 'Pago registrado correctamente',
                icon: 'success',
                background: '#252525',
                color: '#fff'
            });
            location.reload();
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Error: ' + data.message,
                icon: 'error',
                background: '#252525',
                color: '#fff'
            });
        }
    } catch (error) {
        console.error(error);
        Swal.fire({
            title: 'Pago invalido!',
            text: 'Error al registrar el pago',
            icon: 'error',
            background: '#252525',
            color: '#fff'
        });
    }
}

async function registrarVenta() {
    if (carrito.length === 0) {
        Swal.fire({
            title: 'Carrito vacío!',
            text: 'El carrito está vacío, agregue tortas al carrito',
            icon: 'error',
            background: '#252525',
            color: '#fff'
        });
        return;
    }

    if (!clienteSeleccionadoId) {
        Swal.fire({
            title: 'Cliente no seleccionado!',
            text: 'Debe seleccionar un cliente',
            icon: 'error',
            background: '#252525',
            color: '#fff'
        });
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

    // 4. Generar y Agregar Código Factura
    const today = new Date();
    const yyyy = today.getFullYear();
    const yy = String(yyyy).slice(-2);
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const randomStr = Math.random().toString(36).substring(2, 7).toUpperCase();
    const codigoFactura = `VEN-${dd}${mm}${yy}-${randomStr}`;

    document.getElementById('inputCodigoFactura').value = codigoFactura;

    // 5. Submit Form
    Swal.fire({
        title: 'Procesando venta...',
        text: 'Por favor espere mientras se registra la venta',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        background: '#252525',
        color: '#fff',
        didOpen: () => {
            Swal.showLoading();
        }
    });
    form.submit();
}

window.copiarMontoPago = function (textoMonto, moneda) {
    // Si el texto es "Error" o "...", ignorar
    if (!textoMonto || isNaN(parseFloat(textoMonto))) return;

    const monto = parseFloat(textoMonto);
    document.getElementById('pagoMonto').value = monto.toFixed(2);

};


