<?php
session_start();
if ($_SESSION["rol"] == 3 || $_SESSION["rol"] == null) {
    header("location: ../VIEWS/iniciov2.php");
    exit();    
}
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';

include '../SCRIPTS/productos-dsh.php';
?>
a
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/dashboard.css">
    <script src="https://kit.fontawesome.com/49e84e2ffb.js" crossorigin="anonymous"></script>
    <title>Productos</title>
    
</head>

<script>
        function toggleInput() {
            var selectedOption = document.querySelector('input[name="contact"]:checked').value;
            var additionalInput = document.getElementById("otra_marca");

            if (selectedOption === "otro") {
                additionalInput.style.display = "block";
            } else {
                additionalInput.style.display = "none";
            }
          }           

          function validarTamanioArchivo(input) {
            const maxSize = 2 * 1024 * 1024; // 2 MB en bytes
            const file = input.files[0];

            if (file.size > maxSize) {
                alert("El archivo es demasiado grande. El tamaño máximo permitido es de 2 MB.");
                input.value = ''; 
            }
        }

    </script>

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
                        <a class="nav-link"  href="../VIEWS/dash-apartados.php">PEDIDOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background-color: limegreen;" href="#">PRODUCTOS</a>
                    </li>
                    <?php if ($_SESSION["rol"] != 2) { ?>
                    <li class="nav-item">
                        <a class="nav-link"  href="../VIEWS/dash-citas.php">CITAS</a>
                    </li>
                    <?php } ?>
                    <?php if ($_SESSION["rol"] == 1 ) { ?>
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
                        <a class="nav-link" href="../VIEWS/clientes.php">CLIENTES</a>
                    </li>
                    <?php } ?>
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
    <form method="get" class="d-flex row" role="search">
      <div class="col-lg-2 col-sm-6 p-1">
      <input class="form-control" type="search" placeholder="ID Producto" aria-label="Search" id="id_prod" name="id_prod">
      </div>
      <div class="col-lg-3 col-sm-6 p-1">
        <input class="form-control" type="search" placeholder="Nombre Producto" aria-label="Search" id="nm_prod" name="nm_prod">
      </div>
      <div class="col-lg-2 col-sm-6 p-1">
      <select class="form-control" name="categoria">
                        <option value="">Todas las Categorías</option>
                        <option value="1" <?php if ($categoria == 1) echo 'selected'; ?>>Pipas</option>
                        <option value="2" <?php if ($categoria == 2) echo 'selected'; ?>>Bongs</option>
                        <option value="3" <?php if ($categoria == 3) echo 'selected'; ?>>Canalas</option>
                        <option value="4" <?php if ($categoria == 4) echo 'selected'; ?>>Hitters</option>
                        <option value="5" <?php if ($categoria == 5) echo 'selected'; ?>>Electrónicos</option>
                        <option value="6" <?php if ($categoria == 6) echo 'selected'; ?>>Ropa</option>
                        <option value="7" <?php if ($categoria == 7) echo 'selected'; ?>>Blunts</option>
                        <option value="8" <?php if ($categoria == 8) echo 'selected'; ?>>Piercings</option>
                        <option value="9" <?php if ($categoria == 9) echo 'selected'; ?>>Grinders</option>
                        <option value="10" <?php if ($categoria == 10) echo 'selected'; ?>>Charolas</option>
                        <option value="11" <?php if ($categoria == 11) echo 'selected'; ?>>Accesorios</option>
                    </select>
        </div>
        <div class="col-lg-2 col-sm-6 p-1">
        <select class="form-control" name="sucursal">
                        <option value="1" <?php if ($sucursal == 1) echo 'selected'; ?>>Matamoros</option>
                        <option value="2" <?php if ($sucursal == 2) echo 'selected'; ?>>Nazas</option>
                    </select>
        </div>
        <div class="col-lg-2 col-sm-6 p-1">
      <button id="regprod" class="boton btn" type="submit" name="btn-aplicar">Aplicar</button>
      </div>
    </form>
    <?php
    if ($_SESSION['rol'] == 1) {  ?>         
        <button id="regprod" type='button' class='btn col-lg-4 offset-4 p-1' data-bs-toggle='modal' 
        data-bs-target='#exampleModal'> Registrar Producto </button>
    <?php } ?>
    
    </div>
<br>
<?php
    if ($results) {
        echo "<h2>Resultados de búsqueda:</h2>";
        
        
        echo "<div class='tabla'><table border='1' class= 'table table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Stock</th>
                    <th>Precio</th>
                    <th>Categoria</th>
                    <th><th>
                </tr>";
                foreach ($results as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id_producto"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["nombre"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["stock"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["precio"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["categoria"]) . "</td>";
                    echo "<td>";
                    if($_SESSION ['rol'] == 1 ) { echo "<a href='modificar.producto.php?id=" . $row['id_producto'] . "' class='btn btn-success'><i class='fa-solid fa-pen-to-square'></i></a>"; } 
                    echo "</td>";
                    echo "</tr>";
                }

        echo "</table>";
    } else {
        echo "<p>No se encontraron productos.</p>";
    }
?>

<nav aria-label="Paginación de productos">
        <ul class="pagination justify-content-center">
            <?php if ($pagina > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina - 1 ?>&nm_prod=<?= urlencode($nm_prod) ?>&categoria=<?= urlencode($categoria) ?>&sucursal=<?= urlencode($sucursal) ?>">Anterior</a>
                </li>
            <?php } ?>
            <?php for ($i = max(1, $pagina - 3); $i <= min($total_paginas, $pagina + 3); $i++) { ?>
                <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $i ?>&nm_prod=<?= urlencode($nm_prod) ?>&categoria=<?= urlencode($categoria) ?>&sucursal=<?= urlencode($sucursal) ?>"><?= $i ?></a>
                </li>
            <?php } ?>
            <?php if ($pagina < $total_paginas) { ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina + 1 ?>&nm_prod=<?= urlencode($nm_prod) ?>&categoria=<?= urlencode($categoria) ?>&sucursal=<?= urlencode($sucursal) ?>">Siguiente</a>
                </li>
            <?php } ?>
        </ul>
    </nav>

<form action="../SCRIPTS/productos-dsh.php" method="post" enctype="multipart/form-data">
<div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de Producto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="form-group">
                        <label for="username">Nombre del Producto:</label><br>
                        <input type="text" id="nombre" placeholder="Ingresa el nombre del producto" name="nombre">
                    </div>                   

                    <fieldset>
                      <legend>MARCA:</legend>
                      <div>
                        <input type="radio" id="contactChoice1" name="contact" value="Raw" onclick="toggleInput()"/>
                        <label for="contactChoice1">Raw</label>

                        <input type="radio" id="contactChoice2" name="contact" value="Blazy Susan" onclick="toggleInput()"/>
                        <label for="contactChoice2">Blazy Susan</label>

                        <input type="radio" id="contactChoice3" name="contact" value="Rolling Circus" onclick="toggleInput()"/>
                        <label for="contactChoice3">Rolling Circus</label>

                        <input type="radio" id="contactChoice3" name="contact" value="OCB" onclick="toggleInput()"/>
                        <label for="contactChoice3">OCB</label>

                        <input type="radio" id="contactChoice3" name="contact" value="Kush" onclick="toggleInput()"/>
                        <label for="contactChoice3">Kush</label>

                        <input type="radio" id="contactChoice3" name="contact" value="Blunt Wrap" onclick="toggleInput()"/>
                        <label for="contactChoice3">Blunt Wrap</label>

                        <input type="radio" id="contactChoice3" name="contact" value="EYCE" onclick="toggleInput()"/>
                        <label for="contactChoice3">EYCE</label>

                        <input type="radio" id="contactChoice3" name="contact" value="otro" onclick="toggleInput()"/>
                        <label for="contactChoice3">OTRO</label>
                      </div>                
                    </fieldset>

                    <div id="otra_marca" style="display:none;">
                      <label for="extra">Ingrese el Nombre de la Marca:</label>
                      <input type="text" id="extra" name="extra">
                    </div>
                  
                    <fieldset>
                    <legend>Categoria(s)</legend>
                    <?php 
                    foreach ($cat as $row) { ?>
                      <div>
                        <input type="checkbox" id="coding" name="cate[]" value="<?php echo $row['id'];?>" />
                        <label for="coding"><?php echo $row['nombre'];?></label>
                      </div>
                        <?php } ?>
                    </fieldset>

                    <fieldset>
                    <legend>Proveedor(es)</legend>
                    <p>(EL PRECIO DE COMPRA SE REGISTRA, DESDE EL REABASTECIMIENTO)</p>
                    <?php 
                    foreach ($prov as $row) { ?>
                      <div>
                        <input type="checkbox" id="<?php echo $row['id']; ?>" name="proveedores[]" value="<?php echo $row['id'];?>" />
                        <label for="coding"><?php echo $row['nombre'];?></label>
                      </div>
                     <?php } ?>
                    </fieldset>

                    <div class="form-group">
                        <label for="precio">Precio al publico:</label><br>
                        <input type="text" id="nombre" placeholder="Ingresa el nombre del producto" name="precio">
                    </div>

                    <fieldset>
                      <legend>MATERIAL:</legend>
                      <div>
                        <input type="radio" id="mt1" name="material" value="ceramica"/>
                        <label for="contactChoice1">Ceramica</label>

                        <input type="radio" id="mt22" name="material" value="metal"/>
                        <label for="contactChoice2">Metal</label>

                        <input type="radio" id="mt3" name="material" value="plastico"/>
                        <label for="contactChoice3">Plastico</label>

                        <input type="radio" id="mt4" name="material" value="cristal"/>
                        <label for="contactChoice3">Cristal</label>

                        <input type="radio" id="mt5" name="material" value="madera"/>
                        <label for="contactChoice3">Madera</label> 
                        
                        <input type="radio" id="mt4" name="material" value="otro"/>
                        <label for="contactChoice3">Otro</label>
                      </div>                
                    </fieldset>

                    <label for="avatar">Seleccione una imagen del producto:</label>
                    <input type="file" id="img" name="img"/>
                      
                    <legend>DESCRIPCIÓN:</legend>
                     <textarea name="desc" class="form-control" rows="5"></textarea><br><br>
                </div> 
                <button id="regprod" type="submit" name="btnreg" class="btn">Registrar</button>     
            </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>        
      </div>
    </div>
  </div>
</div>
                    </form>
</div>
</div>
</body>
</html>