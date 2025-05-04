<?php
require '../includes/db.php';
include '../includes/header.php';


$mensaje = '';
$categorias = $pdo->query("SELECT DISTINCT categoria FROM jugadores")->fetchAll(PDO::FETCH_COLUMN);
$jugadores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = $_POST['categoria'] ?? '';
    $jugador_id = $_POST['jugador_id'] ?? '';

    if ($categoria && $jugador_id) {
        // Buscar el próximo partido de esa categoría
        $stmt = $pdo->prepare("SELECT * FROM partidos WHERE categoria = ? AND fecha >= CURDATE() ORDER BY fecha ASC LIMIT 1");
        $stmt->execute([$categoria]);
        $partido = $stmt->fetch();

        if ($partido) {
            // Verificar convocatoria
            $stmt = $pdo->prepare("SELECT titular FROM convocatorias WHERE partido_id = ? AND jugador_id = ?");
            $stmt->execute([$partido['id'], $jugador_id]);
            $convocatoria = $stmt->fetch();

            if ($convocatoria) {
                $mensaje = "Estás convocado " . ($convocatoria['titular'] ? "como <strong>titular</strong>." : "como <strong>suplente</strong>.");
            } else {
                $mensaje = "No estás convocado para el próximo partido.";
            }
        } else {
            $mensaje = "No hay partidos programados para esta categoría.";
        }
    }
}


if (!empty($_POST['categoria'])) {
    $stmt = $pdo->prepare("SELECT id, nombre, apellido FROM jugadores WHERE categoria = ? ORDER BY nombre, apellido");
    $stmt->execute([$_POST['categoria']]);
    $jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container mt-4">
    <h3>Consulta tu Convocatoria</h3>

    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="categoria" class="form-label">Selecciona tu categoría:</label>
            <select name="categoria" id="categoria" class="form-select" onchange="this.form.submit()" required>
                <option value="">-- Elige una categoría --</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= isset($_POST['categoria']) && $_POST['categoria'] === $cat ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php if (!empty($jugadores)): ?>
            <div class="mb-3">
                <label for="jugador_id" class="form-label">Selecciona tu nombre:</label>
                <select name="jugador_id" id="jugador_id" class="form-select" required>
                    <option value="">-- Elige tu nombre --</option>
                    <?php foreach ($jugadores as $jugador): ?>
                        <option value="<?= $jugador['id'] ?>" <?= isset($_POST['jugador_id']) && $_POST['jugador_id'] == $jugador['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($jugador['nombre'] . ' ' . $jugador['apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Consultar Convocatoria</button>
        <?php endif; ?>
    </form>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>
</div>
