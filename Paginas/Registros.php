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
