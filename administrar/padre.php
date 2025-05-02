<?php
require '../includes/db.php';  // Conexión a la base de datos
include '../includes/header.php';  // Incluir encabezado

// Variable para almacenar el jugador encontrado
$jugadorEncontrado = null;

// Verificar si se ha enviado el formulario con el nombre y apellido del hijo
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];

    // Buscar al jugador por nombre y apellido
    $stmt = $pdo->prepare("SELECT * FROM jugadores WHERE nombre = ? AND apellido = ?");
    $stmt->execute([$nombre, $apellido]);
    $jugadorEncontrado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si el jugador existe, mostrar las estadísticas
    if ($jugadorEncontrado) {
        $jugadorId = $jugadorEncontrado['id'];

        // Obtener las convocatorias de partidos del jugador
        $convocatorias = $pdo->prepare("
            SELECT p.fecha, p.rival, p.lugar, p.resultado, c.titular
            FROM convocatorias c
            JOIN partidos p ON c.partido_id = p.id
            WHERE c.jugador_id = ?
            ORDER BY p.fecha DESC
        ");
        $convocatorias->execute([$jugadorId]);
    } else {
        $mensajeError = "No se encontró un jugador con ese nombre y apellido.";
    }
}

?>

<div class="container mt-4">
    <h2>Consulta de Estadísticas del Jugador</h2>

    <!-- Formulario para que el padre ingrese el nombre y apellido de su hijo -->
    <form method="POST" class="mb-4" style="max-width: 600px;">
        <div class="mb-3">
            <label for="nombre">Nombre del hijo</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="apellido">Apellido del hijo</label>
            <input type="text" name="apellido" id="apellido" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <!-- Mostrar mensaje de error si no se encuentra al jugador -->
    <?php if (isset($mensajeError)): ?>
        <div class="alert alert-danger"><?= $mensajeError ?></div>
    <?php endif; ?>

    <!-- Si se encontró al jugador, mostrar las estadísticas -->
    <?php if ($jugadorEncontrado): ?>
        <div class="card mb-4">
            <div class="card-header">
                <strong><?= $jugadorEncontrado['nombre'] ?> <?= $jugadorEncontrado['apellido'] ?> (<?= $jugadorEncontrado['categoria'] ?>)</strong>
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
                    <?php foreach ($convocatorias as $convocatoria): ?>
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
    <?php endif; ?>
</div>

</body>
</html>
<?php include '../includes/footer.php'; ?>
