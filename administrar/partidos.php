<?php

require_once '../includes/db.php';


$mensaje = '';

// Procesar el formulario para crear un partido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtenerlos datos del formulario
    $equipo_local = $_POST['equipo_local'];
    $rival = $_POST['rival'];
    $fecha = $_POST['fecha'];
    $lugar = $_POST['lugar'];

    
    if (!empty($equipo_local) && !empty($rival) && !empty($fecha) && !empty($lugar)) {
        $stmt = $pdo->prepare("INSERT INTO partidos (equipo_local, rival, fecha, lugar) VALUES (?, ?, ?, ?)");
        $stmt->execute([$equipo_local, $rival, $fecha, $lugar]);

        $mensaje = "¡Partido creado correctamente!";
    } else {
        $mensaje = "Por favor, complete todos los campos.";
    }
}

// Obtener los partidos programados
$partidos = $pdo->prepare("SELECT * FROM partidos ORDER BY fecha DESC");
$partidos->execute();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear y Ver Partidos - Club Deportivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <?php include '../includes/header.php'; ?>  


    <div class="container mt-4">
        <h2>Crear un Nuevo Partido</h2>

     
        <?php if ($mensaje): ?>
            <div class="alert alert-info"><?= $mensaje ?></div>
        <?php endif; ?>

        <!-- Formulario para crear un partido -->
        <form method="POST">
            <div class="mb-3">
                <label for="equipo_local" class="form-label">Equipo Local</label>
                <input type="text" class="form-control" id="equipo_local" name="equipo_local" required>
            </div>
            <div class="mb-3">
                <label for="rival" class="form-label">Rival</label>
                <input type="text" class="form-control" id="rival" name="rival" required>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="mb-3">
                <label for="lugar" class="form-label">Lugar</label>
                <input type="text" class="form-control" id="lugar" name="lugar" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Partido</button>
        </form>

        <h3 class="mt-4">Partidos Programados</h3>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Equipo Local</th>
                    <th>Rival</th>
                    <th>Lugar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($partidos as $part): ?>
                    <tr>
                        <td><?= htmlspecialchars($part['fecha']) ?></td>
                        <td><?= htmlspecialchars($part['equipo_local']) ?></td>
                        <td><?= htmlspecialchars($part['rival']) ?></td>
                        <td><?= htmlspecialchars($part['lugar']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include '../includes/footer.php'; ?>
