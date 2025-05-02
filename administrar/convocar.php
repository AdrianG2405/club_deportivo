<?php
// Conectar con la base de datos
require '../includes/db.php';
include '../includes/header.php';

// Si ya se ha seleccionado un partido
$partidoId = isset($_GET['partido_id']) ? $_GET['partido_id'] : null;

if ($partidoId) {
    // Obtener los datos del partido
    $stmt = $pdo->prepare("SELECT * FROM partidos WHERE id = ?");
    $stmt->execute([$partidoId]);
    $partido = $stmt->fetch();

    if (!$partido) {
        echo "<div class='container mt-4 alert alert-danger'>El partido no existe. Por favor selecciona uno válido.</div>";
        exit;
    }

    // Obtener jugadores por categoría del partido
    $stmt = $pdo->prepare("SELECT * FROM jugadores WHERE categoria = ?");
    $stmt->execute([$partido['categoria']]);
    $jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener los jugadores convocados para este partido
    $stmt = $pdo->prepare("SELECT jugador_id, titular FROM convocatorias WHERE partido_id = ?");
    $stmt->execute([$partidoId]);
    $convocados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Crear un array con los jugadores convocados para fácil referencia
    $jugadoresConvocados = [];
    foreach ($convocados as $convocado) {
        $jugadoresConvocados[$convocado['jugador_id']] = $convocado['titular'];
    }

    // Guardar convocatoria si se envía el formulario
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Eliminar convocatorias anteriores para este partido
        $pdo->prepare("DELETE FROM convocatorias WHERE partido_id = ?")->execute([$partidoId]);

        if (!empty($_POST['convocados'])) {
            foreach ($_POST['convocados'] as $jugadorId) {
                $titular = in_array($jugadorId, $_POST['titulares'] ?? []) ? 1 : 0;
                $stmt = $pdo->prepare("INSERT INTO convocatorias (partido_id, jugador_id, titular) VALUES (?, ?, ?)");
                $stmt->execute([$partidoId, $jugadorId, $titular]);
            }
            echo "<div class='alert alert-success mt-3'>Convocatoria actualizada correctamente.</div>";
        } else {
            echo "<div class='alert alert-warning mt-3'>No se seleccionaron jugadores.</div>";
        }
    }
}

?>

<div class="container mt-4">
    <h3>Convocar jugadores para el partido</h3>

    <?php if (!$partidoId): ?>
        <!-- Si no se ha seleccionado un partido, mostrar la lista de partidos disponibles -->
        <div class="alert alert-info">Por favor, selecciona un partido:</div>
        <ul class="list-group">
            <?php
            $stmt = $pdo->query("SELECT * FROM partidos ORDER BY fecha DESC");
            while ($partido = $stmt->fetch(PDO::FETCH_ASSOC)):
            ?>
                <li class="list-group-item">
                    <a href="?partido_id=<?= $partido['id'] ?>"><?= htmlspecialchars($partido['fecha']) ?> | <?= htmlspecialchars($partido['rival']) ?> (<?= htmlspecialchars($partido['categoria']) ?>)</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <!-- Mostrar jugadores y convocatoria del partido seleccionado -->
        <p><strong><?= htmlspecialchars($partido['fecha']) ?> | <?= htmlspecialchars($partido['rival']) ?> (<?= htmlspecialchars($partido['categoria']) ?>)</strong></p>

        <?php if (count($jugadores) === 0): ?>
            <div class="alert alert-info">No hay jugadores registrados en la categoría <strong><?= htmlspecialchars($partido['categoria']) ?></strong>.</div>
        <?php else: ?>
            <form method="POST">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Equipo</th>
                            <th>Convocado</th>
                            <th>Titular</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jugadores as $jugador): ?>
                            <tr>
                                <td><?= htmlspecialchars($jugador['nombre'] . ' ' . ($jugador['apellido'] ?? '')) ?></td>
                                <td><?= htmlspecialchars($partido['equipo']) ?></td>
                                <td><input type="checkbox" name="convocados[]" value="<?= $jugador['id'] ?>" <?= isset($jugadoresConvocados[$jugador['id']]) ? 'checked' : '' ?>></td>
                                <td><input type="checkbox" name="titulares[]" value="<?= $jugador['id'] ?>" <?= isset($jugadoresConvocados[$jugador['id']]) && $jugadoresConvocados[$jugador['id']] == 1 ? 'checked' : '' ?>></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Guardar Convocatoria</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>

<?php include '../includes/footer.php'; ?>
