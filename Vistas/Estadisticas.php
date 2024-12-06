<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "lacuponerasv";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

$empresa_id = isset($_GET['empresa_id']) ? intval($_GET['empresa_id']) : 0;

if ($empresa_id > 0) {
    $sql = "SELECT 
                COUNT(c.id) AS total_cupones,
                COALESCE(SUM(f.monto), 0) AS ingresos_totales
            FROM cupones c
            JOIN ofertas o ON c.oferta_id = o.id
            JOIN facturas f ON f.cupon_id = c.id
            WHERE o.empresa_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $empresa_id);
    $stmt->execute();
    $stmt->bind_result($total_cupones, $ingresos_totales);
    $stmt->fetch();
    $stmt->close();

    echo json_encode([
        "total_cupones" => $total_cupones,
        "ingresos_totales" => $ingresos_totales
    ]);
} else {
    echo json_encode(["error" => "ID de empresa inválido"]);
}

$conn->close();
?>

<section>
    <h2>Estadísticas</h2>
    <div id="estadisticas">
        <p>Total de Cupones Vendidos: Cargando...</p>
        <p>Ingresos Totales: Cargando...</p>
    </div>
</section>

<script>
    const empresaId = 1; 

    fetch(`estadisticas.php?empresa_id=${empresaId}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById('estadisticas').innerHTML = `<p>${data.error}</p>`;
            } else {
                document.getElementById('estadisticas').innerHTML = `
                    <p>Total de Cupones Vendidos: ${data.total_cupones}</p>
                    <p>Ingresos Totales: $${data.ingresos_totales.toFixed(2)}</p>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('estadisticas').innerHTML = `<p>Error al cargar las estadísticas</p>`;
        });
</script>

