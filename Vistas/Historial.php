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
        c.fecha_compra, 
        o.titulo AS oferta, 
        COUNT(c.id) AS cantidad, 
        o.precio_oferta AS precio_unitario, 
        COUNT(c.id) * o.precio_oferta AS total, 
        c.estado, 
        c.codigo 
    FROM cupones c
    INNER JOIN ofertas o ON c.oferta_id = o.id
    WHERE c.usuario_id = :usuario_id
    GROUP BY o.id, c.codigo
    ORDER BY c.fecha_compra DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute(['usuario_id' => $usuario_id]);
$compras = $stmt->fetchAll(PDO::FETCH_ASSOC);

$resumen_sql = "
    SELECT 
        COUNT(*) AS total_comprados, 
        SUM(CASE WHEN c.fecha_compra < o.fecha_limite THEN 1 ELSE 0 END) AS canjeados, 
        SUM(CASE WHEN c.fecha_compra >= o.fecha_limite THEN 1 ELSE 0 END) AS expirados
    FROM cupones c
    INNER JOIN ofertas o ON c.oferta_id = o.id
    WHERE c.usuario_id = :usuario_id
";
$resumen_stmt = $pdo->prepare($resumen_sql);
$resumen_stmt->execute(['usuario_id' => $usuario_id]);
$resumen = $resumen_stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras - La Cuponera SV</title>
    <style>
        table,th,td, tr{
            border: 1px solid black;
        }
        table{
            margin-left: auto;
            margin-right: auto;
            text-align: center;
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
        footer {
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        a {
            color: #f9f9f9;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        button{
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <header>
        <h1>La Cuponera SV</h1>
        <nav>
            <a href="VistaUsuario.php">Página Principal</a>
            <a href="CompraCupon.php">Carrito de Compras</a>
        </nav>
    </header>

    <main>
        <h2>Historial de Compras</h2>
        <section>
            <table border="1">
                <thead>
                    <tr>
                        <th>Fecha de Compra</th>
                        <th>Cupón</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Código</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($compras) > 0): ?>
                        <?php foreach ($compras as $compra): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($compra['fecha_compra']); ?></td>
                                <td><?php echo htmlspecialchars($compra['oferta']); ?></td>
                                <td><?php echo htmlspecialchars($compra['cantidad']); ?></td>
                                <td>$<?php echo number_format($compra['precio_unitario'], 2); ?></td>
                                <td>$<?php echo number_format($compra['total'], 2); ?></td>
                                <td><?php echo htmlspecialchars($compra['estado']); ?></td>
                                <td><?php echo htmlspecialchars($compra['codigo']); ?></td>
                                <td>
                                    <form action="factura.php" method="GET" style="display: inline;">
                                        <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($compra['codigo']); ?>">
                                        <button type="submit">Ver factura</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">No se encontraron compras en el historial.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h3>Resumen</h3>
            <p>Total de Cupones Comprados: <?php echo htmlspecialchars($resumen['total_comprados']); ?></p>
            <p>Cupones Canjeados: <?php echo htmlspecialchars($resumen['canjeados']); ?></p>
            <p>Cupones Expirados: <?php echo htmlspecialchars($resumen['expirados']); ?></p>
        </section>
    </main>

    <footer>
        <p>La Cuponera SV - 2024</p>
    </footer>
</body>
</html>
