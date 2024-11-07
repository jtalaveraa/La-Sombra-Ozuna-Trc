<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle apartado</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/dash-apartado-detalle.css">
</head>
<body>
<div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>0001</h1>
            <button class="btn btn-outline-secondary" onclick="closePage()">X</button>
        </div>
        <div class="row mt-3">
            <!-- Product Section -->
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="../IMG/bicho.jpg" class="card-img-top" alt="Blazy Susan Pink Rolling">
                            <div class="card-body text-center">
                                <h5 class="card-title">Blazy Susan Pink Rolling Papers Papeles Rosas (50 Canalas por Libro)</h5>
                                <p class="card-text">18 piezas disponibles</p>
                                <p class="text-success">$49.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="../IMG/blunt-wrapp.jpg" class="card-img-top" alt="Blazy Susan Pink Rolling">
                            <div class="card-body text-center">
                                <h5 class="card-title">Blazy Susan Pink Rolling Papers Papeles Rosas (50 Canalas por Libro)</h5>
                                <p class="card-text">18 piezas disponibles</p>
                                <p class="text-success">$49.00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="../IMG/blazy-susann.jpg" class="card-img-top" alt="Blazy Susan Pink Rolling">
                            <div class="card-body text-center">
                                <h5 class="card-title">Blazy Susan Pink Rolling Papers Papeles Rosas (50 Canalas por Libro)</h5>
                                <p class="card-text">18 piezas disponibles</p>
                                <p class="text-success">$49.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Order Summary Section -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>1</span> Blazy Susan Pink Rolling
                                <span>$90.00</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>1</span> Blazy Susan Pink Rolling
                                <span>$90.00</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>1</span> Blazy Susan Pink Rolling
                                <span>$90.00</span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <h5>Total</h5>
                            <h5>$270.00</h5>
                        </div>
                        <button class="btn btn-success btn-block mt-3">Confirmar entrega</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function closePage() {
            window.close(); // You can customize this function to fit your needs
        }
    </script>
</body>
</html>