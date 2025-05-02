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

<!-- NAVBAR CON TODOS LOS ENLACES VISIBLES -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/club_deportivo/index.php">Club Deportivo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/administrar/entrenador.php">Entrenador</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/administrar/asignar_jugadores.php">Asignar Jugador</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/administrar/estado_jugador.php">Estado Jugador</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/administrar/pagos.php">Pagos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/administrar/padre.php">Padre</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/administrar/registro_jugador.php">Registro Jugadores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/includes/login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/administrar/gestionar_convocatoria.php">Convocatoria Entrenador</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/administrar/convocar.php">Convocatoria Jugador</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/administrar/calendario.php">Calendario</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/administrar/equipos.php">Equipos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/club_deportivo/administrar/jugadores.php">Jugadores</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Scripts Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
