<?php
include '../config.php';
session_start();


if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$sql = "SELECT * FROM empresas WHERE estado = 'En espera'";
$stmt = $pdo->query($sql);
$empresasPendientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
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
</head>
<body class="bg-light">
    <div class="container mt-4">
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
                                        <button type="submit" class="btn btn-success">Aprobar</button>
                                    </div>
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
        
        <a href="VistaAdmin.php" class="btn btn-primary mt-3">Volver al Panel de Administración</a>
    </div>
</body>
</html>