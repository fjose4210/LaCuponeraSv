<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empresa</title>
</head>
<body>
    <h2>Registro de Empresa</h2>
    <form action="ProcesoRegistroEmpresa.php" method="POST">
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