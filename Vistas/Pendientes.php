<?php
include '../config.php';
session_start();


if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../Login.php");
    exit;
}

$sql = "SELECT * FROM empresas WHERE estado = 'En espera'";
$stmt = $pdo->query($sql);
$empresasPendientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../Login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empresa_id = $_POST['empresa_id'];
    $comision = $_POST['comision'];
    $estado = $_POST['estado']; // Estado puede ser 'Aprobada' o 'Desaprobada'

    try {
        $sql = "UPDATE empresas SET estado = :estado, comision = :comision WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':estado' => $estado,
            ':comision' => $comision,
            ':id' => $empresa_id
        ]);

        $mensaje = $estado === 'Aprobada' ? 'aprobada' : 'desaprobada';
        header("Location: Pendientes.php?mensaje=$mensaje");
        exit;
    } catch (PDOException $e) {
        die("Error al actualizar el estado de la empresa: " . $e->getMessage());
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empresas Pendientes de Aprobación - La Cuponera SV</title>
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
        .col-md-6{
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">La Cuponera SV</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="VistaAdmin.php">Panel de Administración</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="container mt-4">
        <h1 class="mb-4">Empresas Pendientes de Aprobación</h1>
        
        <?php if (empty($empresasPendientes)): ?>
            <div class="alert alert-info">
                No hay empresas pendientes de aprobación.
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($empresasPendientes as $empresa): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($empresa['nombre']); ?></h5>
                                <p class="card-text">
                                    <strong>NIT:</strong> <?php echo htmlspecialchars($empresa['nit']); ?><br>
                                    <strong>Dirección:</strong> <?php echo htmlspecialchars($empresa['direccion']); ?><br>
                                    <strong>Teléfono:</strong> <?php echo htmlspecialchars($empresa['telefono']); ?><br>
                                    <strong>Correo:</strong> <?php echo htmlspecialchars($empresa['correo']); ?>
                                </p>
                                
                                <form action="Pendientes.php" method="POST" class="mb-2">
                                    <input type="hidden" name="empresa_id" value="<?php echo $empresa['id']; ?>">
                                    <input type="hidden" name="estado" value="Aprobada"> <!-- Campo para estado -->
                                    <div class="input-group mb-3">
                                        <label class="input-group-text">Comisión (%)</label>
                                        <input type="number" name="comision" class="form-control" min="0" max="100" step="0.01" required>                                        
                                    </div>
                                    <button type="submit" class="btn btn-success w-100">Aprobar</button>
                                </form>

                                <form action="Pendientes.php" method="POST">
                                    <input type="hidden" name="empresa_id" value="<?php echo $empresa['id']; ?>">
                                    <input type="hidden" name="estado" value="Desaprobada"> <!-- Campo para estado -->
                                    <input type="hidden" name="comision" value="0"> <!-- Fijar comisión a 0 al rechazar -->
                                    <button type="submit" class="btn btn-danger w-100">Rechazar</button>
                                </form>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <footer class="text-center mt-5">
        <p>La Cuponera SV - 2024</p>
    </footer>
</body>
</html>