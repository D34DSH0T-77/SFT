/**
 * Ventas Manager Class
 * Handles the interactive logic for the Point of Sale (POS) system.
 */
class VentasManager {
    constructor() {
        this.cart = [];
        this.payments = [];
        this.exchangeRate = 221.00; // Default rate

        // Selected product to be added
        this.selectedProduct = null;

        // DOM Elements
        this.elements = {
            tortaSearch: document.getElementById('tortaSearch'),
            searchResults: document.getElementById('searchResults'),
            clienteSelect: document.getElementById('clienteSelect'),
            tableBody: document.querySelector('.product-table tbody'),
            paymentSelect: document.querySelector('select.form-select.form-control-custom'),
            paymentInput: document.querySelector('input[placeholder="Monto"]'),
            btnAddPayment: document.querySelector('.btn-add-payment'), // New class added
            btnRegister: document.querySelector('.btn-register'),
            btnAddCart: document.querySelector('.btn-add-cart'),
            btnClear: document.querySelector('.btn-clear-cart'),

            // Totals - Using classes added in previous step for robustness
            subtotalUsd: document.querySelector('.subtotal-usd') || document.querySelectorAll('.card-body-custom .row .fw-bold.fs-5')[0],
            subtotalBs: document.querySelector('.subtotal-bs') || document.querySelectorAll('.card-body-custom .row .fw-bold.fs-5')[1],
            totalUsd: document.querySelector('.total-usd') || document.querySelectorAll('.total-box .fw-bold.fs-4')[0],
            totalBs: document.querySelector('.total-bs') || document.querySelectorAll('.total-box .fw-bold.fs-4')[1],
            paidUsd: document.querySelector('.paid-usd') || document.querySelectorAll('.text-success')[0],
            paidBs: document.querySelector('.paid-bs') || document.querySelectorAll('.text-success')[1],
        };

        this.init();
    }

    init() {
        console.log("VentasManager initialized");

        // Event Delegation for static and dynamic elements
        document.body.addEventListener('click', (e) => {
            if (e.target.matches('.btn-add-cart')) this.addProduct();
            if (e.target.matches('.btn-clear-cart')) this.clearCart();
            if (e.target.matches('.btn-add-payment')) this.addPayment();
            if (e.target.matches('.btn-register')) this.registerSale();

            // Search Input clicks or focus handling could go here

            // Close search results if clicking outside
            if (this.elements.tortaSearch && !this.elements.tortaSearch.contains(e.target) && this.elements.searchResults && !this.elements.searchResults.contains(e.target)) {
                if (this.elements.searchResults) this.elements.searchResults.style.display = 'none';
            }
        });

        // Specific listener for the search input using delegation equivalent
        document.addEventListener('input', (e) => {
            if (e.target.id === 'tortaSearch') {
                this.handleSearch(e);
            }
            if (e.target.classList.contains('quantity-input')) {
                this.handleRowInput(e);
            }
        });

        // Initialize listener for row actions (delegation) - kept existing click delegation
        this.elements.tableBody.addEventListener('click', (e) => this.handleRowAction(e));
        // Input listener is now global above
    }

    /**
     * Debounced search handler
     */
    handleSearch(e) {
        const term = e.target.value.trim();
        clearTimeout(this.searchTimeout);

        if (term.length < 2) {
            this.elements.searchResults.style.display = 'none';
            this.selectedProduct = null;
            return;
        }

        // Show loading state immediately
        this.elements.searchResults.innerHTML = '<div class="list-group-item text-muted">Buscando...</div>';
        this.elements.searchResults.style.display = 'block';

        this.searchTimeout = setTimeout(() => {
            this.fetchProducts(term);
        }, 300);
    }

    async fetchProducts(term) {
        try {
            console.log("Searching for:", term);

            let url = 'ventas/buscarTortas';
            if (typeof BASE_URL !== 'undefined') {
                url = BASE_URL + url;
            } else {
                console.warn("BASE_URL is not defined, using relative path");
            }

            const response = await fetch(`${url}?q=${encodeURIComponent(term)}`);

            if (!response.ok) {
                const text = await response.text();
                throw new Error(`Network response was not ok: ${response.status} - ${text}`);
            }

            const products = await response.json();
            console.log("Products found:", products);

            this.renderSearchResults(products);
        } catch (error) {
            console.error("Error searching:", error);
            // Show error in the dropdown for feedback
            this.elements.searchResults.innerHTML = `<div class="list-group-item text-danger">Error: ${error.message}</div>`;
            this.elements.searchResults.style.display = 'block';
        }
    }

    renderSearchResults(products) {
        const container = this.elements.searchResults;
        container.innerHTML = '';

        if (products.length === 0) {
            container.innerHTML = '<div class="list-group-item text-dark">No se encontraron productos</div>';
            container.style.display = 'block';
            return;
        }

        products.forEach(p => {
            const item = document.createElement('a');
            item.href = '#';
            item.className = 'list-group-item list-group-item-action';
            item.innerHTML = `
                <div class="d-flex w-100 justify-content-between align-items-center">
                   <div>
                        <h6 class="mb-1 text-body">${p.nombre}</h6>
                        <small class="text-muted">Stock: ${p.stock !== undefined ? p.stock : '?'}</small>
                   </div>
                   <small class="fw-bold text-primary">$${p.precio}</small>
                </div>
            `;
            item.addEventListener('click', (e) => {
                e.preventDefault();
                this.selectProduct(p);
            });
            container.appendChild(item);
        });

        container.style.display = 'block';
    }

    selectProduct(product) {
        // 1. Asignamos el producto seleccionado
        this.selectedProduct = product;

        // 2. Limpiamos visualmente el buscador y ocultamos la lista
        this.elements.tortaSearch.value = '';
        this.elements.searchResults.style.display = 'none';

        // 3. ¡Aquí está el truco! Llamamos a agregar producto automáticamente
        this.addProduct();

        // 4. Devolvemos el foco al input para seguir buscando rápido
        this.elements.tortaSearch.focus();
    }

    /**
     * Adds the selected product to cart
     */
    addProduct() {
        if (!this.selectedProduct) {
            alert("Busque y seleccione una torta primero");
            return;
        }

        const product = {
            id: this.selectedProduct.id,
            name: this.selectedProduct.nombre,
            price: parseFloat(this.selectedProduct.precio),
            img: this.selectedProduct.img || '',
            quantity: 1
        };

        // Check if product already exists
        const existingIndex = this.cart.findIndex(p => p.id === product.id);

        if (existingIndex >= 0) {
            this.cart[existingIndex].quantity++;
        } else {
            this.cart.push(product);
        }

        this.renderTable();

        // Clear selection
        this.elements.tortaSearch.value = '';
        this.selectedProduct = null;
    }

    clearCart() {
        if (confirm('¿Estás seguro de vaciar la lista de ventas?')) {
            this.cart = [];
            this.renderTable();
        }
    }

    /**
     * Renders the product table based on current cart
     */
    renderTable() {
        this.elements.tableBody.innerHTML = '';

        this.cart.forEach((item, index) => {
            const row = document.createElement('tr');
            const totalItemUsd = (item.price * item.quantity).toFixed(2);
            const totalItemBs = (totalItemUsd * this.exchangeRate).toFixed(2);
            const hasImage = item.img && item.img.trim() !== '';

            // Fix path logic
            let imgPath = '';
            if (hasImage) {
                // If img starts with http, use it as is (external/absolute)
                if (item.img.startsWith('http')) {
                    imgPath = item.img;
                } else {
                    // Otherwise assume relative to public/img/ in BASE_URL
                    imgPath = (typeof BASE_URL !== 'undefined' ? BASE_URL : '') + 'public/img/' + item.img;
                }
            }

            const defaultImgPath = typeof BASE_URL !== 'undefined' ? BASE_URL + 'src/Assets/img/icono.ico' : 'src/Assets/img/icono.ico';

            row.innerHTML = `
                <td>
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                             ${hasImage ?
                    `<img src="${imgPath}" alt="${item.name}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;" onerror="this.onerror=null;this.src='${defaultImgPath}';">` :
                    `<img src="${defaultImgPath}" alt="Default" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">`
                }
                        </div>
                        <div>
                            <div class="fw-bold">${item.name}</div>
                            <small class="text-muted">ID: ${item.id}</small> 
                        </div>
                    </div>
                </td>
                <td>
                    <input type="number" class="form-control form-control-sm text-center quantity-input" 
                           value="${item.quantity}" min="1" data-id="${item.id}">
                </td>
                <td class="text-end">
                    <div>${totalItemUsd} USD</div>
                    <small class="text-muted">${totalItemBs} BS</small>
                </td>
                <td>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${item.id}">
                        <i class="material-symbols-sharp" style="font-size: 16px;">delete</i>
                    </button>
                </td>
            `;
            this.elements.tableBody.appendChild(row);
        });

        this.updateTotals();
    }

    handleRowInput(e) {
        if (e.target.classList.contains('quantity-input')) {
            const id = e.target.dataset.id;
            const newQty = parseInt(e.target.value);

            const item = this.cart.find(p => p.id === id);
            if (item && newQty > 0) {
                item.quantity = newQty;
                this.updateTotals();
                this.refreshRowPrice(e.target.closest('tr'), item);
            }
        }
    }

    refreshRowPrice(row, item) {
        const totalItemUsd = (item.price * item.quantity).toFixed(2);
        const totalItemBs = (totalItemUsd * this.exchangeRate).toFixed(2);
        const priceCell = row.querySelector('td.text-end');
        if (priceCell) {
            priceCell.innerHTML = `<div>${totalItemUsd} USD</div><small class="text-muted">${totalItemBs} BS</small>`;
        }
    }

    handleRowAction(e) {
        if (e.target.closest('.delete-btn')) {
            const btn = e.target.closest('.delete-btn');
            const id = btn.dataset.id;
            // Use loose comparison (!=) or convert types because dataset.id is always string
            this.cart = this.cart.filter(p => p.id != id);
            this.renderTable();
        }
    }

    updateTotals() {
        const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const total = subtotal;

        const totalBs = total * this.exchangeRate;

        if (this.elements.subtotalUsd) this.elements.subtotalUsd.textContent = subtotal.toFixed(2);
        if (this.elements.subtotalBs) this.elements.subtotalBs.textContent = (subtotal * this.exchangeRate).toFixed(2);

        if (this.elements.totalUsd) this.elements.totalUsd.textContent = total.toFixed(2);
        if (this.elements.totalBs) this.elements.totalBs.textContent = totalBs.toFixed(2);
    }

    addPayment() {
        const method = this.elements.paymentSelect.value;
        const amount = parseFloat(this.elements.paymentInput.value);

        if (!amount || amount <= 0) {
            alert("Ingrese un monto válido");
            return;
        }

        this.payments.push({ method, amount });

        const totalPaid = this.payments.reduce((sum, p) => sum + p.amount, 0);

        this.elements.paidBs.textContent = totalPaid.toFixed(2);
        this.elements.paidUsd.textContent = (totalPaid / this.exchangeRate).toFixed(2);

        this.elements.paymentInput.value = '';
    }

    async registerSale() {
        if (this.cart.length === 0) {
            alert("No hay productos en la venta");
            return;
        }

        const clientId = this.elements.clienteSelect.value;
        if (!clientId) {
            alert("Seleccione un cliente");
            return;
        }

        const totalUsd = parseFloat(this.elements.totalUsd.textContent);
        const date = new Date().toISOString().slice(0, 19).replace('T', ' ');

        // 1. Create Factura
        const facturaData = new FormData();
        facturaData.append('id_cliente', clientId);
        facturaData.append('total', totalUsd);
        facturaData.append('fecha', date);
        // Status is 'En proceso' to allow subsequent payments (abonos)
        facturaData.append('estado', 'En proceso');

        try {
            const responseFactura = await this.sendRequest('ventas/agregar', facturaData);
            const dataFactura = await responseFactura.json();

            if (!dataFactura.success || !dataFactura.id) {
                throw new Error("Error al crear la factura: " + (dataFactura.message || "desconocido"));
            }

            const facturaId = dataFactura.id;

            for (const item of this.cart) {
                // Add Detail
                const detailData = new FormData();
                detailData.append('id_factura', facturaId);
                detailData.append('id_torta', item.id);
                detailData.append('cantidad', item.quantity);
                detailData.append('precio', item.price);

                await this.sendRequest('ventas/agregarDetalle', detailData);

                // Decrement Inventory
                const inventoryData = new FormData();
                inventoryData.append('id', item.id);
                inventoryData.append('cantidad', item.quantity);

                await this.sendRequest('ventas/restarLote', inventoryData);
            }

            alert("Venta registrada con éxito!");
            window.location.reload();

        } catch (error) {
            console.error(error);
            alert("Error al registrar la venta: " + error.message);
        }
    }

    async sendRequest(url, formData) {
        const fullUrl = (typeof BASE_URL !== 'undefined') ? BASE_URL + url : url;
        const response = await fetch(fullUrl, {
            method: 'POST',
            body: formData
        });
        return response;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new VentasManager();
});