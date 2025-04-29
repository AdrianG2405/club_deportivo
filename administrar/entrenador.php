<?php
session_start();

// Si el usuario no está autenticado, redirigir al login
if (!isset($_SESSION['usuario'])) {
    header("Location: ../includes/login.php");
    exit;
}

// Verificar si el usuario tiene el rol de 'entrenador'
if ($_SESSION['usuario']['rol'] !== 'entrenador') {
    header("Location: ../includes/login.php");
    exit;
}

include '../includes/header.php';
include '../includes/menu.php';
require '../includes/db.php';

// Obtener los entrenadores (o lo que necesites, si hay una lista de entrenadores)
$stmt = $pdo->prepare("SELECT * FROM entrenadores");
$stmt->execute();
$entrenadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Panel de Entrenadores</h2>

    <?php if (empty($entrenadores)): ?>
        <div class="alert alert-warning">No hay entrenadores registrados.</div>
    <?php else: ?>
        <table class="table">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entrenadores as $entrenador): ?>
                    <tr>
                        <td><?= $entrenador['nombre'] ?></td>
                        <td><?= $entrenador['categoria'] ?></td>
                        <td><a href="editar_entrenador.php?id=<?= $entrenador['id'] ?>" class="btn btn-info">Editar</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
