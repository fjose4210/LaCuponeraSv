<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <form action="ProcesoRegistroUsuario.php" method="POST">
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
