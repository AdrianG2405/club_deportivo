<?php
// Conectar con la base de datos
require_once '../includes/db.php';

// Obtener los entrenamientos y partidos programados
$entrenamientos = $pdo->prepare("SELECT * FROM entrenamientos ORDER BY fecha DESC");
$entrenamientos->execute();

$partidos = $pdo->prepare("SELECT * FROM partidos ORDER BY fecha DESC");
$partidos->execute();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario - Club Deportivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Menú de navegación -->
    <?php include('header.php'); ?>  <!-- Este incluye el menú desde el archivo header.php -->

    <!-- Contenido principal -->
    <div class="container mt-4">
        <h2>Calendario de Entrenamientos y Partidos</h2>

        <h4>Próximos Entrenamientos</h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entrenamientos as $ent): ?>
                    <tr>
                        <td><?= $ent['fecha'] ?></td>
                        <td><?= $ent['hora'] ?></td>
                        <td><?= $ent['categoria'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>Próximos Partidos</h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Rival</th>
                    <th>Lugar</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($partidos as $part): ?>
                    <tr>
                        <td><?= $part['fecha'] ?></td>
                        <td><?= $part['rival'] ?></td>
                        <td><?= $part['lugar'] ?></td>
                        <td><?= $part['resultado'] ?? '—' ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
