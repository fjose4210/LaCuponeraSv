<?php
session_start();
include '../config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$numero_tarjeta = $_POST['numero_tarjeta'];
$fecha_vencimiento = $_POST['fecha_vencimiento'];
$cvv = $_POST['cvv'];
$usuario_id = $_SESSION['usuario_id'];

$fecha_actual = date('Y-m');
if ($fecha_vencimiento <= $fecha_actual) {
    echo "Error: La tarjeta está vencida. Por favor, utilice una tarjeta válida.";
    exit;
}

$sql = "SELECT * FROM carrito WHERE usuario_id = :usuario_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['usuario_id' => $usuario_id]);
$carrito = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($carrito as $item) {
    $oferta_id = $item['oferta_id'];
    $cantidad = $item['cantidad'];

    $sql_check = "SELECT COUNT(*) AS total_comprados FROM cupones WHERE usuario_id = :usuario_id AND oferta_id = :oferta_id";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute(['usuario_id' => $usuario_id, 'oferta_id' => $oferta_id]);
    $total_comprados = $stmt_check->fetchColumn();

    if ($total_comprados + $cantidad > 5) {
        echo "Error: No puede comprar más de 5 cupones de la misma oferta.";
        exit;
    }

    for ($i = 0; $i < $cantidad; $i++) {
        $codigo = 'CUP-' . uniqid();

        $sql_cupon = "INSERT INTO cupones (oferta_id, usuario_id, codigo, fecha_compra) VALUES (:oferta_id, :usuario_id, :codigo, NOW())";
        $stmt_cupon = $pdo->prepare($sql_cupon);
        $stmt_cupon->execute(['oferta_id' => $oferta_id, 'usuario_id' => $usuario_id, 'codigo' => $codigo]);

        $cupon_id = $pdo->lastInsertId();

        $sql_factura = "INSERT INTO facturas (cupon_id, monto, fecha_emision) VALUES (:cupon_id, (SELECT precio_oferta FROM ofertas WHERE id = :oferta_id), NOW())";
        $stmt_factura = $pdo->prepare($sql_factura);
        $stmt_factura->execute(['cupon_id' => $cupon_id, 'oferta_id' => $oferta_id]);
    }
}


$sql = "DELETE FROM carrito WHERE usuario_id = :usuario_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['usuario_id' => $usuario_id]);

echo "Compra realizada exitosamente. Puede ver los cupones en su historial.";
header("Location: Historial.php");
exit;
?>
