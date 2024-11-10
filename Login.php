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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Iniciar Sesión</h2>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="login.php">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario:</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p>¿No tienes cuenta? <a href="paginas/Registro.php">Regístrate aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>