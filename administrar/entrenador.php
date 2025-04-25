<?php
session_start();

// Verificar si el usuario está autenticado y tiene el rol de 'entrenador'
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'entrenador') {
    header("Location: ../include/login.php");
    exit;
}

// Incluir encabezado y menú
include '../include/header.php';  // Corregido
include '../include/menu.php';    // Corregido
require '../include/db.php';      // Corregido

$categoria = "Alevín"; // Esto puedes hacerlo dinámico si quieres

// Obtener entrenamientos y partidos de la categoría del entrenador
$entrenamientos = $pdo->prepare("SELECT * FROM entrenamientos WHERE categoria = ? ORDER BY fecha DESC");
$entrenamientos->execute([$categoria]);

$partidos = $pdo->prepare("SELECT * FROM partidos WHERE categoria = ? ORDER BY fecha DESC");
$partidos->execute([$categoria]);
?>

<div class="container mt-4">
    <h2>Panel del Entrenador</h2>

    <!-- Mostrar próximos entrenamientos -->
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

    <hr>

    <!-- Mostrar partidos -->
    <h4>Partidos</h4>
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

</body>
</html>
