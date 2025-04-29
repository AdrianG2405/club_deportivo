<?php
session_start();

// Verificar si el usuario está autenticado y tiene el rol de 'padre'
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'padre') {
    header("Location: ../includes/login.php");
    exit;
}

include '../include/header.php';  // Corregido
include '../include/menu.php';    // Corregido
require '../include/db.php';      // Corregido

$padreId = $_SESSION['usuario']['id'];

// Obtener los hijos (jugadores) del padre actual
$stmt = $pdo->prepare("SELECT * FROM jugadores WHERE padre_id = ?");
$stmt->execute([$padreId]);
$hijos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Panel para Padres</h2>
    <!-- Mensaje si no tiene hijos registrados -->
    <?php if (empty($hijos)): ?>
        <div class="alert alert-warning">No tienes hijos registrados en el sistema.</div>
    <?php else: ?>
        <?php foreach ($hijos as $hijo): ?>
            <a href="registro_jugador.php" class="btn btn-secondary mb-3">Registrar nuevo jugador</a>
            <div class="card mb-4">
                <div class="card-header">
                    <strong><?= $hijo['nombre'] ?> (<?= $hijo['categoria'] ?>)</strong>
                </div>
                <div class="card-body">
                    <h5>Convocatorias de partidos</h5>
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Rival</th>
                                <th>Lugar</th>
                                <th>Titular</th>
                                <th>Resultado</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Obtener las convocatorias de partidos para cada hijo
                        $convocatorias = $pdo->prepare("
                            SELECT p.fecha, p.rival, p.lugar, p.resultado, c.titular
                            FROM convocatorias c
                            JOIN partidos p ON c.partido_id = p.id
                            WHERE c.jugador_id = ?
                            ORDER BY p.fecha DESC
                        ");
                        $convocatorias->execute([$hijo['id']]);
                        foreach ($convocatorias as $convocatoria):
                        ?>
                            <tr>
                                <td><?= $convocatoria['fecha'] ?></td>
                                <td><?= $convocatoria['rival'] ?></td>
                                <td><?= $convocatoria['lugar'] ?></td>
                                <td><?= $convocatoria['titular'] ? 'Sí' : 'No' ?></td>
                                <td><?= $convocatoria['resultado'] ?? '—' ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
