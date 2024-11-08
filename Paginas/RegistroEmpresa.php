<?php
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $nit = $_POST['nit'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $contrasena = md5($_POST['contrasena']);
    $estado = 'esperando aprobación';

    $sql = "INSERT INTO empresas (nombre, nit, direccion, telefono, correo, usuario, contrasena, estado)
            VALUES (:nombre, :nit, :direccion, :telefono, :correo, :usuario, :contrasena, :estado)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':nit' => $nit,
        ':direccion' => $direccion,
        ':telefono' => $telefono,
        ':correo' => $correo,
        ':usuario' => $usuario,
        ':contrasena' => $contrasena,
        ':estado' => $estado
    ]);

    echo "Registro exitoso. Esperando aprobación del administrador.";
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empresa</title>
</head>
<body>
    <h2>Registro de Empresa</h2>
    <form action="RegistroEmpresa.php" method="POST">
        <label>Nombre de Empresa:</label><br>
        <input type="text" name="nombre" required><br>
        
        <label>NIT:</label><br>
        <input type="text" name="nit" required><br>
        
        <label>Dirección:</label><br>
        <input type="text" name="direccion" required><br>
        
        <label>Teléfono:</label><br>
        <input type="text" name="telefono" required><br>
        
        <label>Correo Electrónico:</label><br>
        <input type="email" name="correo" required><br>
        
        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br>
        
        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br>
        
        <input type="submit" value="Registrar Empresa">
    </form>
</body>
</html>