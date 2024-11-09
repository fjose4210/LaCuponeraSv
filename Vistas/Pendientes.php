<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Empresas Pendientes de Aprobación - La Cuponera SV</title>
</head>
<body>
    <h1>Empresas Pendientes de Aprobación</h1>
    
    <ul>
            <li>
                <p>Nombre de la Empresa:</p>
                <form action="AprobarEmpresa.php" method="POST">
                    <input type="hidden" name="empresa_id" value="">
                    <label>Comisión (%)</label>
                    <input type="number" name="comision" min="0" required>
                    <button type="submit">Aprobar</button>
                </form>
                
                <form action="RechazarEmpresa.php" method="POST">
                    <input type="hidden" name="empresa_id" value="">
                    <button type="submit">Rechazar</button>
                </form>
            </li>
    </ul>

    <a href="VistaAdmin.php">Volver al Panel de Administración</a>
</body>
</html>
