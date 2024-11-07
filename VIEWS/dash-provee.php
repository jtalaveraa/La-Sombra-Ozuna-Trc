<?php
session_start();
if ($_SESSION["rol"] != 1|| $_SESSION["rol"] == null) {
    header("location: ../VIEWS/iniciov2.php");
    exit();    
}
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';
include '../SCRIPTS/provee-dsh.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/49e84e2ffb.js" crossorigin="anonymous"></script>

    <title>Proveedor</title>
    <link rel="stylesheet" href="../CSS/dash-provee.css">
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
                        <a class="nav-link" style="background-color: limegreen;" href="#">PROVEEDOR</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/dsh-empl.php">EMPLEADOS</a>
                    </li>
                    <li>
                        <a class="nav-link" href="../VIEWS/reabastecimiento.php">REABASTECIMIENTO</a>
                    </li>
                    <li>
                        <a class="nav-link" href="../VIEWS/clientes.php">CLIENTES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/iniciov2.php">IR A LA PÁGINA PRINCIPAL</a>
                    </li>
                    <div class="usuario-info">
                  <p>Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?>!</p>
                   <a href="?logout=1" class="logout-icon">
                    <i class="fas fa-sign-out-alt"></i> 
                     </a>
                      </div>
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
        <div class="botonprinci col-lg-4 col-sm-6 p-1 text-center-sm">
            <button name="btntodos" id="botonfiltrar" type='buton' class='btn btn-success'><a class="propro" href="../VIEWS/productos-proveedores.php">Produtos y Proveedores</a> </button>
            </div>
        <form class="d-flex row" method="post" action="">
        <div class="botonprinci col-lg-4 col-sm-6 p-1 text-center-sm">
            <button id="botonprinci" type='button' class='btn btn-success' data-bs-toggle='modal' 
            data-bs-target='#exampleModal'> Registrar Proveedor </button>
            </div>
        </form>
        
    <br>
    
        

<?php

if (isset($_POST['btnfiltrar'])) {
    if (!empty($filteredResults)) {
        echo "<h2>Resultados del Filtro:</h2>";
        echo "<div class='table-responsive'><table border='1' class='table table-striped'>
                <tr>
                    <th>PRODUCTO</th>
                    <th>PROVEEDOR</th>
                    <th>PRECIO</th>
                    <th><th>
                </tr>";
        foreach ($filteredResults as $row) {
            echo "<tr>                            
                    <td>" . htmlspecialchars($row["producto_nombre"]) . "</td>
                    <td>" . htmlspecialchars($row["proveedor_nombre"]) . "</td>
                    <td>" . htmlspecialchars($row["precio"]) . "</td>
                    <td><a href='modificarpreciopro.php?id=" . htmlspecialchars($row['id_provee_producto']) . "' class='btn btn-success'><i class='fa-solid fa-pen-to-square'></i></a></td>
                  </tr>";                    
        }
        echo "</table></div>";
        // Mostrar paginación
        echo "<nav aria-label='Page navigation example'><ul class='pagination justify-content-center'>";
        for ($i = 1; $i <= $totalPaginas; $i++) {
            echo "<li class='page-item " . ($i == $paginaActual ? 'active' : '') . "'>
                    <a class='page-link' href='?pagina=$i'>$i</a>
                  </li>";
        }
        echo "</ul></nav>";

    } else {
        echo "<div class='alert alert-warning'>El proveedor seleccionado no ofrece ningún producto.</div>";
    }
} else {

    if (($results) || isset($_POST['btntodos'])) {
        echo "<h2>Proveedores:</h2>";
        echo "<div class='table-responsive'><table border='1' class='table table-striped'>
                <tr>
                    <th>NOMBRE</th>
                    <th>TELEFONO</th>
                    <th>PAGINA</th>
                    <th></th>
                </tr>";
        foreach ($results as $row) {
            $telefono = $row['telefono'] ? $row['telefono'] : '-';
            $pagina = $row['pagina'] ? $row['pagina'] : '-';
            echo "<tr>                            
                    <td>" . htmlspecialchars($row["nombre"]) . "</td>
                    <td>" . htmlspecialchars($telefono) . "</td>
                    <td>" . htmlspecialchars($pagina) . "</td>
                    <td>
                        <a href='modificar-proveedor.php?id=" . htmlspecialchars($row['id']) .   "' class='btn btn-success'><i class='fa-solid fa-pen-to-square'></i></a>
                    </td>
                  </tr>";                    
        }
        echo "</table></div>";
    } else {
        echo "<div class='alert alert-warning'>No se encontraron proveedores.</div>";
    }
}

?>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de un proveedor</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
        <label for="nombre">Ingrese el nombre del proveedor:</label>
        <input type="text" class="form-control" name="nombre" id="nombre"> <br>        
        <label for="nombre">Ingrese el número telefonico del proveedor:</label>
        <input type="tel" class="form-control" id="phone" name="telefono"/> <br>
        <label for="url">Ingrese la pagína del proveedor:</label>
        <input type="url" class="form-control" name="url" id="url">
        <div class="boton">
            <button id="botonregis" type="submit" name="btnreg" class="btn btn-primary">Registrar Proveedor</button>
        </div>
                
        </form>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>        
      </div>
    </div>
  </div>
</div>
</div>

<script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>