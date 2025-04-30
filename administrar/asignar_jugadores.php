<?php
session_start();

// Asegurarse de que solo entrenadores accedan
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'entrenador') {
    header("Location: ../includes/login.php");
    exit;
}

require '../includes/db.php';
include '../includes/header.php';

$entrenadorId = $_SESSION['usuario']['id'];

// Procesar asignación si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jugador_id'])) {
    $jugadorId = $_POST['jugador_id'];

    // Asignar entrenador al jugador
    $stmt = $pdo->prepare("UPDATE jugadores SET entrenador_id = ? WHERE id = ?");
    $stmt->execute([$entrenadorId, $jugadorId]);

    echo "<div class='container mt-4 alert alert-success'>Jugador asignado correctamente.</div>";
}

// Obtener jugadores sin entrenador asignado
$stmt = $pdo->query("SELECT id, nombre, categoria FROM jugadores WHERE entrenador_id IS NULL");
$jugadores_disponibles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Asignar Jugadores</h2>

    <?php if (empty($jugadores_disponibles)): ?>
        <div class="alert alert-info">No hay jugadores disponibles para asignar.</div>
    <?php else: ?>
        <form method="POST" class="mb-3">
            <div class="mb-3">
                <label for="jugador_id" class="form-label">Selecciona un jugador:</label>
                <select name="jugador_id" class="form-select" required>
                    <?php foreach ($jugadores_disponibles as $jugador): ?>
                        <option value="<?= $jugador['id'] ?>">
                            <?= $jugador['nombre'] ?> (<?= $jugador['categoria'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Asignar</button>
        </form>
    <?php endif; ?>

    <a href="entrenador.php" class="btn btn-secondary">Volver al panel</a>
</div>
</body>
</html>
<?php include '../includes/footer.php'; ?>
