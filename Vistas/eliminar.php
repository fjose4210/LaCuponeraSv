<?php
session_start();
include '../config.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$carrito_id = $_GET['carrito_id'];

$sql = "DELETE FROM carrito WHERE id = :carrito_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['carrito_id' => $carrito_id]);

header("Location: CompraCupon.php");
