<?php
//conexión a la base de datos
$host = 'localhost'; 
$dbname = 'club_deportivo'; 
$username = 'root';
$password = ''; 

try {
    // Crear una nueva conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES 'utf8'");

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit; 
}
?>
