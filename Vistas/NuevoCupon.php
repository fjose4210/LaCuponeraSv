<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empresa_id = $_SESSION['empresa_id'];
    $titulo = $_POST['titulo'];
    $precio_regular = $_POST['precioRegular'];
    $precio_oferta = $_POST['precioOferta'];
    $fecha_inicio = $_POST['fechaInicio'];
    $fecha_fin = $_POST['fechaFin'];
    $fecha_limite = $_POST['fechaCanje'];
    $cantidad = $_POST['cantidad'] ?? null;
    $descripcion = $_POST['descripcion'];
    $estado = ($_POST['estado'] === 'disponible') ? 1 : 0;

    try {
        $sql = "INSERT INTO ofertas 
                (empresa_id, titulo, precio_regular, precio_oferta, fecha_inicio, fecha_fin, fecha_limite, cantidad_cupones, descripcion, estado) 
                VALUES 
                (:empresa_id, :titulo, :precio_regular, :precio_oferta, :fecha_inicio, :fecha_fin, :fecha_limite, :cantidad, :descripcion, :estado)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'empresa_id' => $empresa_id,
            'titulo' => $titulo,
            'precio_regular' => $precio_regular,
            'precio_oferta' => $precio_oferta,
            'fecha_inicio' => $fecha_inicio,
            'fecha_fin' => $fecha_fin,
            'fecha_limite' => $fecha_limite,
            'cantidad' => $cantidad,
            'descripcion' => $descripcion,
            'estado' => $estado
        ]);
        header("Location: Cupones.php");
        exit;
    } catch (PDOException $e) {
        die("Error al guardar el cupón: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Nuevo Cupón</title>
</head>
<body>
    <h1>Agregar Nuevo Cupón</h1>
    <form action="NuevoCupon.php" method="POST">
        <div>
            <label for="titulo">Título de la oferta:</label>
            <input type="text" id="titulo" name="titulo" required>
        </div>
        <div>
            <label for="precioRegular">Precio Regular:</label>
            <input type="number" id="precioRegular" name="precioRegular" step="0.01" required>
        </div>
        <div>
            <label for="precioOferta">Precio de Oferta:</label>
            <input type="number" id="precioOferta" name="precioOferta" step="0.01" required>
        </div>
        <div>
            <label for="fechaInicio">Fecha de inicio:</label>
            <input type="date" id="fechaInicio" name="fechaInicio" required>
        </div>
        <div>
            <label for="fechaFin">Fecha de fin:</label>
            <input type="date" id="fechaFin" name="fechaFin" required>
        </div>
        <div>
            <label for="fechaCanje">Fecha límite para canjear:</label>
            <input type="date" id="fechaCanje" name="fechaCanje" required>
        </div>
        <div>
            <label for="cantidad">Cantidad de cupones (opcional):</label>
            <input type="number" id="cantidad" name="cantidad" min="0">
        </div>
        <div>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>
        </div>
        <div>
            <label for="estado">Estado:</label>
            <select id="estado" name="estado" required>
                <option value="disponible">Disponible</option>
                <option value="no_disponible">No Disponible</option>
            </select>
        </div>
        <button type="submit">Guardar Oferta</button>
        <button type="button" onclick="window.location.href='Cupones.php'">Cancelar</button>
    </form>
</body>
</html>
