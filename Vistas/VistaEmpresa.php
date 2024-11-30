<?php
session_start();
include '../config.php';

$sql = "SELECT * FROM ofertas WHERE estado = 'disponible'";
$stmt = $pdo->query($sql);
$ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Empresa - La Cuponera SV</title>
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
        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        nav a:hover {
            text-decoration: underline;
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
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .cupon-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .cupon-table th, .cupon-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .cupon-table th {
            background-color: #f4f4f4;
        }
        .actions a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Panel de Empresa - La Cuponera SV</h1>
        <nav>
            <a href="Estadisticas.php">Estadísticas</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Gestión de Ofertas</h2>
            <a href="Cupones.php">Cupones</a>
            <?php if (empty($cupones)): ?>
                <p>No hay cupones disponibles en este momento.</p>
            <?php else: ?>
                <table class="cupon-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Precio Regular</th>
                            <th>Precio Oferta</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Límite Canje</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cupones as $cupon): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($cupon['titulo']); ?></td>
                                <td>$<?php echo number_format($cupon['precio_regular'], 2); ?></td>
                                <td>$<?php echo number_format($cupon['precio_oferta'], 2); ?></td>
                                <td><?php echo htmlspecialchars($cupon['fecha_inicio']); ?></td>
                                <td><?php echo htmlspecialchars($cupon['fecha_fin']); ?></td>
                                <td><?php echo htmlspecialchars($cupon['fecha_limite']); ?></td>
                                <td><?php echo htmlspecialchars($cupon['cantidad_cupones'] ?? 'Sin límite'); ?></td>
                                <td><?php echo ($cupon['estado'] == 1) ? 'Disponible' : 'No Disponible'; ?></td>
                                <td class="actions">
                                    <a href="EditarCupon.php?id=<?php echo $cupon['id']; ?>">Editar</a>
                                    <a href="CambiarEstado.php?id=<?php echo $cupon['id']; ?>">Cambiar Estado</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>La Cuponera SV - Panel de Empresa - 2024</p>
    </footer>
</body>
</html>
