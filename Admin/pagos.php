<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../includes/header.php';
include '../includes/menu.php';
require '../db.php';

// Crear tabla si no existe
$pdo->exec("CREATE TABLE IF NOT EXISTS pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jugador_id INT,
    concepto VARCHAR(100),
    monto DECIMAL(10,2),
    fecha_pago DATE,
    FOREIGN KEY (jugador_id) REFERENCES jugadores(id)
)");

$jugadores = $pdo->query("SELECT * FROM jugadores")->fetchAll();

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jugador_id = $_POST['jugador_id'];
    $concepto = $_POST['concepto'];
    $monto = $_POST['monto'];
    $fecha_pago = $_POST['fecha_pago'];

    $stmt = $pdo->prepare("INSERT INTO pagos (jugador_id, concepto, monto, fecha_pago) VALUES (?, ?, ?, ?)");
    $stmt->execute([$jugador_id, $concepto, $monto, $fecha_pago]);

    echo "<div class='container alert alert-success mt-3'>Pago registrado correctamente</div>";
}
?>

<div class="container mt-4">
    <h3>Registrar pago de jugador</h3>

    <form method="POST" class="mb-5" style="max-width: 600px;">
        <div class="mb-3">
            <label>Jugador</label>
            <select name="jugador_id" class="form-select" required>
                <option value="">Selecciona un jugador</option>
                <?php foreach ($jugadores as $j): ?>
                    <option value="<?= $j['id'] ?>"><?= $j['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Concepto</label>
            <input type="text" name="concepto" class="form-control" placeholder="Ej: Cuota abril, Matrícula" required>
        </div>
        <div class="mb-3">
            <label>Monto</label>
            <input type="number" name="monto" step="0.01" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Fecha de pago</label>
            <input type="date" name="fecha_pago" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Registrar pago</button>
    </form>

    <h4>Historial de pagos</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jugador</th>
                <th>Concepto</th>
                <th>Monto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $pagos = $pdo->query("SELECT pagos.*, jugadores.nombre FROM pagos JOIN jugadores ON pagos.jugador_id = jugadores.id ORDER BY fecha_pago DESC");
            foreach ($pagos as $p):
            ?>
                <tr>
                    <td><?= $p['nombre'] ?></td>
                    <td><?= $p['concepto'] ?></td>
                    <td><?= number_format($p['monto'], 2) ?> €</td>
                    <td><?= $p['fecha_pago'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
