<?php
// Configuración de la conexión a la base de datos
$host = 'localhost'; // O puede ser tu servidor de base de datos si no estás trabajando localmente
$dbname = 'club_deportivo'; // Nombre de tu base de datos
$username = 'root'; // Nombre de usuario de tu base de datos
$password = ''; // Contraseña de tu base de datos (en local generalmente es vacía)

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Establecer el modo de error de PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Establecer el juego de caracteres
    $pdo->exec("SET NAMES 'utf8'");

} catch (PDOException $e) {
    // Si ocurre un error, lo mostramos
    echo "Error de conexión: " . $e->getMessage();
    exit; // Detenemos la ejecución si no podemos conectarnos a la base de datos
}
?>
