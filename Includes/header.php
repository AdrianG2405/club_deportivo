<?php
// Inicia la sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Rol del usuario, puede ser 'entrenador', 'padre' o null
$rol = $_SESSION['usuario']['rol'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Deportivo</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/club_deportivo/index.php">Club Deportivo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <!-- Enlace común -->
                <li class="nav-item">
                    <a class="nav-link" href="/club_deportivo/index.php">Inicio</a>
                </li>

                <!-- Menú para entrenadores -->
                <?php if ($rol === 'entrenador'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/club_deportivo/administrar/asistencia.php">Asistencia</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/club_deportivo/administrar/registro_jugador.php">Jugador</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/club_deportivo/administrar/entrenador.php">Entrenador</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/club_deportivo/administrar/pagos.php">Pagos</a>
                    </li>
                <?php endif; ?>

                <!-- Menú para padres -->
                <?php if ($rol === 'padre'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/club_deportivo/partidos.php">Partidos</a>
                    </li>
                <?php endif; ?>

                <!-- Autenticación -->
                <?php if (!$rol): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/club_deportivo/includes/login.php">Login</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/club_deportivo/includes/logout.php">Cerrar sesión</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenedor principal -->
<div class="container mt-4">
