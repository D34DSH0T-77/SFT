<div class="row g-4">
    <!-- 1. Clientes -->
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

    <!-- 2. Stock -->
    <div class="col-md-3">
        <a href="<?= RUTA_BASE . 'inventario' ?>">
            <div class="stats-card">
                <div class="stats-info">
                    <h3><?= $totalTortas ?? 0 ?></h3>
                    <p>Stock</p>
                </div>
                <div class="stats-icon bg-pastel-pink">
                    <span class="material-symbols-sharp">shopping_bag</span>
                </div>
            </div>
        </a>
    </div>

    <!-- 3. Pagos Pendientes -->
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-info">
                <h3>12</h3>
                <p>Pagos pendientes </p>
            </div>
            <div class="stats-icon bg-pastel-peach">
                <span class="material-symbols-sharp">warning</span>
            </div>
        </div>
    </div>

    <!-- 4. Ganancia -->
    <div class="col-md-3">
        <div class="stats-card">
            <div class="stats-info">
                <h3>$<?= number_format($gananciaTotalUsd ?? 0, 2) ?></h3>
                <p>Ganancia (USD)</p>
            </div>
            <div class="stats-icon bg-pastel-mint">
                <span class="material-symbols-sharp">payments</span>
            </div>
        </div>
    </div>
</div>