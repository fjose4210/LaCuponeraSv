<?php
session_start();
include '../config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "
    SELECT 
        c.id AS carrito_id,
        o.titulo, 
        o.precio_oferta, 
        c.cantidad, 
        (o.precio_oferta * c.cantidad) AS total
    FROM carrito c
    INNER JOIN ofertas o ON c.oferta_id = o.id
    WHERE c.usuario_id = :usuario_id
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['usuario_id' => $usuario_id]);
$carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Carrito de Compras</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Oferta</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carrito as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['titulo']); ?></td>
                    <td>$<?php echo number_format($item['precio_oferta'], 2); ?></td>
                    <td><?php echo htmlspecialchars($item['cantidad']); ?></td>
                    <td>$<?php echo number_format($item['total'], 2); ?></td>
                    <td>
                        <a href="eliminar.php?carrito_id=<?php echo $item['carrito_id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<form action="finalizar.php" method="POST">
    <h2>Finalizar Compra</h2>
    <label>Número de Tarjeta:</label>
    <input type="text" name="numero_tarjeta" required><br>
    <label>Fecha de Vencimiento:</label>
    <input type="month" name="fecha_vencimiento" required><br>
    <label>CVV:</label>
    <input type="text" name="cvv" required><br>
    <button type="submit">Confirmar Compra</button>
</form>
</body>
</html>
