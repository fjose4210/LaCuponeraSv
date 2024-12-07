<?php
session_start();
include '../config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../Login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "
    SELECT 
        c.id AS carrito_id,
        o.titulo, 
        o.precio_oferta, 
        c.cantidad, 
        (o.precio_oferta * c.cantidad) AS total,
        o.cantidad_cupones
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            margin: 0;
            font-size: 1.5em;
        }
        table,th,td, tr{
            border: 1px solid black;
        }
        th, td{
            padding: 5px;
        }
        main {
            padding: 20px;
        }
        section {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table{
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .nav-link {
            color: #555;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Carrito de Compras</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="Historial.php">Historial de Compras</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
    <main>
        <section>
        <h2>Finalizar Compra</h2>
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
    <table>
        <thead>
            <tr>
                <th>Número de Tarjeta</th>
                <th>Fecha de Vencimiento</th>
                <th>CVV</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <br>
        <tbody>
            <tr>
                <td><input type="text" name="numero_tarjeta" required><br></td>
                <td><input type="date" name="fecha_vencimiento" required><br></td>
                <td><input type="text" name="cvv" required><br></td>
                <td><button type="submit">Confirmar Compra</button></td>
            </tr>
        </tbody>
    </table>
</form>
</section>
</main>
</body>
</html>
