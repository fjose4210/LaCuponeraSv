<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $empresa_id = $_SESSION['usuario_id'];
    $titulo = $_POST['titulo'];
    $precio_regular = $_POST['precio_regular'];
    $precio_oferta = $_POST['precio_oferta'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $fecha_limite = $_POST['fecha_limite'];
    $cantidad_cupones = !empty($_POST['cantidad_cupones']) ? $_POST['cantidad_cupones'] : null; 

    try {
        $sql = "UPDATE ofertas SET
                    empresa_id = :empresa_id,
                    titulo = :titulo,
                    precio_regular = :precio_regular,
                    precio_oferta = :precio_oferta,
                    fecha_inicio = :fecha_inicio,
                    fecha_fin = :fecha_fin,
                    fecha_limite = :fecha_limite,
                    cantidad_cupones = :cantidad_cupones
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':empresa_id', $empresa_id, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':precio_regular', $precio_regular);
        $stmt->bindParam(':precio_oferta', $precio_oferta);
        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
        $stmt->bindParam(':fecha_fin', $fecha_fin);
        $stmt->bindParam(':fecha_limite', $fecha_limite);
        $stmt->bindParam(':cantidad_cupones', $cantidad_cupones, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $message = "Oferta actualizada exitosamente.";
        } else {
            $message = "Error al actualizar la oferta.";
        }
    } catch (PDOException $e) {
        $message = "Error en la base de datos: " . $e->getMessage();
    }
}
?>

<script>
    <?php if (isset($message)): ?>
        alert("<?php echo $message; ?>");
        window.location.href = "VistaEmpresa.php"; 
    <?php endif; ?>
</script>



