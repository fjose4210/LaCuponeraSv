<?php
include '../config.php';

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
        echo "Debes ser mayor de 18 años para registrarte.";
        exit;
    }

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
        echo "Registro exitoso. Ahora puedes iniciar sesión.";
    } catch (PDOException $e) {
        echo "Error en el registro: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form action="RegistroUsuario.php" method="POST">
        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br>

        <label>Correo electrónico:</label><br>
        <input type="email" name="correo" required><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br>

        <label>Nombre completo:</label><br>
        <input type="text" name="nombre_completo" required><br>

        <label>Apellidos:</label><br>
        <input type="text" name="apellidos" required><br>

        <label>DUI:</label><br>
        <input type="text" name="dui" required><br>

        <label>Fecha de nacimiento:</label><br>
        <input type="date" name="fecha_nacimiento" required><br>

        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
