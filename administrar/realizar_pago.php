<?php
require '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $jugador_id = $_POST['jugador_id'] ?? null;
    $cantidad = $_POST['cantidad'] ?? null;
    $cuenta = $_POST['cuenta'] ?? null;

    // Validaciones básicas
    if ($jugador_id && $cantidad > 0 && !empty($cuenta)) {
        // Registrar el pago simulado
        $stmt = $pdo->prepare("INSERT INTO pagos (jugador_id, monto, concepto, fecha_pago) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$jugador_id, $cantidad, "Pago simulado desde cuenta: " . htmlspecialchars($cuenta)]);

        // Redirigir de nuevo a la página de pagos con mensaje
        header("Location: pagos.php?success=1");
        exit;
    } else {
        // Redirigir con error
        header("Location: pagos.php?error=1");
        exit;
    }
} else {
    header("Location: pagos.php");
    exit;
}
