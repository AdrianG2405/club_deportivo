<?php session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/escuela-futbol/index.php">Escuela Fútbol</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <?php if ($_SESSION['usuario']['rol'] === 'administrador'): ?>
                        <li class="nav-item"><a class="nav-link" href="/escuela-futbol/pages/admin.php">Administrador</a></li>
                    <?php elseif ($_SESSION['usuario']['rol'] === 'entrenador'): ?>
                        <li class="nav-item"><a class="nav-link" href="/escuela-futbol/pages/entrenador.php">Entrenador</a></li>
                    <?php elseif ($_SESSION['usuario']['rol'] === 'padre'): ?>
                        <li class="nav-item"><a class="nav-link" href="/escuela-futbol/pages/padre.php">Padre</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="/escuela-futbol/logout.php">Cerrar sesión</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="/escuela-futbol/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
