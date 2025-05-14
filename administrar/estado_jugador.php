<?php
session_start();

// entrar en usuario de entrenador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'entrenador') {
    header("Location: ../includes/login.php");
    exit;
}

require '../includes/db.php';
include '../includes/header.php';

// formulario a base 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jugador_id'])) {
    $jugadorId = $_POST['jugador_id'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Insertar el estado del jugador en la base de datos
    $stmt = $pdo->prepare("INSERT INTO estado_jugador (jugador_id, tipo, descripcion, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$jugadorId, $tipo, $descripcion, $fecha_inicio, $fecha_fin]);

    echo "<div class='container mt-4 alert alert-success'>Estado registrado correctamente.</div>";
}

// Obtener la lista de equipos disponibles
$equipos_stmt = $pdo->query("SELECT DISTINCT equipo FROM jugadores WHERE equipo IS NOT NULL ORDER BY equipo");
$equipos = $equipos_stmt->fetchAll(PDO::FETCH_COLUMN);

// Obtener todos los jugadores
$jugadores_stmt = $pdo->query("SELECT id, nombre, apellido, equipo FROM jugadores WHERE equipo IS NOT NULL");
$jugadores_por_equipo = [];
while ($row = $jugadores_stmt->fetch(PDO::FETCH_ASSOC)) {
    $jugadores_por_equipo[$row['equipo']][] = [
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'apellido' => $row['apellido']
    ];
}
?>

<div class="container mt-5">
    <h2>Registrar Estado del Jugador</h2>

    <form method="POST" class="mb-3">
        <div class="mb-3">
            <label for="equipo" class="form-label">Selecciona un equipo:</label>
            <select id="equipo" name="equipo" class="form-select" required>
                <option value="">-- Selecciona un equipo --</option>
                <?php foreach ($equipos as $equipo): ?>
                    <option value="<?= htmlspecialchars($equipo) ?>"><?= htmlspecialchars($equipo) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jugador_id" class="form-label">Selecciona un jugador:</label>
            <select id="jugador_id" name="jugador_id" class="form-select" required>
                <option value="">-- Selecciona un jugador --</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Estado:</label>
            <select name="tipo" class="form-select" required>
                <option value="lesión">Lesión</option>
                <option value="sanción">Sanción</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha de Inicio:</label>
            <input type="date" name="fecha_inicio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="fecha_fin" class="form-label">Fecha de Fin:</label>
            <input type="date" name="fecha_fin" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Estado</button>
    </form>

    <a href="entrenador.php" class="btn btn-secondary">Volver al panel</a>
</div>

<script>
// Datos de jugadores por equipo
const jugadoresPorEquipo = <?php echo json_encode($jugadores_por_equipo); ?>;

document.addEventListener('DOMContentLoaded', function () {
    const equipoSelect = document.getElementById('equipo');
    const jugadorSelect = document.getElementById('jugador_id');

    equipoSelect.addEventListener('change', function () {
        const equipoSeleccionado = this.value;

        // Limpieza de datod
        jugadorSelect.innerHTML = '<option value="">-- Selecciona un jugador --</option>';

        if (equipoSeleccionado && jugadoresPorEquipo[equipoSeleccionado]) {
            jugadoresPorEquipo[equipoSeleccionado].forEach(jugador => {
                const option = document.createElement('option');
                option.value = jugador.id;
                option.textContent = jugador.nombre + ' ' + jugador.apellido;
                jugadorSelect.appendChild(option);
            });
        }
    });
});
</script>

</body>
</html>

<?php include '../includes/footer.php'; ?>
