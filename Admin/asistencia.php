<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'entrenador') {
    header("Location: ../login.php");
    exit;
}

include '../includes/header.php';
include '../includes/menu.php';
require '../db.php';

$categoria = 'Alevín'; // o dinámica
$fechaHoy = date('Y-m-d');

// Obtener entrenamientos
$entrenamientos = $pdo->prepare("SELECT * FROM entrenamientos WHERE categoria = ? ORDER BY fecha DESC");
$entrenamientos->execute([$categoria]);

// Obtener jugadores
$jugadores = $pdo->prepare("SELECT * FROM jugadores WHERE categoria = ?");
$jugadores->execute([$categoria]);

// Crear tabla si no existe
$pdo->exec("CREATE TABLE IF NOT EXISTS asistencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    entrenamiento_id INT,
    jugador_id INT,
    presente BOOLEAN,
    FOREIGN KEY (entrenamiento_id) REFERENCES entrenamientos(id),
    FOREIGN KEY (jugador_id) REFERENCES jugadores(id)
)");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $entrenamientoId = $_POST['entrenamiento'];
    $presentes = $_POST['presentes'] ?? [];

    $pdo->prepare("DELETE FROM asistencia WHERE entrenamiento_id = ?")->execute([$entrenamientoId]);

    foreach ($jugadores as $jugador) {
        $presente = in_array($jugador['id'], $presentes) ? 1 : 0;
        $stmt = $pdo->prepare("INSERT INTO asistencia (entrenamiento_id, jugador_id, presente) VALUES (?, ?, ?)");
        $stmt->execute([$entrenamientoId, $jugador['id'], $presente]);
    }

    echo "<div class='container alert alert-success mt-3'>Asistencia registrada.</div>";
}
?>

<div class="container mt-4">
    <h3>Registrar asistencia a entrenamiento</h3>
    <form method="POST">
        <div class="mb-3">
            <label for="entrenamiento" class="form-label">Entrenamiento</label>
            <select name="entrenamiento" class="form-select" required>
                <option value="">Selecciona uno</option>
                <?php foreach ($entrenamientos as $ent): ?>
                    <option value="<?= $ent['id'] ?>">
                        <?= $ent['fecha'] ?> (<?= $ent['hora'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Jugador</th>
                    <th>Presente</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jugadores as $jugador): ?>
                    <tr>
                        <td><?= $jugador['nombre'] ?></td>
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
