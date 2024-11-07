<?php
session_start();
if ($_SESSION["rol"] != 1|| $_SESSION["rol"] == null) {
    header("location: ../VIEWS/iniciov2.php");
    exit();    
}
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';

include '../SCRIPTS/dash-clientes.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <title>Clientes</title>
    
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/49e84e2ffb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../CSS/dash-clientes.css">
</head>
<body>
    <div class="d-flex">
    <header>
    <nav id="contenedor-todo" class="navbar  fixed-top">
    <div  class="container">
    <div class="row align-items-center">
    <div class="col-6 col-lg-4 order-2 order-lg-4">
        
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <div class="logo">
                <a href="#in"><img src="../IMG/sombra-logo.png" alt="La Sombra"></a>
                </div>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div  id="body-burger"   class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/dash-ventas.php">VENTAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/dash-apartados.php">PEDIDOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/dashboard.php">PRODUCTOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/dash-citas.php">CITAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/dash-provee.php">PROVEEDOR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/dsh-empl.php">EMPLEADOS</a>
                    </li>
                    <li>
                        <a class="nav-link" href="../VIEWS/reabastecimiento.php">REABASTECIMIENTO</a>
                    </li>
                    <li>
                        <a class="nav-link" style="background-color: limegreen;" href="#">CLIENTES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/iniciov2.php">IR A LA PÁGINA PRINCIPAL</a>
                    </li>
                    <li>
                    <div class="usuario-info">
                    <p>Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?>!</p>
                        <a href="../SCRIPTS/cerrarsesion.php" class="logout-icon">
                        <i class="fas fa-sign-out-alt"></i> 
                        </a>
                    </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </div>
    </div>
    </nav>
    </header>

    <div class="container-fluid">

<div class="forms">
<form class="d-flex row" method="post" action="">

<div class="col-lg-3 col-sm-6 p-1 text-start-lg text-center-sm">
        <div class="card card-custom">
            <div class="card-header">
                <b>Top 5 clientes con más pedidos en línea para matamoros</b>
            </div>
            <div class="card-body">
            <?php if($topClientesMata) { ?>
                <?php foreach ($topClientesMata as $clienteMata): ?>
                    <p><?php echo $clienteMata['nombre_usuario'] . ' con ' . $clienteMata['total_ventas'] . ' compras '; ?></p>
                <?php endforeach; ?>
                <?php } else { ?>
                    <div class="alert alert-warning" role="alert">No se encontraron resultados para nazas.</div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6 p-1 text-start-lg text-center-sm">
        <div class="card card-custom">
            <div class="card-header">
                <b>Top 5 clientes con más pedidos en línea para nazas</b>
            </div>
            <div class="card-body">
                <?php if($topClientesNazas) { ?>
                <?php foreach ($topClientesNazas as $cliente): ?>
                    <p><?php echo $cliente['nombre_usuario'] . ' con ' . $cliente['total_ventas'] . ' compras'; ?></p>
                <?php endforeach; ?>
                <?php } else { ?>
                    <div class="alert alert-warning" role="alert">No se encontraron resultados para nazas.</div>
                <?php } ?>
            </div>
        </div>
    </div>
                    
    


    <div class="col-lg-3 col-sm-6 p-1 text-end-lg text-center-sm">
        <div class="card card-custom">
            <div class="card-header">
                <b>Producto más vendido por línea para Matamoros</b>
            </div>
            <div class="card-body">
                <p><?php echo $productoMasVendidoMata['nombre'] . ' con ' . $productoMasVendidoMata['total_vendido'] . ' vendidos'; ?></p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6 p-1 text-end-lg text-center-sm">
        <div class="card card-custom">
            <div class="card-header">
                <b>Producto más vendido por línea para sucursal Nazas</b>
            </div>
            <div class="card-body">
                <p><?php echo $productoMasVendidoNazas['nombre'] . ' con ' . $productoMasVendidoNazas['total_vendido'] . ' vendidos'; ?></p>
            </div>
        </div>
    </div>
</form>
<br>
    <div class="row">
        <div class="col-12 text-center">
            <p><b>BUSQUEDA POR FILTRADO</b></p>
        </div>

    </div>

    <form method="post" class="d-flex row" role="search">
    <div class="col-lg-3 col-sm-6 p-1">
        <input class="form-control" type="search" placeholder="Buscar usuario" aria-label="Search" id="nm_prod" name="nm_prod">
    </div>

    <div class="col-lg-3 col-sm-6 p-1">
        <select class="form-select" aria-label="Default select example" name="provee">
            <option value="" disabled selected>Selecciona una sucursal</option>
            <?php
            // Rellenar el select con las sucursales
            $sucursalesQuery = "SELECT id_sucursal, nombre FROM sucursales";
            $result = $conexion->query($sucursalesQuery);
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id_sucursal']}'>{$row['nombre']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="botonprinci col-lg-3 col-sm-6 p-1 text-lg-start text-center">
        <button id="botonprinci" name="btnfiltrar" type='submit' class='btn btn-success'>Filtrar</button>
    </div>
    
    <div class="botonprinci col-lg-3 col-sm-6 p-1 text-lg-start text-center">
        <button name="btntodos" id="botonfiltrar" type='submit' class='btn btn-success'>Mostrar todos los clientes</button>
    </div>
</form>

<br>

<div class="row">
    <div class="data col-lg-12 col-sm-12">
        <?php if (isset($pedidosCliente) && empty($pedidosCliente)) { ?>
            <div class="alert alert-warning" role="alert">No se encontraron resultados para el usuario buscado.</div>
        <?php } elseif (isset($pedidosSucursal) && empty($pedidosSucursal)) { ?>
            <div class="alert alert-warning" role="alert">No se encontraron resultados para la sucursal seleccionada.</div>
        <?php } elseif (isset($pedidosFiltrados) && empty($pedidosFiltrados)) { ?>
            <div class="alert alert-warning" role="alert">No se encontraron resultados para los filtros aplicados.</div>
        <?php } else { ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre de Usuario</th>
                        <th>ID Venta</th>
                        <th>Monto Total</th>
                        <th>Sucursal</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($pedidosCliente)) { ?>
                        <?php foreach ($pedidosCliente as $pedido): ?>
                            <tr>
                                <td><?php echo $pedido['nombre_usuario']; ?></td>
                                <td><?php echo $pedido['id_venta']; ?></td>
                                <td><?php echo $pedido['monto_total']; ?></td>
                                <td><?php echo $pedido['sucursal']; ?></td>
                                <td><button type="button" class="btn btn-success ver-detalles" data-venta-id="<?php echo $pedido['id_venta']; ?>" 
                                data-bs-toggle="modal" data-bs-target="#detalleModal">Ver Detalles</button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>

                    <?php if (isset($pedidosSucursal)) { ?>
                        <?php foreach ($pedidosSucursal as $pedidosuc): ?>
                            <tr>
                                <td><?php echo $pedidosuc['nombre_usuario']; ?></td>
                                <td><?php echo $pedidosuc['id_venta']; ?></td>
                                <td><?php echo $pedidosuc['monto_total']; ?></td>
                                <td><?php echo $pedidosuc['sucursal']; ?></td>
                                <td><button type="button" class="btn btn-success ver-detalles" data-venta-id="<?php echo $pedidosuc['id_venta']; ?>"
                                data-bs-toggle="modal" data-bs-target="#detalleModal">Ver Detalles</button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                    
                    <?php if (isset($clientes)) { ?>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?php echo $cliente['nombre_usuario']; ?></td>
                                <td><?php echo $cliente['id_venta']; ?></td>
                                <td><?php echo $cliente['monto_total']; ?></td>
                                <td><?php echo $cliente['sucursal']; ?></td>
                                <td><button type="button" class="btn btn-success ver-detalles" data-venta-id="<?php echo $cliente['id_venta']; ?>"
                                data-bs-toggle="modal" data-bs-target="#detalleModal">Ver Detalles</button></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php } ?>
                    
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>

    <br>
</div>
</div>

<!-- Modal para mostrar detalles de la compra -->
<div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div id="modal" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detalleModalLabel">Detalles de la Compra</h5>
                <button type="button" class="btn-close btn-emphasis-color" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se cargarán los detalles de la compra -->
                <div id="detalleCompra"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.ver-detalles').forEach(function(button) {
        button.addEventListener('click', function() {
            const ventaId = this.getAttribute('data-venta-id');
            const formData = new FormData();
            formData.append('venta_id', ventaId);

            fetch('../SCRIPTS/dash-clientes.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                document.getElementById('detalleCompra').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>
</body>
</html>