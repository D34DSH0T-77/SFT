<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">SweetCakes</a>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="<?= RUTA_BASE ?>dashboard" class="sidebar-link <?= $moduloActivo === 'dashboard' ? 'active' : '' ?>">
                <span class="material-symbols-sharp">dashboard</span>
                <span class="link-text">Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= RUTA_BASE ?>tortas" class="sidebar-link <?= $moduloActivo === 'tortas' ? 'active' : '' ?>">
                <span class="material-symbols-sharp">cake</span>
                <span class="link-text">Tortas</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= RUTA_BASE ?>entradas" class="sidebar-link <?= $moduloActivo === 'entradas' ? 'active' : '' ?>">
                <span class="material-symbols-sharp">post_add</span>
                <span class="link-text">Entradas</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= RUTA_BASE ?>inventario" class="sidebar-link <?= $moduloActivo === 'inventario' ? 'active' : '' ?>">
                <span class="material-symbols-sharp">inventory_2</span>
                <span class="link-text">Inventario</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= RUTA_BASE ?>ventas" class="sidebar-link <?= $moduloActivo === 'ventas' ? 'active' : '' ?>">
                <span class="material-symbols-sharp">shopping_cart</span>
                <span class="link-text">Ventas</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= RUTA_BASE ?>clientes" class="sidebar-link <?= $moduloActivo === 'clientes' ? 'active' : '' ?>">
                <span class="material-symbols-sharp">group</span>
                <span class="link-text">Clientes</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="<?= RUTA_BASE ?>usuarios" class="sidebar-link <?= $moduloActivo === 'usuarios' ? 'active' : '' ?>">
                <span class="material-symbols-sharp">how_to_reg</span>
                <span class="link-text">Usuarios</span>
            </a>
        </li>
    </ul>
</div>