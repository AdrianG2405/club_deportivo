<?php
require '../includes/db.php';
include '../includes/header.php';

$jugador_id = $_GET['id'] ?? null;
$jugador = null;

if ($jugador_id) {
    $stmt = $pdo->prepare("SELECT * FROM jugadores WHERE id = ?");
    $stmt->execute([$jugador_id]);
    $jugador = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$jugador) {
    echo "<div class='alert alert-danger'>Jugador no encontrado.</div>";
    exit;
}
?>

<div class="container mt-4">
    <h2>Estadísticas de <?= htmlspecialchars($jugador['nombre']) ?> <?= htmlspecialchars($jugador['apellido']) ?></h2>
    <table class="table table-bordered">
        <tr>
            <th>Goles</th>
            <td><?= $jugador['goles'] ?></td>
        </tr>
        <tr>
            <th>Asistencias</th>
            <td><?= $jugador['asistencias'] ?></td>
        </tr>
        <tr>
            <th>Tarjetas Amarillas</th>
            <td><?= $jugador['tarjetas_amarillas'] ?></td>
        </tr>
        <tr>
            <th>Tarjetas Rojas</th>
            <td><?= $jugador['tarjetas_rojas'] ?></td>
        </tr>
        <tr>
            <th>Faltas</th>
            <td><?= $jugador['faltas'] ?></td>
        </tr>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
