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
            <a class="navbar-brand" href="index.php">Club Deportivo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <!-- Enlace a la página de inicio -->
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Inicio</a>
                    </li>
                    <!-- Enlace a la página de entrenadores -->
                    <li class="nav-item">
                        <a class="nav-link" href="administrar/entrenadores.php">Entrenadores</a>
                    </li>
                    <!-- Enlace a la página de padres -->
                    <li class="nav-item">
                        <a class="nav-link" href="administrar/padres.php">Padres</a>
                    </li>
                    <!-- Enlace a la página de calendario -->
                    <li class="nav-item">
                        <a class="nav-link" href="administrar/calendario.php">Calendario</a>
                    </li>
                    <!-- Enlace a la página de login -->
                    <li class="nav-item">
                        <a class="nav-link" href="includes/login.php">Login</a>
                    </li>
                    <!-- Enlace a la página de registro de jugadores -->
                    <li class="nav-item">
                        <a class="nav-link" href="administrar/registro_jugadores.php">Registro Jugadores</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Agregar el script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
