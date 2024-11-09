        <section>
            <h2>Mis Cupones</h2>
		    <a href="NuevoCupon.php">Agregar Cupon</a>     
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

                    <tr>
                        <td>2x1 en Hamburguesas</td>
                        <td>$15.00</td>
                        <td>$7.50</td>
                        <td>01/11/2024</td>
                        <td>30/11/2024</td>
                        <td>31/12/2024</td>
                        <td>100</td>
                        <td>45</td>
                        <td>Disponible</td>
                        <td>
                            <button onclick="editarCupon(1)">Editar</button>
                            <button onclick="aumentarCantidad(1)">+</button>
                            <button onclick="disminuirCantidad(1)">-</button>
                            <button onclick="cambiarEstado(1)">Cambiar Estado</button>
                        </td>
                    </tr>

                    <tr>
                        <td>50% Descuento en Postres</td>
                        <td>$10.00</td>
                        <td>$5.00</td>
                        <td>15/11/2024</td>
                        <td>15/12/2024</td>
                        <td>31/12/2024</td>
                        <td>Sin límite</td>
                        <td>23</td>
                        <td>No Disponible</td>
                        <td>
                            <button onclick="editarCupon(2)">Editar</button>
                            <button onclick="aumentarCantidad(2)">+</button>
                            <button onclick="disminuirCantidad(2)">-</button>
                            <button onclick="cambiarEstado(2)">Cambiar Estado</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
