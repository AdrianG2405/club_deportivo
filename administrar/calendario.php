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
    <?php include '../includes/header.php'; ?>  <!-- Incluye el menú desde el archivo header.php -->

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
                        <td><?= htmlspecialchars($ent['fecha']) ?></td>
                        <td><?= htmlspecialchars($ent['hora']) ?></td>
                        <td><?= htmlspecialchars($ent['categoria']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>Próximos Partidos</h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Equipo Local</th>
                    <th>Rival</th>
                    <th>Lugar</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($partidos as $part): ?>
                    <tr>
                        <td><?= htmlspecialchars($part['fecha']) ?></td>
                        <td><?= htmlspecialchars($part['equipo_local']) ?></td>
                        <td><?= htmlspecialchars($part['rival']) ?></td>
                        <td><?= htmlspecialchars($part['lugar']) ?></td>
                        <td><?= htmlspecialchars($part['resultado'] ?? '—') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include '../includes/footer.php'; ?>
