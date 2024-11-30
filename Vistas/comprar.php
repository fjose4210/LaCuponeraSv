<?php
session_start();
include '../config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$oferta_id = $_GET['oferta_id'];

$sql = "SELECT * FROM carrito WHERE usuario_id = :usuario_id AND oferta_id = :oferta_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['usuario_id' => $usuario_id, 'oferta_id' => $oferta_id]);
$item = $stmt->fetch();

if ($item) {
    $sql = "UPDATE carrito SET cantidad = cantidad + 1 WHERE usuario_id = :usuario_id AND oferta_id = :oferta_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['usuario_id' => $usuario_id, 'oferta_id' => $oferta_id]);
} else {

    $sql = "INSERT INTO carrito (usuario_id, oferta_id, cantidad) VALUES (:usuario_id, :oferta_id, 1)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['usuario_id' => $usuario_id, 'oferta_id' => $oferta_id]);
}

header("Location: CompraCupon.php");
