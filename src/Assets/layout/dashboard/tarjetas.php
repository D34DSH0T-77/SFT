<h2 class="mb-4">Resumen General</h2>
<div class="row g-4">
    <div class="col-md-3">
        <a href="<?= RUTA_BASE . 'inventario' ?>">
            <div class="stats-card">
                <div class="stats-info">
                    <h3><?= $totalTortas ?? 0 ?></h3>
                    <p>Stock (Tortas)</p>
                </div>
                <div class="stats-icon bg-pastel-pink">
                    <span class="material-symbols-sharp">shopping_bag</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="<?= RUTA_BASE . 'clientes' ?>">
            <div class="stats-card">
                <div class="stats-info">
                    <h3><?= number_format($totalClientes) ?? 0 ?></h3>
                    <p>Clientes</p>
                </div>
                <div class="stats-icon bg-pastel-lavender">
                    <span class="material-symbols-sharp">group</span>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-info">
                <h3>12</h3>
                <p>Pagos Pendientes</p>
            </div>
            <div class="stats-icon bg-pastel-peach">
                <span class="material-symbols-sharp">warning</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-info">
                <h3>$120</h3>
                <p>Ganancias (BCV)</p>
            </div>
            <div class="stats-icon bg-pastel-mint">
                <span class="material-symbols-sharp">payments</span>
            </div>
        </div>
    </div>
</div>