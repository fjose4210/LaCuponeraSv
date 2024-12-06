<?php
session_start();
include '../config.php';

if(!isset($_SESSION['usuario_id'])){
    header("Location: ../Login.php");
    exit;
}

$sql_total_producto = "select o.titulo as Oferta, f.monto as Precio, e.nombre as Empresa, COUNT(o.titulo) as Cantidad, 
                        (COUNT(o.titulo) * f.monto) as Total from facturas f
                        inner JOIN cupones c ON 
                        c.id = f.cupon_id
                        INNER JOIN ofertas o ON
                        c.oferta_id = o.id
                        INNER JOIN empresas e ON
                        e.id = o.empresa_id
                        GROUP BY o.titulo, e.nombre
";
$total_producto_stmt = $pdo->prepare($sql_total_producto);
$total_producto_stmt->execute();
$total_productos = $total_producto_stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_ganancias = "select o.titulo as Oferta, f.monto as Precio, e.nombre as Empresa, COUNT(o.titulo) as Cantidad, (COUNT(o.titulo) * f.monto) 
                    as Total, e.comision as Comision, (e.comision *COUNT(o.titulo) *f.monto) as Ganancias from facturas f
                    inner JOIN cupones c ON 
                    c.id = f.cupon_id
                    INNER JOIN ofertas o ON
                    c.oferta_id = o.id
                    INNER JOIN empresas e ON
                    e.id = o.empresa_id
                    GROUP BY o.titulo, e.nombre
";
$total_ganancias_stmt = $pdo->prepare($sql_ganancias);
$total_ganancias_stmt->execute();
$total_ganancias = $total_ganancias_stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_ventas_empresa = "SELECT e.nombre AS Empresa, COUNT(f.id) AS Cantidad, SUM(f.monto) AS Total
                        FROM 
                            facturas f
                        INNER JOIN 
                            cupones c ON c.id = f.cupon_id
                        INNER JOIN 
                            ofertas o ON c.oferta_id = o.id
                        INNER JOIN 
                            empresas e ON e.id = o.empresa_id
                        GROUP BY 
                            e.nombre
";
$total_ventas_empresas_stmt = $pdo->prepare($sql_ventas_empresa);
$total_ventas_empresas_stmt->execute();
$total_ventas_empresas = $total_ventas_empresas_stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_ganancia_empresa = "SELECT e.nombre AS Empresa, COUNT(f.id) AS Cantidad, e.comision AS Comision, (SUM(f.monto)* (1 - e.comision))  AS Ganancia
                            FROM 
                                facturas f
                            INNER JOIN 
                                cupones c ON c.id = f.cupon_id
                            INNER JOIN 
                                ofertas o ON c.oferta_id = o.id
                            INNER JOIN 
                                empresas e ON e.id = o.empresa_id
                            GROUP BY 
                                e.nombre;
";
$ganancia_empresa_stmt = $pdo->prepare($sql_ganancia_empresa);
$ganancia_empresa_stmt->execute();
$ganancia_empresa = $ganancia_empresa_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Cuponera SV - Cupones Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
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
        .reporte {
            display: none; 
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
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
        footer {
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        section h2{
            text-align: center;
        }
        button:hover{
            background-color: #e59347;
        }
        button{
            padding: 5px;
            border-radius: 5px;
            background-color: #f5bc75;
            border: none;
            cursor: pointer;
            margin-left: 10px;
            margin-right: 10px;
        }
        button:active{
            background-color: #e9763f;
        }
        .buttons{
            text-align: center;
        }
        .buttons h2{
            margin-top: 5px;
            margin-bottom: 15px;
        }
    </style>

    <script>
        function mostrarReporte(id) {
            document.querySelectorAll('.reporte').forEach((reporte) => {
                reporte.style.display = 'none';
            });

            document.getElementById(id).style.display = 'block';
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">La Cuponera SV</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="Pendientes.php">Aprobaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="buttons">
        <h2>Panel Administrativo</h2>
        <button onclick="mostrarReporte('cuponesVendidos')">Total de Cupones Vendidos</button>
        <button onclick="mostrarReporte('gananciasTotales')">Total de Ganancias Obtenidas</button>
        <button onclick="mostrarReporte('ventasEmpresa')">Total de Ventas por Empresa</button>
        <button onclick="mostrarReporte('gananciasEmpresa')">Total de Ganancias por Empresa</button>
    </section>

    <section id="cuponesVendidos" class="reporte">
        <h2>Total de Cupones Vendidos</h2>
        <table>
            <thead>
                <tr>
                    <th>Oferta</th>
                    <th>Precio</th>
                    <th>Empresa</th>
                    <th>Cantidad de Cupones</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($total_productos as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['Oferta']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['Precio']); ?></td>
                        <td><?php echo htmlspecialchars($item['Empresa']); ?></td>
                        <td><?php echo htmlspecialchars($item['Cantidad']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['Total']); ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>

    <section id="gananciasTotales" class="reporte">
        <h2>Total de Ganancias Obtenidas</h2>
        <table>
            <thead>
                <tr>
                    <th>Oferta</th>
                    <th>Precio</th>
                    <th>Empresa</th>
                    <th>Cantidad de Cupones</th>
                    <th>Total</th>
                    <th>Comisión</th>
                    <th>Ganancias</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($total_ganancias as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['Oferta']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['Precio']); ?></td>
                        <td><?php echo htmlspecialchars($item['Empresa']); ?></td>
                        <td><?php echo htmlspecialchars($item['Cantidad']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['Total']); ?></td>
                        <td><?php echo htmlspecialchars($item['Comision']); ?>%</td>
                        <td>$<?php echo number_format(htmlspecialchars($item['Ganancias'])); ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>

    <section id="ventasEmpresa" class="reporte">
        <h2>Total de Ventas por Empresa</h2>
        <table>
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Cantidad de Cupones</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($total_ventas_empresas as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['Empresa']); ?></td>
                        <td><?php echo htmlspecialchars($item['Cantidad']); ?></td>
                        <td>$<?php echo htmlspecialchars($item['Total']); ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>

    <section id="gananciasEmpresa" class="reporte">
        <h2>Total de Ganancias por Empresa</h2>
        <table>
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Cantidad de Cupones</th>
                    <th>Comisión</th>
                    <th>Ganancia</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ganancia_empresa as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['Empresa']); ?></td>
                        <td><?php echo htmlspecialchars($item['Cantidad']); ?></td>
                        <td><?php echo htmlspecialchars($item['Comision']); ?>%</td>
                        <td>$<?php echo number_format(htmlspecialchars($item['Ganancia'])); ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </section>

    <footer class="text-center mt-5">
        <p>La Cuponera SV - 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
