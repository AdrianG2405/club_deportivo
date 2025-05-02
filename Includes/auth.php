<?php
// Iniciar sesión si no ha sido iniciada aún
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {
    // Si no está logueado, redirigir al login
    header("Location: login.php");
    exit;
}

// Opcional: Verificar si el usuario tiene el rol adecuado (por ejemplo, "entrenador")
if ($_SESSION['usuario']['rol'] !== 'entrenador') {
    // Si el usuario no tiene el rol adecuado, redirigirlo a la página principal o a otro lugar
    header("Location: index.php");
    exit;
}
?>
