<?php
include '../config.php';
$mensaje = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $nit = $_POST['nit'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $password = md5($_POST['password']);
    $estado = 'esperando aprobación'; 

    $sql = "INSERT INTO empresas (nombre, nit, direccion, telefono, correo, usuario, password, estado)
            VALUES (:nombre, :nit, :direccion, :telefono, :correo, :usuario, :password, :estado)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre' => $nombre,
        ':nit' => $nit,
        ':direccion' => $direccion,
        ':telefono' => $telefono,
        ':correo' => $correo,
        ':usuario' => $usuario,
        ':password' => $password,
        ':estado' => $estado
    ]);

    $mensaje = "Registro exitoso. Esperando aprobación del administrador.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0; 
        }
        .registro-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff; 
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .button-group {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="registro-container">
        <h2 class="text-center mb-4">Registro de Empresa</h2>
        <?php if ($mensaje): ?>
            <div class="alert alert-info text-center"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form action="RegistroEmpresa.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de Empresa:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="nit" class="form-label">NIT:</label>
                <input type="text" class="form-control" id="nit" name="nit" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-dark">Registrar Empresa</button>
                <a href="../login.php" class="btn btn-secondary">Iniciar Sesión</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
