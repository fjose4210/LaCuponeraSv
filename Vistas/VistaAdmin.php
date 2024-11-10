<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Cuponera SV - Cupones Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f0f0;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .nav-link {
            color: #555;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">La Cuponera SV</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="Pendientes.php">Aprobaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="text-center mb-4">Cupones Disponibles</h1>
        
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pizza 2x1</h5>
                        <p class="card-text">Precio Regular: $20.00</p>
                        <p class="card-text">Precio Oferta: $10.00</p>
                        <p class="card-text">Descripción: </p>
                        <p class="card-text">Fecha Límite: 31/12/2024</p>
                        <button class="btn btn-danger">Eliminar</button>
                        <button class="btn btn-warning">Editar</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Descuento en Spa</h5>
                        <p class="card-text">Precio Regular: $50.00</p>
                        <p class="card-text">Precio Oferta: $25.00</p>
                        <p class="card-text">Descripción: </p>
                        <p class="card-text">Fecha Límite: 31/12/2024</p>
                        <button class="btn btn-danger">Eliminar</button>
                        <button class="btn btn-warning">Editar</button>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Buffet Libre</h5>
                        <p class="card-text">Precio Regular: $30.00</p>
                        <p class="card-text">Precio Oferta: $15.00</p>
                        <p class="card-text">Descripción: </p>
                        <p class="card-text">Fecha Límite: 31/12/2024</p>
                        <button class="btn btn-danger">Eliminar</button>
                        <button class="btn btn-warning">Editar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center mt-5">
        <p>La Cuponera SV - 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
