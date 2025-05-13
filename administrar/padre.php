<?php
require '../includes/db.php';
include '../includes/header.php';

// Obtener la lista de equipos disponibles
$equipos_stmt = $pdo->query("SELECT DISTINCT equipo FROM jugadores WHERE equipo IS NOT NULL ORDER BY equipo");
$equipos = $equipos_stmt->fetchAll(PDO::FETCH_COLUMN);

// Obtener todos los jugadores y sus estados, organizados por equipo
$jugadores_stmt = $pdo->query("
    SELECT j.id, j.nombre, j.apellido, j.equipo, ej.tipo, ej.descripcion, ej.fecha_inicio, ej.fecha_fin
    FROM jugadores j
    LEFT JOIN estado_jugador ej ON j.id = ej.jugador_id
    WHERE j.equipo IS NOT NULL
");
$jugadores_por_equipo = [];
while ($row = $jugadores_stmt->fetch(PDO::FETCH_ASSOC)) {
    $jugadores_por_equipo[$row['equipo']][] = [
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'apellido' => $row['apellido'],
        'tipo' => $row['tipo'],
        'descripcion' => $row['descripcion'],
        'fecha_inicio' => $row['fecha_inicio'],
        'fecha_fin' => $row['fecha_fin']
    ];
}

// Inicializar variables
$jugadorSeleccionado = null;
$estadoJugador = null;
$proximoPartido = null;
$estadisticas = [];

// Procesar la selección del jugador
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['jugador_id'])) {
    $jugadorId = $_POST['jugador_id'];

    // Obtener información del jugador
    $stmt = $pdo->prepare("
        SELECT j.nombre, j.apellido, j.categoria, ej.tipo, ej.descripcion, ej.fecha_inicio, ej.fecha_fin
        FROM jugadores j
        LEFT JOIN estado_jugador ej ON j.id = ej.jugador_id
        WHERE j.id = ?
    ");
    $stmt->execute([$jugadorId]);
    $jugadorSeleccionado = $stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener el próximo partido del jugador
    $proximo_partido_stmt = $pdo->prepare("
        SELECT p.fecha, p.rival, p.lugar
        FROM convocatorias c
        JOIN partidos p ON c.partido_id = p.id
        WHERE c.jugador_id = ? AND p.fecha >= CURDATE()
        ORDER BY p.fecha ASC
        LIMIT 1
    ");
    $proximo_partido_stmt->execute([$jugadorId]);
    $proximoPartido = $proximo_partido_stmt->fetch(PDO::FETCH_ASSOC);

    // Obtener las estadísticas del jugador
    $estadisticas_stmt = $pdo->prepare("
        SELECT p.fecha, p.rival, p.lugar, p.resultado, c.titular
        FROM convocatorias c
        JOIN partidos p ON c.partido_id = p.id
        WHERE c.jugador_id = ?
        ORDER BY p.fecha DESC
    ");
    $estadisticas_stmt->execute([$jugadorId]);
    $estadisticas = $estadisticas_stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container mt-4">
    <h2>Consulta de Información del Jugador</h2>

    <form method="POST" class="mb-4" style="max-width: 600px;">
        <div class="mb-3">
            <label for="equipo">Selecciona el equipo</label>
            <select id="equipo" class="form-select" required>
                <option value="">-- Selecciona un equipo --</option>
                <?php foreach ($equipos as $equipo): ?>
                    <option value="<?= htmlspecialchars($equipo) ?>"><?= htmlspecialchars($equipo) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="jugador">Selecciona el jugador</label>
            <select name="jugador_id" id="jugador" class="form-select" required>
                <option value="">-- Selecciona un jugador --</option>
                <!-- Las opciones se cargarán dinámicamente mediante JavaScript -->
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <?php if ($jugadorSeleccionado): ?>
        <div class="card mb-4">
            <div class="card-header">
                <strong><?= htmlspecialchars($jugadorSeleccionado['nombre']) ?> <?= htmlspecialchars($jugadorSeleccionado['apellido']) ?> (<?= htmlspecialchars($jugadorSeleccionado['categoria']) ?>)</strong>
            </div>
            <div class="card-body">
                <h5>Estado Actual</h5>
                <?php if ($jugadorSeleccionado['tipo']): ?>
                    <p><strong>Tipo:</strong> <?= htmlspecialchars($jugadorSeleccionado['tipo']) ?></p>
                    <p><strong>Descripción:</strong> <?= htmlspecialchars($jugadorSeleccionado['descripcion']) ?></p>
                    <p><strong>Desde:</strong> <?= htmlspecialchars($jugadorSeleccionado['fecha_inicio']) ?></p>
                    <p><strong>Hasta:</strong> <?= htmlspecialchars($jugadorSeleccionado['fecha_fin']) ?></p>
                <?php else: ?>
                    <p>Este jugador no tiene estados registrados.</p>
                <?php endif; ?>

                <h5 class="mt-4">Próximo Partido</h5>
                <?php if ($proximoPartido): ?>
                    <p><strong>Fecha:</strong> <?= htmlspecialchars($proximoPartido['fecha']) ?></p>
                    <p><strong>Rival:</strong> <?= htmlspecialchars($proximoPartido['rival']) ?></p>
                    <p><strong>Lugar:</strong> <?= htmlspecialchars($proximoPartido['lugar']) ?></p>
                <?php else: ?>
                    <p>No hay próximos partidos programados.</p>
                <?php endif; ?>

                <h5 class="mt-4">Estadísticas</h5>
                <?php if (!empty($estadisticas)): ?>
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
                            <?php foreach ($estadisticas as $est): ?>
                                <tr>
                                    <td><?= htmlspecialchars($est['fecha']) ?></td>
                                    <td><?= htmlspecialchars($est['rival']) ?></td>
                                    <td><?= htmlspecialchars($est['lugar']) ?></td>
                                    <td><?= $est['titular'] ? 'Sí' : 'No' ?></td>
                                    <td><?= htmlspecialchars($est['resultado'] ?? '—') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No hay estadísticas disponibles.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// Datos de jugadores por equipo generados desde PHP
const jugadoresPorEquipo = <?php echo json_encode($jugadores_por_equipo); ?>;

document.addEventListener('DOMContentLoaded', function () {
    const equipoSelect = document.getElementById('equipo');
    const jugadorSelect = document.getElementById('jugador');

    equipoSelect.addEventListener('change', function () {
        const equipoSeleccionado = this.value;

        // Limpiar las opciones actuales
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
