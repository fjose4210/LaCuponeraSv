<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empresa_id = $_POST['empresa_id'];
    
    try {
        $sql = "UPDATE empresas SET estado = 'Desaprobada' WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $empresa_id]);
        
        header("Location: Pendientes.php?mensaje=rechazada");
        exit;
    } catch (PDOException $e) {
        die("Error al rechazar la empresa: " . $e->getMessage());
    }
}
?>