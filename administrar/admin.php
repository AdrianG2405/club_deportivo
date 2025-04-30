<?php
// Protección de acceso
require_once '../includes/auth.php';

// Conexiones y encabezados
include '../includes/header.php';

require '../includs/db.php';

// Obtener usuarios registrados
$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesamiento del formulario de actividad
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $categoria = $_POST['categoria'];
    $rival = $_POST['rival'];
    $lugar = $_POST['lugar'];

    if (!empty($rival)) {
        // Crear partido
        $stmt = $pdo->prepare("INSERT INTO partidos (fecha, hora, rival, lugar, categoria) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$fecha, $hora, $rival, $lugar, $categoria]);
        $mensaje = "✅ Partido creado correctamente.";
    } else {
        // Crear entrenamiento
        $stmt = $pdo->prepare("INSERT INTO entrenamientos (fecha, hora, categoria) VALUES (?, ?, ?)");
        $stmt->execute([$fecha, $hora, $categoria]);
        $mensaje = "✅ Entrenamiento creado correctamente.";
    }
}
?>

<div class="container mt-4">
    <h2>Panel de Administrador</h2>
    <p class="text-muted">Gestión de usuarios y actividades</p>

    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-success"><?= $mensaje ?></div>
    <?php endif; ?>

    <a href="registro_jugadores.php" class="btn btn-secondary mb-3">Registrar nuevo jugador</a>

    <h4>Usuarios Registrados</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['id']) ?></td>
                    <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td><?= htmlspecialchars($usuario['rol']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <hr>

    <h4>Crear nueva actividad</h4>
    <form method="POST" action="">
        <div class="row mb-3">
            <div class="col">
                <input type="date" name="fecha" class="form-control" required>
            </div>
            <div class="col">
                <input type="time" name="hora" class="form-control" required>
            </div>
            <div class="col">
                <input type="text" name="categoria" class="form-control" placeholder="Categoría" required>
            </div>
        </div>
        <div class="mb-3">
            <input type="text" name="rival" class="form-control" placeholder="Rival (vacío si es entrenamiento)">
        </div>
        <div class="mb-3">
            <input type="text" name="lugar" class="form-control" placeholder="Lugar (opcional)">
        </div>
        <button type="submit" class="btn btn-primary">Crear actividad</button>
    </form>
</div>

</body>
</html>
