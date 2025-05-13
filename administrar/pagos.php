<?php
require '../includes/db.php';
include '../includes/header.php';

$jugador = null;
$pagos = [];
$mensaje = null;

// Procesar formulario de búsqueda
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nombre'], $_POST['apellido'])) {
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

        // Obtener total pagado y deuda restante
        $pagado = array_sum(array_column($pagos, 'monto'));
        $cuotaTotal = 300.00; // Puedes ajustar este valor
        $restante = $cuotaTotal - $pagado;
    } else {
        $mensaje = "No se encontró un jugador con ese nombre y apellido.";
    }
}
?>

<main class="container mt-4">
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

        <p><strong>Total de la cuota:</strong> 300.00 €</p>
        <p><strong>Total pagado:</strong> <?= number_format($pagado, 2) ?> €</p>
        <p><strong>Restante:</strong> <?= number_format($restante, 2) ?> €</p>

        <?php if (empty($pagos)): ?>
            <div class="alert alert-warning">No hay pagos registrados para este jugador.</div>
        <?php else: ?>
            <table class="table table-bordered mt-3">
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

        <!-- Botón para simular pago -->
        <div class="mt-4 mb-5">
            <form action="realizar_pago.php" method="POST" class="d-flex flex-column" style="max-width: 400px;">
                <input type="hidden" name="jugador_id" value="<?= $jugador['id'] ?>">
                <div class="mb-3">
                    <label for="cantidad">Cantidad a pagar (€):</label>
                    <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" max="<?= $restante ?>" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="cuenta">Cuenta bancaria (IBAN):</label>
                    <input type="text" name="cuenta" id="cuenta" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Hacer transferencia</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- Espacio adicional para evitar superposición con el footer -->
    <div style="height: 100px;"></div>
</main>

<?php include '../includes/footer.php'; ?>
