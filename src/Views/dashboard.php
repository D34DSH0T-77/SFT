<?php require('src/Assets/layout/head.php') ?>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">SweetCakes</a>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="#" class="sidebar-link active">
                    <span class="material-symbols-sharp">dashboard</span>
                    <span class="link-text">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <span class="material-symbols-sharp">cake</span>
                    <span class="link-text">Tortas</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <span class="material-symbols-sharp">shopping_cart</span>
                    <span class="link-text">Ventas</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <span class="material-symbols-sharp">inventory_2</span>
                    <span class="link-text">Inventario</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <span class="material-symbols-sharp">group</span>
                    <span class="link-text">Clientes</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="#" class="sidebar-link">
                    <span class="material-symbols-sharp">settings</span>
                    <span class="link-text">Configuración</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <button class="toggle-btn">
                <span class="material-symbols-sharp">menu</span>
            </button>
            <div class="user-profile d-flex align-items-center">
                <span class="me-2">Admin User</span>
                <div class="rounded-circle bg-secondary" style="width: 35px; height: 35px;"></div>
            </div>
        </nav>

        <!-- Dashboard Widgets -->
        <div class="container-fluid">
            <h2 class="mb-4">Resumen General</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>150</h3>
                            <p>Ventas Hoy</p>
                        </div>
                        <div class="stats-icon bg-pastel-pink">
                            <span class="material-symbols-sharp">shopping_bag</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>$1,250</h3>
                            <p>Ingresos</p>
                        </div>
                        <div class="stats-icon bg-pastel-mint">
                            <span class="material-symbols-sharp">payments</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>45</h3>
                            <p>Pedidos Activos</p>
                        </div>
                        <div class="stats-icon bg-pastel-lavender">
                            <span class="material-symbols-sharp">local_shipping</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-info">
                            <h3>12</h3>
                            <p>Alertas Stock</p>
                        </div>
                        <div class="stats-icon bg-pastel-peach">
                            <span class="material-symbols-sharp">warning</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Table -->
            <div class="table-container">
                <h4 class="mb-3">Pedidos Recientes</h4>
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>ID Pedido</th>
                                <th>Cliente</th>
                                <th>Producto</th>
                                <th>Estado</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#10234</td>
                                <td>Maria Garcia</td>
                                <td>Torta de Chocolate</td>
                                <td><span class="status-badge status-completed">Entregado</span></td>
                                <td>$45.00</td>
                            </tr>
                            <tr>
                                <td>#10235</td>
                                <td>Juan Perez</td>
                                <td>Cheesecake Fresa</td>
                                <td><span class="status-badge status-pending">Pendiente</span></td>
                                <td>$35.00</td>
                            </tr>
                            <tr>
                                <td>#10236</td>
                                <td>Ana Lopez</td>
                                <td>Red Velvet</td>
                                <td><span class="status-badge status-pending">En Proceso</span></td>
                                <td>$50.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>