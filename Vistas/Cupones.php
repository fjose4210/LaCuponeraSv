<?php
session_start();
include '../config.php';

$empresa_id = $_SESSION['empresa_id'];

try {
    $sql = "SELECT * FROM ofertas WHERE empresa_id = :empresa_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['empresa_id' => $empresa_id]);
    $cupones = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar la base de datos: " . $e->getMessage());
}
?>
<section>
    <h2>Mis Cupones</h2>
    <a href="NuevoCupon.php">Agregar Cupón</a>
    <?php if (empty($cupones)): ?>
        <p>No hay cupones disponibles en este momento.</p>
    <?php else: ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Precio Regular</th>
                    <th>Precio Oferta</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Límite Canje</th>
                    <th>Cantidad</th>
                    <th>Vendidos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cupones as $cupon): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($cupon['titulo']); ?></td>
                        <td>$<?php echo number_format($cupon['precio_regular'], 2); ?></td>
                        <td>$<?php echo number_format($cupon['precio_oferta'], 2); ?></td>
                        <td><?php echo htmlspecialchars($cupon['fecha_inicio']); ?></td>
                        <td><?php echo htmlspecialchars($cupon['fecha_fin']); ?></td>
                        <td><?php echo htmlspecialchars($cupon['fecha_limite']); ?></td>
                        <td><?php echo htmlspecialchars($cupon['cantidad_cupones'] ?? 'Sin límite'); ?></td>
                        <td><?php echo htmlspecialchars($cupon['cantidad_vendidos'] ?? 0); ?></td>
                        <td><?php echo ($cupon['estado'] == 1) ? 'Disponible' : 'No Disponible'; ?></td>
                        <td>
                            <a href="EditarCupon.php?id=<?php echo $cupon['id']; ?>">Editar</a>
                            <a href="CambiarEstado.php?id=<?php echo $cupon['id']; ?>">Cambiar Estado</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
