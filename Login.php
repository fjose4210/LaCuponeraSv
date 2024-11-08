<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sqlUsuario = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $stmtUsuario = $pdo->prepare($sqlUsuario);
    $stmtUsuario->execute([':usuario' => $usuario]);
    $user = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['rol'] = 'usuario';  
        header("Location: index.php");
        exit;
    }

    $sqlEmpresa = "SELECT * FROM empresas WHERE usuario = :usuario";
    $stmtEmpresa = $pdo->prepare($sqlEmpresa);
    $stmtEmpresa->execute([':usuario' => $usuario]);
    $empresa = $stmtEmpresa->fetch(PDO::FETCH_ASSOC);

    if ($empresa && password_verify($password, $empresa['password'])) {
        $_SESSION['empresa_id'] = $empresa['id'];
        $_SESSION['rol'] = 'empresa'; 
        header("Location: index.php");
        exit;
    }

    $sqlAdmin = "SELECT * FROM administradores WHERE usuario = :usuario";
    $stmtAdmin = $pdo->prepare($sqlAdmin);
    $stmtAdmin->execute([':usuario' => $usuario]);
    $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['rol'] = 'admin';
        header("Location: index.php");
        exit;
    }

    $error = "Usuario o contraseña incorrectos";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST" action="login.php">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Iniciar Sesión</button>
    </form>
    
    <p>¿No tienes cuenta? <a href="paginas/Registro.php">Regístrate aquí</a></p>
</body>
</html>
