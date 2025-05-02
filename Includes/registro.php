<?php
session_start();
require '../includes/db.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['usuario']); // el input sigue llamándose 'usuario'
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    if (empty($username) || empty($contrasena) || empty($rol)) {
        echo "<div class='container mt-4 alert alert-danger'>Por favor, completa todos los campos.</div>";
    } else {
        // Hashear la contraseña
        $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

        // Insertar en base de datos usando la columna 'username'
        $stmt = $pdo->prepare("INSERT INTO usuarios (username, password, rol) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $contrasenaHash, $rol])) {
            echo "<div class='container mt-4 alert alert-success'>Cuenta creada exitosamente. Ahora puedes iniciar sesión.</div>";
            header("Location: login.php");
            exit;
        } else {
            echo "<div class='container mt-4 alert alert-danger'>Hubo un problema al registrar tu cuenta. Intenta de nuevo.</div>";
        }
    }
}
?>

<!-- Formulario de registro -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Crear una cuenta</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" name="contrasena" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select name="rol" class="form-control" required>
                    <option value="padre">Padre</option>
                    <option value="entrenador">Entrenador</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>

        <div class="mt-3">
            <a href="login.php" class="btn btn-secondary">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
</body>
</html>
<?php include '../includes/footer.php'; ?>
