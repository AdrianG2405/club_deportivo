<?php
session_start();
require '../includes/db.php'; // Ajusta si está en otra ruta
include '../includes/header.php'; // Incluir el encabezado

// Obtener todos los equipos
$stmt = $pdo->query("SELECT * FROM equipos");
$equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Listado de Equipos</h2>

    <?php if (empty($equipos)): ?>
        <div class="alert alert-warning">No hay equipos registrados.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($equipos as $equipo): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($equipo['nombre']) ?></strong>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

</body>
</html>
