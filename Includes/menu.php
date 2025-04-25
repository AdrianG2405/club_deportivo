<?php 
session_start();

// Verifica si el usuario ha iniciado sesión
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    // Datos de inicio de sesión (usuario y contraseña)
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Datos de usuario y contraseña fijos (esto lo puedes cambiar según tu base de datos)
    if ($usuario === 'admin' && $contrasena === 'admin123') {
        $_SESSION['usuario'] = [
            'nombre' => 'Administrador',
            'rol' => 'administrador'
        ];
        header("Location: index.php");
        exit;
    } elseif ($usuario === 'entrenador' && $contrasena === 'entrenador123') {
        $_SESSION['usuario'] = [
            'nombre' => 'Entrenador',
            'rol' => 'entrenador'
        ];
        header("Location: index.php");
        exit;
    } elseif ($usuario === 'padre' && $contrasena === 'padre123') {
        $_SESSION['usuario'] = [
            'nombre' => 'Padre',
            'rol' => 'padre'
        ];
        header("Location: index.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

// Si el usuario no ha iniciado sesión, redirige al login
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Comienza la parte de la visualización de la página
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Club Deportivo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Club Deportivo</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <?php if ($_SESSION['usuario']['rol'] === 'administrador'): ?>
                            <li class="nav-item"><a class="nav-link" href="admin.php">Administrador</a></li>
                        <?php elseif ($_SESSION['usuario']['rol'] === 'entrenador'): ?>
                            <li class="nav-item"><a class="nav-link" href="entrenador.php">Entrenador</a></li>
                        <?php elseif ($_SESSION['usuario']['rol'] === 'padre'): ?>
                            <li class="nav-item"><a class="nav-link" href="padre.php">Padre</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link" href="?logout=true">Cerrar sesión</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="index.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="container mt-5">
        <h1 class="text-center">Bienvenido a la Escuela de Fútbol</h1>
        
        <?php if (!isset($_SESSION['usuario'])): ?>
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center mb-4">Iniciar Sesión</h4>
                    <?php if (isset($error)): ?>
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
        <?php else: ?>
            <p class="text-center">Bienvenido, <?= $_SESSION['usuario']['nombre'] ?>! Elige una de las opciones del menú según tu rol.</p>
        <?php endif; ?>
    </div>

</body>
</html>
