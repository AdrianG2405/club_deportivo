<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: ../includes/login.php");  // Redirigir al login si no está logueado
    exit;
}

// Verificar si el usuario tiene el rol de "entrenador"
if ($_SESSION['usuario']['rol'] !== 'entrenador') {
    header("Location: ../includes/error.php");  // Redirigir a página de error si no es entrenador
    exit;
}

// Incluir encabezado y menú
include '../includes/header.php';  
require '../includes/db.php'; 

// Obtener el id del entrenador
$entrenadorId = $_SESSION['usuario']['id'];

// Obtener todos los jugadores asignados al entrenador
$stmt = $pdo->prepare("SELECT * FROM jugadores WHERE entrenador_id = ?");
$stmt->execute([$entrenadorId]);
$jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener las convocatorias de los partidos
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

    <!-- Botón para asignar jugadores -->
    <a href="asignar_jugadores.php" class="btn btn-success mb-3">Asignar Jugadores</a>

    <!-- Mostrar los jugadores del entrenador -->
    <h3>Mis Jugadores</h3>
    <?php if (empty($jugadores)): ?>
        <div class="alert alert-warning">No tienes jugadores asignados.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($jugadores as $jugador): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($jugador['nombre']) ?> (<?= htmlspecialchars($jugador['categoria']) ?>)</strong>
                    <br>Padre: <?= htmlspecialchars($jugador['padre_id']) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <hr>

    <!-- Mostrar las convocatorias de partidos -->
    <h3>Convocatorias de Partidos</h3>
    <?php if (empty($convocatorias_partidos)): ?>
        <div class="alert alert-warning">No hay convocatorias registradas.</div>
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
                        <td><?= htmlspecialchars($convocatoria['fecha']) ?></td>
                        <td><?= htmlspecialchars($convocatoria['rival']) ?></td>
                        <td><?= htmlspecialchars($convocatoria['lugar']) ?></td>
                        <td><?= $convocatoria['titular'] ? 'Sí' : 'No' ?></td>
                        <td><?= htmlspecialchars($convocatoria['resultado'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($convocatoria['jugador_nombre']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>

<?php include '../includes/footer.php'; ?>
