<?php
session_start();
if ($_SESSION["rol"] == 3 || $_SESSION["rol"] == null) {
    header("location: ../VIEWS/iniciov2.php");
    exit();    
}
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';

include '../SCRIPTS/dsh-reabas.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/49e84e2ffb.js" crossorigin="anonymous"></script>

    <title>Reabastecimiento</title>
    <link rel="stylesheet" href="../CSS/dashboard.css">
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
                      <a class="nav-link" style="background-color: limegreen;" href="#">REABASTECIMIENTO</a>
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
<nav class="navbar bg-body-tertiary">
    <?php
    if ($_SESSION['rol'] == 1) {  ?>        
      <button id="btnregistrar" type='button' class='btn' data-bs-toggle="modal" 
      data-bs-target="#exampleModal"'> Registrar compra </button>
    <?php }
    ?>

<?php
    if ($_SESSION['rol'] == 1) {  ?>        
      <button id="btnregistrar" type='button' class='btn' data-bs-toggle="modal" 
      data-bs-target="#exampleModal2"'> Agregar el precio de proveedor </button>
    <?php }
    ?>
</nav>
<br>
<?php
    if ($or) {
        echo "<h2>Reabastecimientos anteriores:</h2>";
        echo "<div class='tabla'><table border='1' class= 'table table-striped'>
                <tr>
                    <th>PRODUCTO</th>
                    <th>CANTIDAD</th>
                    <th>FECHA</th>
                    <th>MONTO</th>
                    <th>SUCURSAL</th>
                </tr>";
        foreach ($or as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["producto"]) . "</td>
                    <td>" . htmlspecialchars($row["cantidad"]) . "</td>
                    <td>" . htmlspecialchars($row["fecha"]) . "</td>
                    <td>$" . htmlspecialchars($row["monto"]) . "</td>
                    <td>" . htmlspecialchars($row["sucursal"]) . "</td>
                  </tr>";
        }
        echo "</table></div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>
        No hay registros.
      </div>";
    }
?>
<!-- MODAL PARA PRECIO DE PROVEEDOR-->
<div class="modal fade modal-lg" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registro Precio</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <!-- Formulario para seleccionar producto -->
        <form action="" method="post" id="form-producto-precio">
          <label for="producto">Producto:</label>
          <select class="form-select" aria-label="Default select example" name="producto" id="producto-precio" required>
            <option value="">Seleccione un producto</option>
            <?php 
              $sql = "SELECT id_producto, nombre FROM productos";
              $stmt = $conexion->prepare($sql);
              $stmt->execute();
              $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
              foreach ($productos as $producto) {
                $selected = (isset($_POST['producto']) && $_POST['producto'] == $producto['id_producto']) ? 'selected' : '';
                echo "<option value='{$producto['id_producto']}' $selected>{$producto['nombre']}</option>";
              }
            ?>         
          </select> <br>
        </form>
        
        <!-- Formulario para actualizar el precio del proveedor -->
        <form action="../SCRIPTS/register_preciopro.php" method="post">
          <!-- Campo oculto para mantener el producto seleccionado -->
          <input type="hidden" name="producto" value="<?php echo isset($_POST['producto']) ? $_POST['producto'] : ''; ?>">

          <!-- Selección del Proveedor -->
          <label for="proveedor">Proveedor:</label>
          <select name="proveedor" id="proveedor-precio" required>
            <option value="">Seleccione un proveedor:</option>
            <?php
              if (isset($_POST['producto'])) {
                $producto_id = $_POST['producto'];

                $sql = "SELECT pp.id_provee_producto, p.nombre
                        FROM proveedor_producto pp
                        JOIN proveedores p ON pp.proveedor = p.id_proveedor
                        WHERE pp.producto = :producto_id";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':producto_id', $producto_id);
                $stmt->execute();
                $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($proveedores as $proveedor) {
                  echo "<option value='{$proveedor['id_provee_producto']}'>{$proveedor['nombre']}</option>";
                }
              }
            ?>
          </select>
          <br><br>

          <!-- Cantidad -->
          <div class="form-group">
            <label for="cantidad">Precio unitario:</label>
            <input type="number" name="cantidad" id="cantidad" required>
          </div>

          <!-- Botón de Enviar -->
          <button type="submit" class="btn btn-success" name="submit" value="Registrar">Registrar</button>
        </form>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>        
      </div>
      <script>
        document.getElementById('producto-precio').addEventListener('change', function() {
          document.getElementById('form-producto-precio').submit();
        });
      </script>
    </div>
  </div>
</div>


<!-- MODAL PARA REABASTECIMIENTO-->
<div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registro Compra</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <!-- Formulario para seleccionar producto -->
        <form action="" method="post" id="form-producto-reabastecimiento">
          <label for="producto">Producto:</label>
          <select class="form-select" aria-label="Default select example" name="producto" id="producto-reabastecimiento" required>
            <option value="">Seleccione un producto</option>
            <?php 
              $sql = "SELECT id_producto, nombre FROM productos";
              $stmt = $conexion->prepare($sql);
              $stmt->execute();
              $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

              foreach ($productos as $producto) {
                $selected = (isset($_POST['producto']) && $_POST['producto'] == $producto['id_producto']) ? 'selected' : '';
                echo "<option value='{$producto['id_producto']}' $selected>{$producto['nombre']}</option>";
              }
            ?>         
          </select> <br>
        </form>
        
        <!-- Formulario para registro de reabastecimiento -->
        <form action="../SCRIPTS/register_reabastecimiento.php" method="post">
          <!-- Campo oculto para mantener el producto seleccionado -->
          <input type="hidden" name="producto" value="<?php echo isset($_POST['producto']) ? $_POST['producto'] : ''; ?>">

          <!-- Selección del Proveedor -->
          <label for="proveedor">Proveedor:</label>
          <select name="proveedor" id="proveedor-reabastecimiento" required>
            <option value="">Seleccione un proveedor:</option>
            <?php
              if (isset($_POST['producto'])) {
                $producto_id = $_POST['producto'];

                $sql = "SELECT pp.id_provee_producto, p.nombre
                        FROM proveedor_producto pp
                        JOIN proveedores p ON pp.proveedor = p.id_proveedor
                        WHERE pp.producto = :producto_id";
                $stmt = $conexion->prepare($sql);
                $stmt->bindParam(':producto_id', $producto_id);
                $stmt->execute();
                $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($proveedores as $proveedor) {
                  echo "<option value='{$proveedor['id_provee_producto']}'>{$proveedor['nombre']}</option>";
                }
              }
            ?>
          </select>
          <br><br>

          <!-- Selección de Sucursal -->
          <label for="sucursal">Sucursal:</label>
          <select name="sucursal" id="sucursal" required>
            <option value="">Seleccione una sucursal:</option>
            <?php
              // Consulta de sucursales
              $sql = "SELECT id_sucursal, nombre FROM sucursales";
              $stmt = $conexion->prepare($sql);
              $stmt->execute();
              $sucursales = $stmt->fetchAll(PDO::FETCH_ASSOC);

              foreach ($sucursales as $sucursal) {
                echo "<option value='{$sucursal['id_sucursal']}'>{$sucursal['nombre']}</option>";
              }
            ?>
          </select>
          <br><br>

          <!-- Cantidad -->
          <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" name="cantidad" id="cantidad" required>
          </div>

          <!-- Fecha de Reabastecimiento -->
          <div class="form-group">
            <label for="fecha">Fecha de Reabastecimiento:</label>
            <input type="datetime-local" name="fecha" id="fecha" required>
          </div>

          <!-- Botón de Enviar -->
          <button type="submit" class="btn btn-success" name="submit" value="Registrar">Registrar</button>
        </form>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>        
      </div>
      <script>
        document.getElementById('producto-reabastecimiento').addEventListener('change', function() {
          document.getElementById('form-producto-reabastecimiento').submit();
        });
      </script>
    </div>
  </div>
</div>

</div>
</div>
</body>
</html> 