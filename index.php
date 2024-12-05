<?php
session_start();
include 'config.php';

$sql = "SELECT * FROM ofertas WHERE estado = 'disponible' AND fecha_fin >= Current_Date";
$stmt = $pdo->query($sql);
$ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La Cuponera SV</title>
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
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">La Cuponera SV</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="paginas/Registro.php">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Iniciar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="text-center mb-4">Bienvenido a La Cuponera SV</h1>
        <p class="text-center">Descubre las mejores ofertas y cupones de descuento.</p>
        
        <h2 class="mb-4">Ofertas Disponibles</h2>
        <div class="row">
            <?php foreach ($ofertas as $oferta): ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($oferta['titulo']); ?></h5>
                            <p class="card-text">Precio Regular: <?php echo htmlspecialchars($oferta['precio_regular']); ?></p>
                            <p class="card-text">Precio Oferta: <?php echo htmlspecialchars($oferta['precio_oferta']); ?></p>
                            <p class="card-text">Descripción: <?php echo htmlspecialchars($oferta['descripcion']); ?></p>
                            <p class="card-text">Disponible hasta: <?php echo htmlspecialchars($oferta['fecha_fin']); ?></p>
                            <?php if (isset($_SESSION['usuario'])): ?>
                                <a href="comprar.php?oferta_id=<?php echo $oferta['id']; ?>" class="btn btn-primary">Comprar Cupón</a>
                            <?php else: ?>
                                <p><a href="login.php" class="btn btn-secondary">Inicia sesión para comprar este cupón</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
