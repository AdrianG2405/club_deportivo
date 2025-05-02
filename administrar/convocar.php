<?php
session_start();
require '../includes/db.php';
include '../includes/header.php';

// Obtener todos los partidos futuros
$partidosStmt = $pdo->query("SELECT id, rival, fecha, categoria FROM partidos WHERE fecha >= CURDATE() ORDER BY fecha ASC");
$partidos = $partidosStmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener el ID del partido seleccionado
$partidoId = $_GET['partido_id'] ?? null;
$jugadores = [];
$partido = null;

if ($partidoId) {
    // Obtener datos del partido
    $stmt = $pdo->prepare("SELECT * FROM partidos WHERE id = ?");
    $stmt->execute([$partidoId]);
    $partido = $stmt->fetch();

    // Obtener jugadores de la categoría del partido
    $stmt = $pdo->prepare("SELECT * FROM jugadores WHERE categoria = ?");
    $stmt->execute([$partido['categoria']]);
    $jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Guardar convocatoria
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['partido_id'])) {
    $partidoId = $_POST['partido_id'];

    // Eliminar convocatorias anteriores
    $pdo->prepare("DELETE FROM convocatorias WHERE partido_id = ?")->execute([$partidoId]);

    if (!empty($_POST['convocados'])) {
        foreach ($_POST['convocados'] as $jugadorId) {
            $titular = in_array($jugadorId, $_POST['titulares'] ?? []) ? 1 : 0;
            $stmt = $pdo->prepare("INSERT INTO convocatorias (partido_id, jugador_id, titular) VALUES (?, ?, ?)");
            $stmt->execute([$partidoId, $jugadorId, $titular]);
        }
        echo "<div class='alert alert-success mt-3'>Convocatoria guardada correctamente.</div>";
    } else {
        echo "<div class='alert alert-warning mt-3'>No se seleccionaron jugadores.</div>";
    }
}
?>

<div class="container mt-4">
    <h2>Convocar jugadores</h2>

    <!-- Formulario para seleccionar partido -->
    <form method="GET" class="mb-4">
        <div class="form-group">
            <label for="partido_id">Selecciona un partido:</label>
            <select name="partido_id" id="partido_id" class="form-control" onchange="this.form.submit()">
                <option value="">-- Selecciona un partido --</option>
                <?php foreach ($partidos as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= ($p['id'] == $partidoId) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['fecha']) ?> - <?= htmlspecialchars($p['rival']) ?> (<?= htmlspecialchars($p['categoria']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if ($partido): ?>
        <h4>Plantilla para la categoría <?= htmlspecialchars($partido['categoria']) ?> vs <?= htmlspecialchars($partido['rival']) ?></h4>

        <?php if (empty($jugadores)): ?>
            <div class="alert alert-info">No hay jugadores en esta categoría.</div>
        <?php else: ?>
            <form method="POST">
                <input type="hidden" name="partido_id" value="<?= $partidoId ?>">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Convocado</th>
                            <th>Titular</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jugadores as $jugador): ?>
                            <tr>
                                <td><?= htmlspecialchars($jugador['nombre']) ?></td>
                                <td><?= htmlspecialchars($jugador['apellido']) ?></td>
                                <td><input type="checkbox" name="convocados[]" value="<?= $jugador['id'] ?>"></td>
                                <td><input type="checkbox" name="titulares[]" value="<?= $jugador['id'] ?>"></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Guardar convocatoria</button>
            </form>
        <?php endif; ?>
    <?php elseif ($_SERVER["REQUEST_METHOD"] !== "POST"): ?>
        <div class="alert alert-info">Selecciona un partido para convocar jugadores.</div>
    <?php endif; ?>
</div>

</body>
</html>
