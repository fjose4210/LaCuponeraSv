<?php
session_start();
include 'config.php';

$sql = "SELECT * FROM ofertas WHERE estado = 'disponible'";
$stmt = $pdo->query($sql);
$ofertas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>La Cuponera SV</title>
</head>
<body>
    <h1>Bienvenido a La Cuponera SV</h1>
    <p>Descubre las mejores ofertas y cupones de descuento.</p>
    
    <nav>
            <a href="paginas/Registro.php">Registrarse</a> |
            <a href="login.php">Iniciar Sesión</a>
    </nav>
    
    <h2>Ofertas Disponibles</h2>
    <ul>
        <?php foreach ($ofertas as $oferta): ?>
            <li>
                <h3><?php echo htmlspecialchars($oferta['titulo']); ?></h3>
                <p>Precio Regular: <?php echo htmlspecialchars($oferta['precio_regular']); ?></p>
                <p>Precio Oferta: <?php echo htmlspecialchars($oferta['precio_oferta']); ?></p>
                <p>Descripción: <?php echo htmlspecialchars($oferta['descripcion']); ?></p>
                <p>Disponible hasta: <?php echo htmlspecialchars($oferta['fecha_fin']); ?></p>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="comprar.php?oferta_id=<?php echo $oferta['id']; ?>">Comprar Cupón</a>
                <?php else: ?>
                    <p><a href="login.php">Inicia sesión para comprar este cupón</a></p>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
