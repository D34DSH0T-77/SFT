<?php require('src/Assets/layout/head.php') ?>

<body>
    <?php require('src/Assets/layout/sidebar.php') ?>

    <div class="main-content">
        <?php require('src/Assets/layout/navbar.php') ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-light mb-4">Ver Entrada</h2>
                    <div class="card" style="background-color: var(--bg-card); color: var(--text-main);">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label text-muted">Código</label>
                                    <p class="form-control-plaintext text-white fs-5"><?= $entrada->codigo ?></p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted">Fecha</label>
                                    <p class="form-control-plaintext text-white fs-5"><?= date('d/m/Y', strtotime($entrada->fecha)) ?></p>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label text-muted">Local</label>
                                    <p class="form-control-plaintext text-white fs-5"><?= $entrada->local ?></p>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Total (Bs)</label>
                                    <p class="form-control-plaintext text-white fs-4 fw-bold"><?= number_format($entrada->precio_bs, 2) ?> Bs</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Total ($)</label>
                                    <p class="form-control-plaintext text-white fs-4 fw-bold">$ <?= number_format($entrada->precio_usd, 2) ?></p>
                                </div>
                            </div>

                            <hr>
                            <h4 class="text-light mb-3">Detalles de Tortas</h4>

                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>Torta</th>
                                            <th class="text-center" style="width: 15%;">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($detalles) && !empty($detalles)): ?>
                                            <?php foreach ($detalles as $detalle): ?>
                                                <tr>
                                                    <td><?= $detalle->nombre_torta ?></td>
                                                    <td class="text-center"><?= $detalle->cantidad ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="2" class="text-center text-muted">No hay detalles registrados.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 d-flex justify-content-end">
                                <a href="<?= RUTA_BASE ?>entradas" class="btn btn-secondary">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('src/Assets/layout/script-footer.php') ?>
</body>

</html>