<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipoCuenta = $_POST['tipo_cuenta'];
    
    if ($tipoCuenta === 'usuario') {
        header('Location: ../paginas/RegistroUsuario.php');
    } elseif ($tipoCuenta === 'empresa') {
        header('Location: ../paginas/RegistroEmpresa.php');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - La Cuponera SV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0; 
        }
        .registro-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff; 
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-check {
            display: flex;
            align-items: center;
            justify-content: center; 
            margin-bottom: 10px; 
        }
        .form-check-label {
            margin-left: 10px; 
        }
    </style>
</head>
<body>
    <div class="registro-container">
        <h1 class="text-center mb-4">Registrarse en La Cuponera SV</h1>
        <p class="text-center">Elige el tipo de cuenta:</p>
        
        <form action="Registro.php" method="post" class="text-center mb-3">
            <div class="d-flex flex-column align-items-center">
                <div class="form-check w-100 d-flex justify-content-center">
                    <input type="radio" class="form-check-input" id="usuario" name="tipo_cuenta" value="usuario" required>
                    <label class="form-check-label" for="usuario">Soy Comprador</label>
                </div>
                <div class="form-check w-100 d-flex justify-content-center">
                    <input type="radio" class="form-check-input" id="empresa" name="tipo_cuenta" value="empresa" required>
                    <label class="form-check-label" for="empresa">Soy Empresa Ofertante</label>
                </div>
            </div>
            <button type="submit" class="btn btn-dark btn-custom mt-3">Continuar</button>
        </form>

        <div class="text-center">
            <a href="../index.php" class="btn btn-secondary">Volver a la página principal</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
