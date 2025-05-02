<?php
session_start();
require '../includes/db.php'; // Asegúrate de que esta ruta sea correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['password'];

    // Validar si el usuario existe
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$usuario]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($contrasena, $usuario['password'])) {
        // Guardar el usuario en la sesión
        $_SESSION['usuario'] = [
            'id' => $usuario['id'],
            'usuario' => $usuario['username'],
            'rol' => $usuario['rol'] // Guardamos el rol
        ];

        // Redirigir al panel correspondiente según el rol
        if ($usuario['rol'] === 'padre') {
            header("Location: ../administrar/padre.php");
        } elseif ($usuario['rol'] === 'entrenador') {
            header("Location: ../administrar/entrenador.php");
        } else {
            header("Location: ../index.php");
        }
        exit;
    } else {
        echo "<div class='alert alert-danger'>Usuario o contraseña incorrectos</div>";
    }
}
?>

<!-- Formulario de login -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 para notificaciones -->
    <script>
        // Función para validar el formulario de login
        function validarFormulario() {
            var usuario = document.getElementById('usuario').value;
            var contrasena = document.getElementById('password').value;

            if (usuario === "" || contrasena === "") {
                // Mostrar alerta de error si los campos están vacíos
                Swal.fire({
                    icon: 'error',
                    title: '¡Oops!',
                    text: 'Por favor, ingresa tanto el usuario como la contraseña.'
                });
                return false;
            }

            // Si todo está bien, se envía el formulario
            return true;
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Iniciar sesión</h2>
        <form method="POST" onsubmit="return validarFormulario()">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
        </form>

        <div class="mt-3">
            <a href="registro.php" class="btn btn-secondary">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>

</body>
</html>
<?php include '../includes/footer.php'; ?>
