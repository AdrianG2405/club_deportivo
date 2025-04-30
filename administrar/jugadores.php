<?php
require '../includes/db.php';
include '../includes/header.php';

$stmt = $pdo->query("SELECT jugadores.*, equipos.nombre AS equipo_nombre
                     FROM jugadores
                     LEFT JOIN equipos ON jugadores.equipo_id = equipos.id");

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
                    <th>Categoría</th>
                    <th>Equipo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jugadores as $jugador): ?>
                    <tr>
                        <td><?= $jugador['nombre'] ?></td>
                        <td><?= $jugador['categoria'] ?></td>
                        <td><?= $jugador['equipo_nombre'] ?? 'Sin equipo' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
