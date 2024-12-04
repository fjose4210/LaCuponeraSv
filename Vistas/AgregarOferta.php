<?php
session_start();
include '../config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empresa_id = $_SESSION['usuario_id'];
    $titulo = $_POST['titulo'];
    $precio_regular = $_POST['precio_regular'];
    $precio_oferta = $_POST['precio_oferta'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $fecha_limite = $_POST['fecha_limite'];
    $cantidad_cupones = isset($_POST['cantidad_cupones']) && $_POST['cantidad_cupones'] !== '' ? $_POST['cantidad_cupones'] : null;

    try {
        $sql = "INSERT INTO ofertas 
                (empresa_id, titulo, precio_regular, precio_oferta, fecha_inicio, fecha_fin, fecha_limite, cantidad_cupones, descripcion)
                VALUES (:empresa_id, :titulo, :precio_regular, :precio_oferta, :fecha_inicio, :fecha_fin, :fecha_limite, :cantidad_cupones, :descripcion)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':precio_regular', $precio_regular);
        $stmt->bindParam(':precio_oferta', $precio_oferta);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':fecha_limite', $fecha_limite);
        $stmt->bindParam(':cantidad_cupones', $cantidad_cupones, PDO::PARAM_INT);
        $stmt->bindParam(':descripcion', $_POST['descripcion']);

        if ($stmt->execute()) {
            $message = "Oferta agregada exitosamente.";
        } else {
            $message = "Error al agregar la oferta.";
        }
    } catch (PDOException $e) {
        $message = "Error en la base de datos: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Oferta</title>
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
        footer {
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        section {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        main {
            padding: 20px;
        }
        table,th,td, tr{
            border: 1px solid black;
        }
        th, td{
            padding: 5px;
        }
        table{
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

    </style>
</head>
<body>
<header>
    <h1>Panel de Empresa - La Cuponera SV</h1>
</header>
    <main>
        <section>
        <h1>Agregar Oferta</h1>
        <?php if (isset($message)) : ?>
            <script>alert("<?php echo $message; ?>"); window.location.href = 'VistaEmpresa.php';</script>
        <?php endif; ?>
        <table>
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
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <form method="POST">
                    <td><input type="text" id="titulo" name="titulo" required></td>
                    <td><input type="number" id="precio_regular" name="precio_regular" step="0.01" required></td>
                    <td><input type="number" id="precio_oferta" name="precio_oferta" step="0.01" required></td>
                    <td><input type="date" id="fecha_inicio" name="fecha_inicio" required></td>
                    <td><input type="date" id="fecha_fin" name="fecha_fin" required></td>
                    <td><input type="date" id="fecha_limite" name="fecha_limite" required></td>
                    <td><input type="number" id="cantidad_cupones" name="cantidad_cupones" placeholder="Sin límite"></td>
                    <td><textarea id="descripcion" name="descripcion"></textarea></td>
                    <td><button type="submit">Agregar</button></td>
                </tr>
            </tbody>
        </table>
        </section>
    </main>
    </form>
    <footer>
        <p>La Cuponera SV - Panel de Empresa - 2024</p>
    </footer>
</body>
</html>
