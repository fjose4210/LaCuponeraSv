<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sqlAdmin = "SELECT * FROM administradores WHERE usuario = :usuario";
    $stmtAdmin = $pdo->prepare($sqlAdmin);
    $stmtAdmin->execute([':usuario' => $usuario]);
    $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);
    
    if ($admin && hash('sha256', $password) === $admin['password']) {
        $_SESSION['usuario_id'] = $admin['id'];
        $_SESSION['rol'] = 'admin';
        $_SESSION['usuario'] = $admin['usuario'];
        header("Location: Vistas/VistaAdmin.php");
        exit;
    }

    $sqlUsuario = "SELECT * FROM usuarios WHERE usuario = :usuario";
    $stmtUsuario = $pdo->prepare($sqlUsuario);
    $stmtUsuario->execute([':usuario' => $usuario]);
    $user = $stmtUsuario->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['rol'] = 'usuario';
        $_SESSION['usuario'] = $user['usuario'];
        header("Location: Vistas/VistaUsuario.php");
        exit;
    }

    $sqlEmpresa = "SELECT * FROM empresas WHERE usuario = :usuario";
    $stmtEmpresa = $pdo->prepare($sqlEmpresa);
    $stmtEmpresa->execute([':usuario' => $usuario]);
    $empresa = $stmtEmpresa->fetch(PDO::FETCH_ASSOC);

    if ($empresa && password_verify($password, $empresa['password'])) {
        $_SESSION['usuario_id'] = $empresa['id'];
        $_SESSION['rol'] = 'empresa';
        $_SESSION['usuario'] = $empresa['usuario'];
        header("Location: Vistas/VistaEmpresa.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
        }
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .login-title {
            color: #333;
        }
        .form-label, .form-control {
            color: #555;
        }
        .btn-dark {
            background-color: #444;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="text-center login-title mb-4">Iniciar Sesión</h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-dark w-100">Iniciar Sesión</button>
        </form>
        
        <p class="text-center mt-3">¿No tienes cuenta? <a href="paginas/Registro.php">Regístrate aquí</a></p>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-secondary">Volver a la página de inicio</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
