<?php
session_start();

// Verificar si el usuario está autenticado y tiene el rol de 'entrenador'
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'entrenador') {
    header("Location: ../include/login.php"); // Ajustado para que sea coherente con la estructura
    exit;
}

// Incluir encabezado y menú
include '../include/header.php';  // Ajustado
include '../include/menu.php';    // Ajustado
require '../include/db.php';      // Ajustado

// Obtener el ID del partido desde la URL
$partidoId = $_GET['partido_id'] ?? null;

if (!$partidoId) {
    echo "<div class='container mt-4 alert alert-danger'>No se ha seleccionado un partido.</div>";
    exit;
}

// Obtener los datos del partido
$stmt = $pdo->prepare("SELECT * FROM partidos WHERE id = ?");
$stmt->execute([$partidoId]);
$partido = $stmt->fetch();

if (!$partido) {
    echo "<div class='container mt-4 alert alert-danger'>Partido no encontrado.</div>";
    exit;
}

// Obtener jugadores por categoría del partido
$stmt = $pdo->prepare("SELECT * FROM jugadores WHERE categoria = ?");
$stmt->execute([$partido['categoria']]);
$jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Guardar convocatoria si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Eliminar las convocatorias anteriores para el mismo partido
    $pdo->prepare("DELETE FROM convocatorias WHERE partido_id = ?")->execute([$partidoId]);

    if (!empty($_POST['convocados'])) {
        foreach ($_POST['convocados'] as $jugadorId) {
            // Marcar como titular si está en la lista de titulares
            $titular = in_array($jugadorId, $_POST['titulares'] ?? []) ? 1 : 0;
            // Insertar nueva convocatoria
            $stmt = $pdo->prepare("INSERT INTO convocatorias (partido_id, jugador_id, titular) VALUES (?, ?, ?)");
            $stmt->execute([$partidoId, $jugadorId, $titular]);
        }
        echo "<div class='alert alert-success'>Convocatoria actualizada</div>";
    } else {
        echo "<div class='alert alert-warning'>No se seleccionaron jugadores.</div>";
    }
}
?>

<div class="container mt-4">
    <h3>Convocar jugadores para el partido</h3>
    <p><strong><?= $partido['fecha'] ?> | <?= $partido['rival'] ?> (<?= $partido['categoria'] ?>)</strong></p>

    <!-- Formulario para seleccionar jugadores convocados y titulares -->
    <form method="POST">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Convocado</th>
                    <th>Titular</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jugadores as $jugador): ?>
                    <tr>
                        <td><?= $jugador['nombre'] ?></td>
                        <td><input type="checkbox" name="convocados[]" value="<?= $jugador['id'] ?>"></td>
                        <td><input type="checkbox" name="titulares[]" value="<?= $jugador['id'] ?>"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Guardar Convocatoria</button>
    </form>
</div>

</body>
</html>
