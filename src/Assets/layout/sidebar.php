<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <a class="sidebar-brand">BajoCeroPostres</a>
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
            <a href="<?= RUTA_BASE ?>devoluciones" class="sidebar-link <?= $moduloActivo === 'devoluciones' ? 'active' : '' ?>">
                <span class="material-symbols-sharp">auto_delete</span>
                <span class="link-text">Devoluciones</span>
            </a>
        </li>

        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'Admin'): ?>
            <li class="sidebar-item">
                <a href="<?= RUTA_BASE ?>capital" class="sidebar-link <?= $moduloActivo === 'capital' ? 'active' : '' ?>">
                    <span class="material-symbols-sharp">account_balance</span>
                    <span class="link-text">Capital</span>
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
            <li class="sidebar-item">
                <a href="#submenuReportes" data-bs-toggle="collapse" class="sidebar-link d-flex align-items-center justify-content-between <?= (strpos($moduloActivo ?? '', 'reportes') === 0) ? 'active' : '' ?>" role="button" aria-expanded="<?= (strpos($moduloActivo ?? '', 'reportes') === 0) ? 'true' : 'false' ?>" aria-controls="submenuReportes">
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-sharp">bar_chart</span>
                        <span class="link-text">Reportes</span>
                    </div>
                    <span class="material-symbols-sharp link-text" style="font-size: 1.2rem;">expand_more</span>
                </a>
                <ul class="collapse sidebar-submenu list-unstyled ps-3 <?= (strpos($moduloActivo ?? '', 'reportes') === 0) ? 'show' : '' ?>" id="submenuReportes">
                    <li>
                        <a href="<?= RUTA_BASE ?>reportes/entradas" class="sidebar-link <?= ($moduloActivo ?? '') === 'reportes/entradas' ? 'active' : '' ?>">
                            <span class="material-symbols-sharp" style="font-size: 1.2rem;">post_add</span>
                            <span class="link-text" style="font-size: 0.95rem;">Entradas</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= RUTA_BASE ?>reportes/ventas" class="sidebar-link <?= ($moduloActivo ?? '') === 'reportes/ventas' ? 'active' : '' ?>">
                            <span class="material-symbols-sharp" style="font-size: 1.2rem;">shopping_cart</span>
                            <span class="link-text" style="font-size: 0.95rem;">Ventas</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= RUTA_BASE ?>reportes/inventario" class="sidebar-link <?= ($moduloActivo ?? '') === 'reportes/inventario' ? 'active' : '' ?>">
                            <span class="material-symbols-sharp" style="font-size: 1.2rem;">inventory_2</span>
                            <span class="link-text" style="font-size: 0.95rem;">Inventario</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= RUTA_BASE ?>reportes/clientes" class="sidebar-link <?= ($moduloActivo ?? '') === 'reportes/clientes' ? 'active' : '' ?>">
                            <span class="material-symbols-sharp" style="font-size: 1.2rem;">group</span>
                            <span class="link-text" style="font-size: 0.95rem;">Clientes</span>
                        </a>
                    </li>

                </ul>
            </li>
        <?php endif; ?>
    </ul>
</div>