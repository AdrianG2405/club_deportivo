<?php
require '../includes/db.php';
include '../includes/header.php';

$jugador = null;
$pagos = [];
$mensaje = null;

// Procesar formulario de búsqueda
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];

    // Buscar al jugador
    $stmt = $pdo->prepare("SELECT * FROM jugadores WHERE nombre = ? AND apellido = ?");
    $stmt->execute([$nombre, $apellido]);
    $jugador = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($jugador) {
        // Obtener pagos del jugador
        $pagosStmt = $pdo->prepare("SELECT * FROM pagos WHERE jugador_id = ? ORDER BY fecha_pago DESC");
        $pagosStmt->execute([$jugador['id']]);
        $pagos = $pagosStmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $mensaje = "No se encontró un jugador con ese nombre y apellido.";
    }
}
?>

<div class="container mt-4">
    <h2>Consulta de Pagos del Jugador</h2>

    <form method="POST" class="mb-4" style="max-width: 600px;">
        <div class="mb-3">
            <label for="nombre">Nombre del jugador</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="apellido">Apellido del jugador</label>
            <input type="text" name="apellido" id="apellido" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <?php if ($mensaje): ?>
        <div class="alert alert-danger"><?= $mensaje ?></div>
    <?php endif; ?>

    <?php if ($jugador): ?>
        <h4>Pagos de <?= htmlspecialchars($jugador['nombre']) ?> <?= htmlspecialchars($jugador['apellido']) ?></h4>

        <?php if (empty($pagos)): ?>
            <div class="alert alert-warning">No hay pagos registrados para este jugador.</div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Concepto</th>
                        <th>Monto</th>
                        <th>Fecha de Pago</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pagos as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['concepto']) ?></td>
                            <td><?= number_format($p['monto'], 2) ?> €</td>
                            <td><?= htmlspecialchars($p['fecha_pago']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
<?php include '../includes/footer.php'; ?>
