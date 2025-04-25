<?php
session_start();

$error = "";

// Validación del formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Usuario y contraseña fijos
    if ($usuario === 'admin' && $contrasena === 'admin123') {
        $_SESSION['usuario'] = [
            'nombre' => 'Administrador',
            'rol' => 'admin'
        ];
        header("Location: ../index.php");
        exit;
    } elseif ($usuario === 'entrenador' && $contrasena === 'entrenador123') {
        $_SESSION['usuario'] = [
            'nombre' => 'Entrenador',
            'rol' => 'entrenador'
        ];
        header("Location: ../administrar/asistencia.php");
        exit;
    } else {
        $error = "⚠️ Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Club Deportivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 400px;">
    <div class="card shadow">
        <div class="card-body">
            <h4 class="text-center mb-4">Iniciar Sesión</h4>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="usuario" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" name="contrasena" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
