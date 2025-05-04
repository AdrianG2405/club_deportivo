<?php
// Iniciar sesión si no ha sido iniciada aún
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) {

    header("Location: login.php");
    exit;
}


if ($_SESSION['usuario']['rol'] !== 'entrenador') {
    header("Location: index.php");
    exit;
}
?>
