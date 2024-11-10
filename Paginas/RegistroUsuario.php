<?php
include '../config.php';
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $nombre_completo = $_POST['nombre_completo'];
    $apellidos = $_POST['apellidos'];
    $dui = $_POST['dui'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    $fecha_nacimiento_obj = new DateTime($fecha_nacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nacimiento_obj)->y;

    if ($edad < 18) {
        $mensaje = "Debes ser mayor de 18 años para registrarte.";
    } else {
        $sql = "INSERT INTO usuarios (usuario, correo, password, nombre_completo, apellidos, dui, fecha_nacimiento) 
                VALUES (:usuario, :correo, :password, :nombre_completo, :apellidos, :dui, :fecha_nacimiento)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':usuario' => $usuario,
                ':correo' => $correo,
                ':password' => $password,
                ':nombre_completo' => $nombre_completo,
                ':apellidos' => $apellidos,
                ':dui' => $dui,
                ':fecha_nacimiento' => $fecha_nacimiento
            ]);
            $mensaje = "Registro exitoso. Ahora puedes iniciar sesión.";
        } catch (PDOException $e) {
            $mensaje = "Error en el registro: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0; /* Fondo gris claro */
        }
        .registro-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff; /* Fondo blanco */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .button-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <script>
        function validarEdad() {
            var fechaNacimiento = new Date(document.getElementById("fecha_nacimiento").value);
            var hoy = new Date();
            var edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
            var mes = hoy.getMonth() - fechaNacimiento.getMonth();
            if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                edad--;
            }

            if (edad < 18) {
                alert("Debes ser mayor de 18 años para registrarte.");
                return false; // Evita el envío del formulario
            }
            return true;
        }
    </script>
</head>
<body>
    <div class="registro-container">
        <h2 class="text-center mb-4">Registro de Usuario</h2>
        <?php if ($mensaje): ?>
            <div class="alert alert-info text-center"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form action="RegistroUsuario.php" method="POST" onsubmit="return validarEdad()">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="nombre_completo" class="form-label">Nombre completo:</label>
                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="mb-3">
                <label for="dui" class="form-label">DUI:</label>
                <input type="text" class="form-control" id="dui" name="dui" required>
            </div>
            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento:</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-dark">Registrarse</button>
                <a href="../login.php" class="btn btn-secondary">Iniciar Sesión</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
