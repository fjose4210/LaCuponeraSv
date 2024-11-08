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
</head>
<body>
    <h1>Registrarse en La Cuponera SV</h1>
    <p>Elige el tipo de cuenta:</p>
    
    <form action="Registros.php" method="post">
        <label>
            <input type="radio" name="tipo_cuenta" value="usuario" required> Soy Comprador
        </label><br>
        <label>
            <input type="radio" name="tipo_cuenta" value="empresa" required> Soy Empresa Ofertante
        </label><br><br>
        <button type="submit">Continuar</button>
    </form>
</body>
</html>
