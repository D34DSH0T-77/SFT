<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= RUTA_BASE ?>src/Assets/css/style.css">
    <link rel="stylesheet" href="<?= RUTA_BASE ?>src/Assets/css/login.css">
    <link rel="shortcut icon" href="<?= RUTA_BASE ?>src/Assets/img/icono.ico" type="image/x-icon">
</head>

<body>

    <div class="login-card">
        <h2 class="login-title">Nombre del sistem :v</h2>
        <p class="text-center text-muted mb-4">Inicia sesión para continuar</p>

        <?php require('src/Assets/layout/notificaciones.php') ?>

        <form action="<?= RUTA_BASE ?>Login/loguear" method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required autofocus>
            </div>
            <div class="mb-4">
                <label for="cedula" class="form-label">Cedula</label>
                <input type="text" class="form-control" id="cedula" name="cedula" required>
            </div>
            <button type="submit" class="btn btn-login btn-lg rounded-pill">INGRESAR</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>