<?php
session_start();

// Verificar si el usuario está autenticado y tiene el rol de 'entrenador'
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'entrenador') {
    header("Location: ../include/login.php");
    exit;
}

include '../include/header.php';  // Corregido
include '../include/menu.php';    // Corregido
require '../include/db.php';      // Corregido

// Crear tabla si no existe
$pdo->exec("CREATE TABLE IF NOT EXISTS estado_jugador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jugador_id INT,
    tipo ENUM('lesión', 'sanción'),
    descripcion TEXT,
    fecha_inicio DATE,
    fecha_fin DATE,
    FOREIGN KEY (jugador_id) REFERENCES jugadores(id)
)");

// Definir la categoría de jugadores a mostrar
$categoria = "Alevín"; // Puedes hacerlo dinámico si lo deseas
$jugadores = $pdo->prepare("SELECT * FROM jugadores WHERE categoria = ?");
$jugadores->execute([$categoria]);

// Procesar el formulario para registrar el estado de un jugador
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jugador_id = $_POST['jugador_id'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $inicio = $_POST['fecha_inicio'];
    $fin = $_POST['fecha_fin'];

    // Insertar el estado del jugador en la base de datos
    $stmt = $pdo->prepare("INSERT INTO estado_jugador (jugador_id, tipo, descripcion, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$jugador_id, $tipo, $descripcion, $inicio, $fin]);

    // Mostrar mensaje de éxito
    echo "<div class='container alert alert-success mt-3'>Estado registrado correctamente</div>";
}
?>

<div class="container mt-4">
    <h3>Registrar lesión o sanción</h3>

    <!-- Formulario para registrar una lesión o sanción -->
    <form method="POST" class="mb-4" style="max-width: 600px;">
        <div class="mb-3">
            <label>Jugador</label>
            <select name="jugador_id" class="form-select" required>
                <option value="">Selecciona un jugador</option>
                <?php foreach ($jugadores as $j): ?>
                    <option value="<?= $j['id'] ?>"><?= $j['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Tipo</label>
            <select name="tipo" class="form-select" required>
                <option value="lesión">Lesión</option>
                <option value="sanción">Sanción</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>
        <div class="row">
            <div class="col">
                <label>Fecha inicio</label>
                <input type="date" name="fecha_inicio" class="form-control" required>
            </div>
            <div class="col">
                <label>Fecha fin</label>
                <input type="date" name="fecha_fin" class="form-control" required>
            </div>
        </div>
        <button class="btn btn-primary mt-3" type="submit">Registrar estado</button>
    </form>
</div>

</body>
</html>
