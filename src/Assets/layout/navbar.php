<!-- Top Navbar -->
<nav class="top-navbar">
    <button class="toggle-btn">
        <span class="material-symbols-sharp">menu</span>
    </button>

    <div class="user-profile d-flex align-items-center dropdown">

        <div class="d-flex align-items-center gap-2 me-5">
            <span>Tasa del dia:</span>
            <span id="tasaDia"></span>
        </div>

        <span class="me-2"><?= $_SESSION['usuario'] ?></span>

        <button class="btn btn-link p-0 border-0 text-decoration-none" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?= RUTA_BASE ?>src/Assets/img/login/perfil.png" style="width: 35px; height: 35px;" class="rounded-circle" alt="Perfil">
        </button>

        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <h6 class="dropdown-header">Hola, <?= $_SESSION['usuario'] ?></h6>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item text-danger" href="<?= RUTA_BASE ?>Login/logout">Cerrar Sesión</a></li>
        </ul>

    </div>
</nav>