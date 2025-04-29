<?php
// Incluir archivo de configuración de base de datos
require_once '../includes/db.php';

// Obtener todos los entrenadores desde la base de datos
$query = $pdo->prepare("SELECT * FROM entrenadores ORDER BY nombre ASC");
$query->execute();
$entrenadores = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrenadores - Club Deportivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Incluir el menú de navegación -->
    <?php include('../includes/header.php'); ?> <!-- Cambié la ruta para que se incluya correctamente -->

    <!-- Contenido principal -->
    <div class="container mt-4">
        <h2>Lista de Entrenadores</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Especialidad</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entrenadores as $entrenador): ?>
                    <tr>
                        <td><?= htmlspecialchars($entrenador['nombre']) ?></td>
                        <td><?= htmlspecialchars($entrenador['especialidad']) ?></td>
                        <td>
                            <a href="editar_entrenador.php?id=<?= $entrenador['id'] ?>" class="btn btn-warning">Editar</a>
                            <a href="eliminar_entrenador.php?id=<?= $entrenador['id'] ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Agregar el script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
