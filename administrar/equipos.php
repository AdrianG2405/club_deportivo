<?php
session_start();
require '../includes/db.php';
include '../includes/header.php';

// Obtener todos los equipos
$stmt = $pdo->query("SELECT * FROM equipos");
$equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Comprobar si se ha seleccionado un equipo para mostrar el plantel
$equipoSeleccionado = $_GET['equipo'] ?? '';
$jugadores = [];

if ($equipoSeleccionado) {
    $stmt = $pdo->prepare("SELECT nombre, apellido FROM jugadores WHERE equipo = ? LIMIT 16");
    $stmt->execute([$equipoSeleccionado]);
    $jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container mt-4">
    <h2>Listado de Equipos</h2>

    <?php if (empty($equipos)): ?>
        <div class="alert alert-warning">No hay equipos registrados.</div>
    <?php else: ?>
        <ul class="list-group mb-4">
            <?php foreach ($equipos as $equipo): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="?equipo=<?= urlencode($equipo['nombre']) ?>">
                        <strong><?= htmlspecialchars($equipo['nombre']) ?></strong>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($equipoSeleccionado): ?>
        <h4>Plantilla del equipo: <?= htmlspecialchars($equipoSeleccionado) ?></h4>

        <?php if (empty($jugadores)): ?>
            <div class="alert alert-info">No hay jugadores registrados en este equipo.</div>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jugadores as $i => $jugador): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($jugador['nombre']) ?></td>
                            <td><?= htmlspecialchars($jugador['apellido']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
