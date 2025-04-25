<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && $pass === $usuario['password']) {
        $_SESSION['usuario'] = $usuario;

        // Redirigir según rol
        switch ($usuario['rol']) {
            case 'administrador':
                header("Location: pages/admin.php");
                break;
            case 'entrenador':
                header("Location: pages/entrenador.php");
                break;
            case 'padre':
                header("Location: pages/padre.php");
                break;
        }
        exit;
    } else {
        $error = "Credenciales incorrectas";
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Iniciar Sesión</h2>
    <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST" class="mt-4 mx-auto" style="max-width: 400px;">
        <div class="mb-3">
            <label for="email" class="form-label">Correo</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
</div>

</body>
</html>
