<?php
require '../includes/db.php';
include '../includes/header.php';

// Obtener todos los jugadores y sus equipos
$stmt = $pdo->query("SELECT jugadores.*, equipos.nombre AS equipo_nombre
                     FROM jugadores
                     LEFT JOIN equipos ON jugadores.equipo = equipos.id");

$jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Jugadores Registrados</h2>

    <?php if (empty($jugadores)): ?>
        <div class="alert alert-warning">No hay jugadores registrados.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Categoría</th>
                    <th>Equipo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jugadores as $jugador): ?>
                    <tr>
                        <td><a href="estadisticas_jugador.php?id=<?= $jugador['id'] ?>"><?= htmlspecialchars($jugador['nombre']) ?></a></td>
                        <td><?= htmlspecialchars($jugador['apellido']) ?></td>
                        <td><?= htmlspecialchars($jugador['categoria']) ?></td>
                        <td><?= htmlspecialchars($jugador['equipo']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
