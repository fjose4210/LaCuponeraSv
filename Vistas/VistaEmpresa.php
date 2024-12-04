<?php
session_start();
include '../config.php';

$sql = "SELECT * FROM ofertas";
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
        table,th,td, tr{
            border: 1px solid black;
        }
        th, td{
            padding: 5px;
        }
        .oferta-table{
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <header>
        <h1>Panel de Empresa - La Cuponera SV</h1>
        <nav>
            <a href="AgregarOferta.php">Agregar Oferta</a>
            <a href="Estadisticas.php">Estadísticas</a>
            <a href="../logout.php">Cerrar Sesión</a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Gestión de Ofertas</h2>
            <?php if (empty($ofertas)): ?>
                <p>No hay ofertas disponibles en este momento.</p>
            <?php else: ?>
                <table class="oferta-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Precio Regular</th>
                            <th>Precio Oferta</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Límite Canje</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ofertas as $oferta): ?>
                            <tr>
                                <form class="edit-form" method="POST" action="ActualizarOferta.php">
                                    <td><input type="text" name="titulo" value="<?php echo htmlspecialchars($oferta['titulo']); ?>"></td>
                                    <td><input type="number" name="precio_regular" step="0.01" value="<?php echo htmlspecialchars($oferta['precio_regular']); ?>"></td>
                                    <td><input type="number" name="precio_oferta" step="0.01" value="<?php echo htmlspecialchars($oferta['precio_oferta']); ?>"></td>
                                    <td><input type="date" name="fecha_inicio" value="<?php echo htmlspecialchars($oferta['fecha_inicio']); ?>"></td>
                                    <td><input type="date" name="fecha_fin" value="<?php echo htmlspecialchars($oferta['fecha_fin']); ?>"></td>
                                    <td><input type="date" name="fecha_limite" value="<?php echo htmlspecialchars($oferta['fecha_limite']); ?>"></td>
                                    <td><input type="number" name="cantidad_cupones" value="<?php echo htmlspecialchars($oferta['cantidad_cupones'] ?? ''); ?>" 
                                    placeholder="Sin límite"></td>
                                    <td><input type="text" name="descripcion" value="<?php echo htmlspecialchars($oferta['descripcion']); ?>"></td>
                                    <td>
                                        <select name="estado">
                                            <option value="Disponible" <?php echo $oferta['estado'] === 'Disponible' ? 'selected' : ''; ?>>Disponible</option>
                                            <option value="No disponible" <?php echo $oferta['estado'] === 'No disponible' ? 'selected' : ''; ?>>No disponible</option>
                                        </select>
                                    </td>
                                    <td class="actions">
                                        <input type="hidden" name="id" value="<?php echo $oferta['id']; ?>">
                                        <button type="submit">Guardar</button>
                                    </td>
                                </form>
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
