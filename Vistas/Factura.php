<?php
// Conexión a la base de datos
require '../config.php';

if (!isset($_GET['codigo'])) {
    die('Código no proporcionado.');
}

$codigo = $_GET['codigo'];

$query = $pdo->prepare("
    SELECT 
        c.fecha_compra, 
        o.titulo AS oferta, 
        COUNT(c.id) AS cantidad, 
        o.precio_oferta AS precio_unitario, 
        COUNT(c.id) * o.precio_oferta AS total, 
        IF(c.fecha_compra < o.fecha_limite, 'Canjeado', 'Expirado') AS estado, 
        c.codigo 
    FROM cupones c
    INNER JOIN ofertas o ON c.oferta_id = o.id
    WHERE c.codigo = :codigo
    GROUP BY o.id, c.codigo
    ORDER BY c.fecha_compra DESC
");
$query->execute(['codigo' => $codigo]);

$factura = $query->fetch(PDO::FETCH_ASSOC);

if (!$factura) {
    die('Factura no encontrada.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
</head>
<body>
    <h1>Factura</h1>
    <p><strong>Fecha de Compra:</strong> <?php echo htmlspecialchars($factura['fecha_compra']); ?></p>
    <p><strong>Oferta:</strong> <?php echo htmlspecialchars($factura['oferta']); ?></p>
    <p><strong>Cantidad:</strong> <?php echo htmlspecialchars($factura['cantidad']); ?></p>
    <p><strong>Precio Unitario:</strong> $<?php echo number_format($factura['precio_unitario'], 2); ?></p>
    <p><strong>Total:</strong> $<?php echo number_format($factura['total'], 2); ?></p>
    <p><strong>Estado:</strong> <?php echo htmlspecialchars($factura['estado']); ?></p>
    <p><strong>Código:</strong> <?php echo htmlspecialchars($factura['codigo']); ?></p>
    <a href="historial_compras.php">Volver al Historial</a>
</body>
</html>
