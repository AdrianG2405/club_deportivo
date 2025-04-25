<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit;
}

include '../includes/header.php';
include '../includes/menu.php';
require '../db.php';

$esPadre = $_SESSION['usuario']['rol'] === 'padre';
$padreId = $esPadre ? $_SESSION['usuario']['id'] : null;

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $padre_id = $esPadre ? $padreId : $_POST['padre_id'];

    $stmt = $pdo->prepare("INSERT INTO jugadores (nombre, categoria, padre_id) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $categoria, $padre_id]);

    echo "<div class='container mt-4 alert alert-success'>Jugador registrado correctamente</div>";
}
?>

<div class="container mt-5">
    <h2>Registrar nuevo jugador</h2>
    <form method="POST" class="mt-3" style="max-width: 500px;">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del jugador</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select name="categoria" class="form-select" required>
                <option value="">Selecciona</option>
                <option value="Prebenjamín">Prebenjamín</option>
                <option value="Benjamín">Benjamín</option>
                <option value="Alevín">Alevín</option>
                <option value="Infantil">Infantil</option>
                <option value="Cadete">Cadete</option>
                <option value="Juvenil">Juvenil</option>
            </select>
        </div>

        <?php if (!$esPadre): ?>
            <div class="mb-3">
                <label for="padre_id" class="form-label">ID del padre</label>
                <input type="number" name="padre_id" class="form-control" required>
                <div class="form-text">Debe ser el ID del usuario con rol "padre".</div>
            </div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary">Registrar jugador</button>
    </form>
</div>

</body>
</html>
