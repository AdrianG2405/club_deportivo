<?php
// No es necesario iniciar sesión o verificar el rol ya que la página es pública
require '../includes/db.php';
include '../includes/header.php';

// Obtener jugadores disponibles para asistencia
$stmt = $pdo->query("SELECT id, nombre, categoria FROM jugadores");
$jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Asistencia de Jugadores</h2>

    <form method="POST" class="mb-3">
        <div class="mb-3">
            <label for="jugador_id" class="form-label">Selecciona un jugador:</label>
            <select name="jugador_id" class="form-select" required>
                <?php foreach ($jugadores as $jugador): ?>
                    <option value="<?= $jugador['id'] ?>">
                        <?= $jugador['nombre'] ?> (<?= $jugador['categoria'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar Asistencia</button>
    </form>

    <a href="index.php" class="btn btn-secondary">Volver al inicio</a>
</div>

</body>
</html>

<?php include '../includes/footer.php'; ?>
