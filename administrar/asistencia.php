<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'entrenador') {
    header("Location: ../includes/login.php");
    exit;
}

include '../includes/header.php';

require '../includes/db.php';

$categoria = 'Alevín'; // Podés hacerlo dinámico más adelante
$fechaHoy = date('Y-m-d');

// Obtener entrenamientos de la categoría
$entrenamientos = $pdo->prepare("SELECT * FROM entrenamientos WHERE categoria = ? ORDER BY fecha DESC");
$entrenamientos->execute([$categoria]);
$listaEntrenamientos = $entrenamientos->fetchAll(PDO::FETCH_ASSOC);

// Obtener jugadores de la categoría
$jugadores = $pdo->prepare("SELECT * FROM jugadores WHERE categoria = ?");
$jugadores->execute([$categoria]);
$listaJugadores = $jugadores->fetchAll(PDO::FETCH_ASSOC);

// Crear tabla de asistencia si no existe
$pdo->exec("CREATE TABLE IF NOT EXISTS asistencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    entrenamiento_id INT,
    jugador_id INT,
    presente BOOLEAN,
    FOREIGN KEY (entrenamiento_id) REFERENCES entrenamientos(id),
    FOREIGN KEY (jugador_id) REFERENCES jugadores(id)
)");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $entrenamientoId = $_POST['entrenamiento'];
    $presentes = $_POST['presentes'] ?? [];

    // Limpiar registros anteriores
    $pdo->prepare("DELETE FROM asistencia WHERE entrenamiento_id = ?")->execute([$entrenamientoId]);

    // Guardar nuevos registros
    foreach ($listaJugadores as $jugador) {
        $presente = in_array($jugador['id'], $presentes) ? 1 : 0;
        $stmt = $pdo->prepare("INSERT INTO asistencia (entrenamiento_id, jugador_id, presente) VALUES (?, ?, ?)");
        $stmt->execute([$entrenamientoId, $jugador['id'], $presente]);
    }

    $mensaje = "✅ Asistencia registrada correctamente.";
}
?>

<div class="container mt-4">
    <h3>Registrar asistencia a entrenamiento</h3>

    <?php if ($mensaje): ?>
        <div class="alert alert-success"><?= $mensaje ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="entrenamiento" class="form-label">Entrenamiento</label>
            <select name="entrenamiento" class="form-select" required>
                <option value="">Selecciona uno</option>
                <?php foreach ($listaEntrenamientos as $ent): ?>
                    <option value="<?= $ent['id'] ?>">
                        <?= $ent['fecha'] ?> (<?= $ent['hora'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Jugador</th>
                    <th>Presente</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaJugadores as $jugador): ?>
                    <tr>
                        <td><?= htmlspecialchars($jugador['nombre']) ?></td>
                        <td>
                            <input type="checkbox" name="presentes[]" value="<?= $jugador['id'] ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Guardar asistencia</button>
    </form>
</div>

</body>
</html>
