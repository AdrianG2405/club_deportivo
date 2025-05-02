<?php
require '../includes/db.php';
include '../includes/header.php';

$mensaje = "";

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $dni = trim($_POST['dni']);
    $categoria = $_POST['categoria'];
    $telefono_padre = trim($_POST['telefono_padre']);
    $email_padre = trim($_POST['email_padre']);
    $cuenta = trim($_POST['cuenta']);

    // Validación básica
    if (empty($nombre) || empty($apellidos) || empty($dni) || empty($categoria) || empty($telefono_padre) || empty($email_padre) || empty($cuenta)) {
        $mensaje = "<div class='alert alert-danger'>Por favor, completa todos los campos.</div>";
    } else {
        // Insertar en la base de datos
        $stmt = $pdo->prepare("INSERT INTO jugadores (nombre, apellido, dni, categoria, telefono_padre, email_padre, cuenta_bancaria) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $exito = $stmt->execute([$nombre, $apellidos, $dni, $categoria, $telefono_padre, $email_padre, $cuenta]);

        if ($exito) {
            $mensaje = "<div class='alert alert-success'>Jugador registrado correctamente.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Hubo un error al registrar al jugador.</div>";
        }
    }
}
?>

<div class="container mt-5">
    <h2>Registro de Jugador</h2>
    <?= $mensaje ?>

    <form method="POST">
        <div class="mb-3">
            <label>Nombre del jugador</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Apellidos del jugador</label>
            <input type="text" name="apellidos" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>DNI del jugador</label>
            <input type="text" name="dni" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Categoría</label>
            <select name="categoria" class="form-select" required>
                <option value="">Selecciona</option>
                <option value="Prebenjamín">Prebenjamín</option>
                <option value="Benjamín">Benjamín</option>
                <option value="Alevín">Alevín</option>
                <option value="Infantil">Infantil</option>
                <option value="Cadete">Cadete</option>
                <option value="Juvenil">Juvenil</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Teléfono del padre</label>
            <input type="tel" name="telefono_padre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email del padre</label>
            <input type="email" name="email_padre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Número de cuenta (IBAN)</label>
            <input type="text" name="cuenta" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar jugador</button>
    </form>
</div>

</body>
</html>
<?php include '../includes/footer.php'; ?>
