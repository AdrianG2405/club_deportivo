<?php
session_start();

// Si el usuario no está autenticado, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: ../includes/login.php");
    exit;
}

include '../includes/header.php';
include '../includes/menu.php';
require '../includes/db.php';

// Verificar si el usuario tiene el rol de 'padre'
$esPadre = $_SESSION['usuario']['rol'] === 'padre';
$padreId = $esPadre ? $_SESSION['usuario']['id'] : null;

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $categoria = $_POST['categoria'];
    $padre_id = $esPadre ? $padreId : $_POST['padre_id'];

    // Validar los campos
    if (empty($nombre) || empty($categoria)) {
        echo "<div class='container mt-4 alert alert-danger'>Por favor, completa todos los campos.</div>";
    } else {
        // Preparar la consulta para insertar un nuevo jugador
        $stmt = $pdo->prepare("INSERT INTO jugadores (nombre, categoria, padre_id) VALUES (?, ?, ?)");
        if ($stmt->execute([$nombre, $categoria, $padre_id])) {
            echo "<div class='container mt-4 alert alert-success'>Jugador registrado correctamente</div>";
        } else {
            echo "<div class='container mt-4 alert alert-danger'>Hubo un problema al registrar el jugador. Inténtalo de nuevo.</div>";
        }
    }
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
