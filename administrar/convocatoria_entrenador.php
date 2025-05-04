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
            $partido_id = $partido['id'];

            if (isset($_POST['guardar'])) {
                // Se guarda la convocatoria
        
                $pdo->prepare("DELETE FROM convocatorias WHERE partido_id = ? AND jugador_id = ?")->execute([$partido_id, $jugador_id]);

                if (isset($_POST['convocado'])) {
                    $titular = isset($_POST['titular']) ? 1 : 0;
                    $stmt = $pdo->prepare("INSERT INTO convocatorias (partido_id, jugador_id, titular) VALUES (?, ?, ?)");
                    $stmt->execute([$partido_id, $jugador_id, $titular]);
                    $mensaje = "Convocatoria guardada correctamente.";
                } else {
                    $mensaje = "El jugador no fue convocado.";
                }
            } else {
                // consultarconvocatoria
                $stmt = $pdo->prepare("SELECT titular FROM convocatorias WHERE partido_id = ? AND jugador_id = ?");
                $stmt->execute([$partido_id, $jugador_id]);
                $convocatoria = $stmt->fetch();

                if ($convocatoria) {
                    $mensaje = "Estás convocado " . ($convocatoria['titular'] ? "como <strong>titular</strong>." : "como <strong>suplente</strong>.");
                } else {
                    $mensaje = "No estás convocado para el próximo partido.";
                }
            }
        } else {
            $mensaje = "No hay partidos programados para esta categoría.";
        }
    }
}

// Carga jugadores 
if (!empty($_POST['categoria'])) {
    $stmt = $pdo->prepare("SELECT id, nombre, apellido FROM jugadores WHERE categoria = ? ORDER BY nombre, apellido");
    $stmt->execute([$_POST['categoria']]);
    $jugadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container mt-4">
    <h3>Convocar Jugador Manualmente</h3>

    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label for="categoria" class="form-label">Selecciona una categoría:</label>
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
                <label for="jugador_id" class="form-label">Selecciona un jugador:</label>
                <select name="jugador_id" id="jugador_id" class="form-select" required>
                    <option value="">-- Elige un jugador --</option>
                    <?php foreach ($jugadores as $jugador): ?>
                        <option value="<?= $jugador['id'] ?>" <?= isset($_POST['jugador_id']) && $_POST['jugador_id'] == $jugador['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($jugador['nombre'] . ' ' . $jugador['apellido']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="convocado" id="convocado">
                <label class="form-check-label" for="convocado">Convocado</label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="titular" id="titular">
                <label class="form-check-label" for="titular">Titular</label>
            </div>

            <button type="submit" name="guardar" class="btn btn-success">Guardar Convocatoria</button>
        <?php endif; ?>
    </form>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= $mensaje ?></div>
    <?php endif; ?>
</div>
