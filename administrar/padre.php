<?php
session_start();

// Verificar si el usuario está autenticado y tiene el rol de 'padre'
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'padre') {
    header("Location: ../includes/login.php");  // Corregido la ruta al login
    exit;
}

include '../includes/header.php';  // Corregido la ruta
include '../includes/menu.php';    // Corregido la ruta
require '../includes/db.php';      // Corregido la ruta

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
            <!-- Botón para registrar nuevo jugador -->
            <a href="registro_jugador.php" class="btn btn-secondary mb-3">Registrar nuevo jugador</a>

            <!-- Tarjeta con detalles del hijo -->
            <div class="card mb-4">
                <div class="card-header">
                    <strong><?= htmlspecialchars($hijo['nombre']) ?> (<?= htmlspecialchars($hijo['categoria']) ?>)</strong>
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
                                <td><?= htmlspecialchars($convocatoria['fecha']) ?></td>
                                <td><?= htmlspecialchars($convocatoria['rival']) ?></td>
                                <td><?= htmlspecialchars($convocatoria['lugar']) ?></td>
                                <td><?= $convocatoria['titular'] ? 'Sí' : 'No' ?></td>
                                <td><?= $convocatoria['resultado'] ?? '—' ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Aquí podrías mostrar también lesiones, sanciones, pagos, etc. -->
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Agregar el script de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
