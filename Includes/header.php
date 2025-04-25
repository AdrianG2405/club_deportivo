<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Deportivo</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Club Deportivo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Enlace a la página de inicio -->
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Inicio</a>
                    </li>
                    <!-- Enlace a la página de administradores -->
                    <li class="nav-item">
                        <a class="nav-link" href="../administrar/asistencia.php">Asistencia</a>
                    </li>
                    <!-- Enlace al logout -->
                    <li class="nav-item">
                        <a class="nav-link" href="../includes/login.php">Login</a>
                    </li>
                    <!-- Aquí deberías agregar más páginas según sea necesario -->
                    <!-- Por ejemplo -->
                    <li class="nav-item">
                        <a class="nav-link" href="../administrar/registro_jugador.php">Jugador</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../administrar/entrenador.php">Entrenador</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="partidos.php">Partidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../administrar/pagos.php">Pagos</a>
                    </li>
                    <!-- Otros enlaces adicionales si es necesario -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido de la página -->
    <div class="container mt-4">
        <!-- Aquí puedes añadir el contenido específico para cada página -->
