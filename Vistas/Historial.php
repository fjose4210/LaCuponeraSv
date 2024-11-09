<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Compras - La Cuponera SV</title>
</head>
<body>
    <header>
        <h1>La Cuponera SV</h1>
        <nav>
            <a href="VistaUsuario.php">Pagina Principal</a>
            <a href="CompraCupon.php">Carrito de Compras</a>
        </nav>
    </header>

    <main>
        <h2>Historial de Compras</h2>

        <section>

            <div>
                <label for="fecha-inicio">Desde:</label>
                <input type="date" id="fecha-inicio" name="fecha-inicio">
                
                <label for="fecha-fin">Hasta:</label>
                <input type="date" id="fecha-fin" name="fecha-fin">
                
                <button>Filtrar</button>
            </div>

            <table border="1">
                <thead>
                    <tr>
                        <th>Fecha de Compra</th>
                        <th>Cupón</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Código</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>01/11/2024</td>
                        <td>Pizza 2x1</td>
                        <td>2</td>
                        <td>$10.00</td>
                        <td>$20.00</td>
                        <td>Canjeado</td>
                        <td>CUP001</td>
                    </tr>

                    <tr>
                        <td>15/10/2024</td>
                        <td>Descuento en Spa</td>
                        <td>1</td>
                        <td>$25.00</td>
                        <td>$25.00</td>
                        <td>Disponible</td>
                        <td>CUP002</td>
                    </tr>

                    <tr>
                        <td>05/10/2024</td>
                        <td>Buffet Libre</td>
                        <td>3</td>
                        <td>$15.00</td>
                        <td>$45.00</td>
                        <td>Expirado</td>
                        <td>CUP003</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section>
            <h3>Resumen</h3>
            <p>Total de Cupones Comprados: 6</p>
            <p>Cupones Disponibles: 1</p>
            <p>Cupones Canjeados: 4</p>
            <p>Cupones Expirados: 1</p>
            <p>Total Gastado: $90.00</p>
        </section>
    </main>

    <footer>
        <p>La Cuponera SV - 2024</p>
    </footer>
</body>
</html>