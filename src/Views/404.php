<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= RUTA_BASE ?>src/Assets/css/404.css">
    <title>Error 404</title>

</head>

<body>

    <div class="conten">
        <div class="conten__img">
            <img src="<?= RUTA_BASE ?>src/Assets/img/404.png" alt="">
            <p class="conten__number">
                404
            </p>
        </div>
        <div class="conten__Description">
            <p class="conten__error">
                UPSSSS!!!! <?= $error ?>
            </p>
            <a href="<?= RUTA_BASE ?>" class="conten__button">SACAME DE AQUI!.</a>
        </div>
    </div>

</body>

</html>