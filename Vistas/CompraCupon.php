<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra de Cupón</title>
</head>
<body>
    <h1>Compra de Cupón</h1>
    <p>Título de la oferta</p>
    <form action=".php" method="POST">
        <label>Número de Tarjeta:</label>
        <input type="text" name="numero_tarjeta" required><br>
        <label>Fecha de Vencimiento:</label>
        <input type="month" name="fecha_vencimiento" required><br>
        <label>CVV:</label>
        <input type="text" name="cvv" required><br>
        <button type="submit">Comprar</button>
    </form>
</body>
</html>
