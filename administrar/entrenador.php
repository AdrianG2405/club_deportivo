<?php
session_start();

// Verificar si el usuario está autenticado y tiene el rol de 'entrenador'
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'entrenador') {
    header("Location: ../includes/login.php");
    exit;
}

include '../includes/header.php';  // Incluir el encabezado del sitio

require 'C:/xampp/htdocs/club_deportivo/include/db.php';
     // Conexión a la base de datos

$entrenadorId = $_SESSION['usuario']['id'];

// Obtener los jugadores asignados al entrenador
$stmt = $pdo->prepare("SELECT * FROM jugadores WHERE entrenador_id = ?");
$stmt->execute([$entrenadorId]);
$jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener las convocatorias de partidos de los jugadores del entrenador
$convocatorias = $pdo->prepare("
    SELECT p.fecha, p.rival, p.lugar, p.resultado, c.titular, j.nombre AS jugador_nombre
    FROM convocatorias c
    JOIN partidos p ON c.partido_id = p.id
    JOIN jugadores j ON c.jugador_id = j.id
    WHERE j.entrenador_id = ?
    ORDER BY p.fecha DESC
");
$convocatorias->execute([$entrenadorId]);
$convocatorias_partidos = $convocatorias->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mt-4">
    <h2>Panel del Entrenador</h2>

    <!-- Mostrar jugadores asignados al entrenador -->
    <h3>Mis Jugadores</h3>
    <?php if (empty($jugadores)): ?>
        <div class="alert alert-warning">No tienes jugadores asignados.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($jugadores as $jugador): ?>
                <li class="list-group-item">
                    <strong><?= $jugador['nombre'] ?> (<?= $jugador['categoria'] ?>)</strong>
                    <br>Padre: <?= $jugador['padre_id'] ?> <!-- Mostrar el ID del padre -->
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <hr>

    <!-- Mostrar las convocatorias de partidos -->
    <h3>Convocatorias de Partidos</h3>
    <?php if (empty($convocatorias_partidos)): ?>
        <div class="alert alert-warning">No hay convocatorias de partidos para tus jugadores.</div>
    <?php else: ?>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Rival</th>
                    <th>Lugar</th>
                    <th>Titular</th>
                    <th>Resultado</th>
                    <th>Jugador</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($convocatorias_partidos as $convocatoria): ?>
                    <tr>
                        <td><?= $convocatoria['fecha'] ?></td>
                        <td><?= $convocatoria['rival'] ?></td>
                        <td><?= $convocatoria['lugar'] ?></td>
                        <td><?= $convocatoria['titular'] ? 'Sí' : 'No' ?></td>
                        <td><?= $convocatoria['resultado'] ?? '—' ?></td>
                        <td><?= $convocatoria['jugador_nombre'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
