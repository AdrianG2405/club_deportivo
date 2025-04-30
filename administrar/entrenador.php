<?php
session_start();

// Verificar si el usuario está autenticado y tiene el rol de 'entrenador'
if (!isset($_SESSION['usuario'])) {
    header("Location: ../includes/login.php");  // Si no está logueado, redirigir al login
    exit;
}

// Verificar si el usuario es un "padre"
if ($_SESSION['usuario']['rol'] === 'padre') {
    // Si es un "padre", redirigir a la página de error
    header("Location: error.php");
    exit;
}

// Si es un "entrenador", continuar con la ejecución de la página
include '../includes/header.php';  // Incluir el encabezado del sitio
require '../includes/db.php';      // Asegúrate de que esta ruta sea correcta

// Obtener el id del entrenador (usado en consultas)
$entrenadorId = $_SESSION['usuario']['id'];

// Obtener todos los jugadores
$stmt = $pdo->query("SELECT * FROM jugadores WHERE entrenador_id = $entrenadorId");
$jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener las convocatorias de partidos
$convocatorias = $pdo->query("
    SELECT p.fecha, p.rival, p.lugar, p.resultado, c.titular, j.nombre AS jugador_nombre
    FROM convocatorias c
    JOIN partidos p ON c.partido_id = p.id
    JOIN jugadores j ON c.jugador_id = j.id
    WHERE j.entrenador_id = $entrenadorId
    ORDER BY p.fecha DESC
");
$convocatorias_partidos = $convocatorias->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Panel del Entrenador</h2>

    <!-- Botón para asignar jugadores -->
    <a href="asignar_jugadores.php" class="btn btn-success mb-3">Asignar Jugadores</a>

    <!-- Mostrar jugadores -->
    <h3>Mis Jugadores</h3>
    <?php if (empty($jugadores)): ?>
        <div class="alert alert-warning">No tienes jugadores asignados.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($jugadores as $jugador): ?>
                <li class="list-group-item">
                    <strong><?= $jugador['nombre'] ?> (<?= $jugador['categoria'] ?>)</strong>
                    <br>Padre: <?= $jugador['padre_id'] ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <hr>

    <!-- Mostrar las convocatorias -->
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
<?php include '../includes/footer.php'; ?>
