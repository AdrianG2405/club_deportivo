<?php
session_start();
require '../includes/db.php'; // Conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../includes/login.php");
    exit;
}

// Si el usuario no tiene rol de 'padre', no debe poder acceder a esta página
if ($_SESSION['usuario']['rol'] !== 'padre') {
    header("Location: ../index.php");
    exit;
}

$padreId = $_SESSION['usuario']['id'];

// Procesar el formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $categoria = $_POST['categoria'];

    // Validar campos
    if (empty($nombre) || empty($categoria)) {
        echo "<div class='alert alert-danger'>Por favor, completa todos los campos.</div>";
    } else {
        // Insertar el nuevo jugador en la base de datos
        $stmt = $pdo->prepare("INSERT INTO jugadores (nombre, categoria, padre_id) VALUES (?, ?, ?)");
        if ($stmt->execute([$nombre, $categoria, $padreId])) {
            echo "<div class='alert alert-success'>Jugador registrado correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Hubo un error al registrar al jugador. Intenta de nuevo.</div>";
        }
    }
}
?>

<!-- Formulario de registro de jugador -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Jugador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registrar nuevo jugador</h2>
        <form method="POST">
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

            <button type="submit" class="btn btn-primary">Registrar jugador</button>
        </form>
    </div>

</body>
</html>
<?php include '../includes/footer.php'; ?>
