<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php"); // Si no está logueado, redirige a login
    exit;
}

// Verificar si el usuario es un padre
if ($_SESSION['usuario']['rol'] === 'padre') {
    // Si el rol es "padre", redirige a la página de error
    header("Location: error.php");
    exit;
}

// Si el rol es "entrenador", dejar continuar con la página
include '../includes/header.php';  // Incluir el encabezado del sitio
require '../includes/db.php';      // Conexión a la base de datos

// Tu código para la página de jugadores...
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jugadores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Página de Jugadores</h2>
        <!-- Aquí va el contenido de la página de jugadores -->
    </div>
</body>
</html>
<?php include '../includes/footer.php'; ?>
