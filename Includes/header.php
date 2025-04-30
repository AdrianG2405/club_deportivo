<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Club Deportivo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Tu CSS personalizado -->
    <link rel="stylesheet" href="/club_deportivo/css/estilos.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/club_deportivo/index.php">Club Deportivo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        
        <!-- Menú Desplegable -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Menú
          </a>
          <ul class="dropdown-menu" aria-labelledby="menuDropdown">
            <li><a class="dropdown-item" href="/club_deportivo/administrar/entrenador.php">Entrenador</a></li>
            <li><a class="dropdown-item" href="/club_deportivo/administrar/padre.php">Padre</a></li>
            <li><a class="dropdown-item" href="/club_deportivo/administrar/registro_jugador.php">Registro Jugadores</a></li>
            <li><a class="dropdown-item" href="/club_deportivo/includes/login.php">Login</a></li>
            <li><a class="dropdown-item" href="/club_deportivo/administrar/convocatorias.php">Convocatorias</a></li>
            <li><a class="dropdown-item" href="/club_deportivo/administrar/calendario.php">Calendario</a></li>
            <li><a class="dropdown-item" href="/club_deportivo/administrar/equipos.php">Equipos</a></li>
            <li><a class="dropdown-item" href="/club_deportivo/administrar/jugadores.php">Jugadores</a></li>
          </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>
