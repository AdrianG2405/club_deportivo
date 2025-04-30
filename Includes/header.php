<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Club Deportivo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="/club_deportivo/css/estilos.css">
</head>
<body>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="/club_deportivo/index.php">🏅 Club Deportivo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/club_deportivo/index.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="/club_deportivo/administrar/entrenador.php">Entrenadores</a></li>
                <li class="nav-item"><a class="nav-link" href="/club_deportivo/administrar/padre.php">Padres</a></li>
                <li class="nav-item"><a class="nav-link" href="/club_deportivo/administrar/calendario.php">Calendario</a></li>
                <li class="nav-item"><a class="nav-link" href="/club_deportivo/administrar/registro_jugador.php">Registro Jugadores</a></li>
                <li class="nav-item"><a class="nav-link" href="/club_deportivo/includes/login.php">Login</a></li>
            </ul>
        </div>
    </div>
</nav>
