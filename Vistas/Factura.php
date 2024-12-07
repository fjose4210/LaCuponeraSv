<?php
session_start();
require '../config.php';

if (!isset($_GET['codigo'])) {
    die('Código no proporcionado.');
}

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Login.php");
    exit;
}

$codigo = $_GET['codigo'];
$usuario_id = $_SESSION['usuario_id'];

$query = $pdo->prepare("
    SELECT 
        c.fecha_compra, 
        o.titulo AS oferta, 
        COUNT(c.id) AS cantidad, 
        o.precio_oferta AS precio_unitario, 
        COUNT(c.id) * o.precio_oferta AS total, 
        c.estado, 
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

$sql_usuario = "SELECT nombre_completo, apellidos, dui, correo FROM usuarios Where id = $usuario_id";
$usuario_stmt = $pdo->prepare($sql_usuario);
$usuario_stmt->execute();
$usuario = $usuario_stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            color: #555;
        }

        .info {
            margin-bottom: 20px;
        }

        .info h3 {
            margin: 10px 0;
            color: #333;
        }

        .info p {
            margin: 5px 0;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f1f1f1;
            color: #333;
        }

        .total {
            text-align: right;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Factura de Compra</h1>
            <p>Gracias por tu compra</p>
        </div>

        <div class="info">
            <h3>Datos del Cliente</h3>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre_completo']); ?></p>
            <p><strong>DUI:</strong> <?php echo htmlspecialchars($usuario['dui']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($usuario['correo']); ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Fecha de Compra</th>
                    <th>Cupón</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($factura['fecha_compra']); ?></td>
                    <td><?php echo htmlspecialchars($factura['oferta']); ?></td>
                    <td><?php echo htmlspecialchars($factura['cantidad']); ?></td>
                    <td>$<?php echo number_format($factura['precio_unitario'], 2); ?></td>
                    <td>$<?php echo number_format($factura['total'], 2); ?></td>
                    <td><?php echo htmlspecialchars($factura['estado']); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            <p>Total a Pagar: $<?php echo number_format($factura['total'], 2); ?></p>
        </div>

        <a href="javascript:window.print()" class="btn">Imprimir Factura</a>
    </div>
</body>
</html>

