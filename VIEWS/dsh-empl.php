<?php
session_start();
if ($_SESSION["rol"] != 1 || $_SESSION["rol"] == null) {
    header("location: ../VIEWS/iniciov2.php");
    exit();    
}
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';
include '../SCRIPTS/empleados-dsh.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/49e84e2ffb.js" crossorigin="anonymous"></script>

    <title>Empleados</title>
    <link rel="stylesheet" href="../CSS/dash-emp.css">
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
                        <a class="nav-link" style="background-color: limegreen;" href="#">EMPLEADOS</a>
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
                <form action="" class="d-flex row" method="post">
                    <div class="col-lg-4 col-sm-6 p-1 text-lg-end">
                        <select class="form-select" aria-label="Default select example" name="rol">
                            <option value="" disabled selected>Seleccione el rol a buscar</option>
                            <?php 
                            $sql = "SELECT id_rol, rol FROM roles";
                            $stmt = $conexion->prepare($sql);
                            $stmt->execute();
                            $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($roles as $rol) {
                            echo "<option value='{$rol['id_rol']}'>{$rol['rol']}</option>";
                            }
                            ?>  
                        </select>
                    </div>

                    <div class="botonprinci col-lg-4 col-sm-6 p-1 text-lg-start text-center">
                    <button id="regemp" name="btnfiltrar" type='submit' class='btn btn-emp''> Filtrar </button>
                    </div>

                    <div class="botonprinci col-lg-4 col-sm-6 p-1 text-lg-end text-center">
                    <button id="regemp" type='button' class='btn btn-emp' data-bs-toggle='modal' 
                    data-bs-target='#exampleModal'> Registrar Empleados </button>
                    </div>

                </form>

                
            </div>
        

       


<?php
    if (isset($_POST['btnfiltrar'])) {
       
        if($empelados){
            echo "<h2>Resultados de búsqueda:</h2>";        
            echo "<div class='tabla'><table border='1' class= 'table table-striped'>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th></th>
                    </tr>";
                    foreach ($empelados as $row) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["id"]) . "</td>
                                <td>" . htmlspecialchars($row["nombre"]) . "</td>
                                <td>" . htmlspecialchars($row["rol"]) . "</td>
                                <td>" . htmlspecialchars($row["email"]) . "</td>
                                <td>" . htmlspecialchars($row["telefono"]) . "</td>
                                <td><a href='modificar-empleado.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-success'><i class='fa-solid fa-pen-to-square'></i></a></td>
                              </tr>";
                    }
                    echo "</table></div>";
        }
        else{
            echo "<div class='alert alert-warning' role='alert'>
            No hay empleados registrados con ese rol.
          </div>";
        }


    } else {
    if ($results) {
        echo "<h2>Resultados de búsqueda:</h2>";        
        echo "<div class='tabla'><table border='1' class= 'table table-striped'>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th></th>
                </tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row["id"]) . "</td>
                    <td>" . htmlspecialchars($row["nombre"]) . "</td>
                    <td>" . htmlspecialchars($row["rol"]) . "</td>
                    <td>" . htmlspecialchars($row["email"]) . "</td>
                    <td>" . htmlspecialchars($row["telefono"]) . "</td>
                    <td><a href='modificar-empleado.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-success'><i class='fa-solid fa-pen-to-square'></i></a></td>
                  </tr>";
        }
        echo "</table></div>";
    } else {
        echo "<div class='alert alert-warning' role='alert'>
        No hay empleados registrados.
      </div>";
    }

}
?>
<br>

<nav aria-label="Paginación de productos">
        <ul class="pagination justify-content-center">
            <?php if ($pagina > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina - 1 ?>) ?>">Anterior</a>
                </li>
            <?php } ?>
            <?php for ($i = max(1, $pagina - 2); $i <= min($total_paginas, $pagina + 2); $i++) { ?>
                <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                    <a class="page-link" href="?pagina=<?= $i ?>) ?>"><?= $i ?></a>
                </li>
            <?php } ?>
            <?php if ($pagina < $total_paginas) { ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina + 1 ?>) ?>">Siguiente</a>
                </li>
            <?php } ?>
        </ul>
    </nav>  


<form action="" method="post">
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de Empleados</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form action="" method="post">
                <div class="row">
                    <div class="form-group">
                        <label for="username">Ingresa tu nombre de usuario:</label><br>
                        <input type="text" id="username" placeholder="Mínimo 8 caracteres" name="usuario" maxlength="15" required minlength="8" >
                    </div>
                    <div class="form-group">
                        <label for="email">Ingresa tu correo:</label><br>
                        <input type="email" id="email" placeholder="ejemplo@mail.com" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label><br>
                        <input type="text" id="telefono" placeholder="Ingresa tu telefono" name="telefono" maxlength="15" minlength="8" required >
                    </div>
                    <div class="form-group">
                        <label for="password">Ingresa tu contraseña:</label><br>
                        <input type="password" id="password" placeholder="Mínimo 8 caracteres" name="password" maxlength="20" minlength="8" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Confirma contraseña:</label><br>
                        <input type="password" id="password" placeholder="Confirma tu contraseña aquí" name="confirm_password" maxlength="20" minlength="8" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm-password">Nombre</label><br>
                        <input type="text" id="nombre" placeholder="Ingresa Nombre(s)" name="nombre" required>                        
                    </div>  
                    <div class="form-group">
                        <label for="confirm-password">Apellido Paterno:</label><br>
                        <input type="text" id="paterno" placeholder="Ingresa Apellido Paterno" name="paterno" required>
                    </div> 
                    <div class="form-group">
                        <label for="confirm-password">Apellido Materno:</label><br>
                        <input type="text" id="materno" placeholder="Ingresa Apellido Materno" name="materno" required>                        
                    </div> 
                    <div class="form-group">
                        <label for="confirm-password">RFC:</label><br>
                        <input type="text" id="rfc" placeholder="Ingresa RFC" name="rfc" required>                        
                    </div> 
                    <div class="form-group">
                        <label for="confirm-password">NSS:</label><br>
                        <input type="text" id="nss" placeholder="Ingresa NSS" name="nss" required>
                    </div> 
                    <div class="form-group">
                        <label for="confirm-password">CURP:</label><br>
                        <input type="text" id="curp" placeholder="Ingresa CURP" name="curp" required>
                    </div> 
                    <select class="form-select" aria-label="Default select example" name="rol" require>
                        <option selected value="2">Empleado</option>
                        <option value="1">Administrador</option>
                        <option value="4">Perforador</option>                        
                    </select> 
                </div> 
                <button id="regemp" type="submit" name="btncrearemp" class="btn">Registrar</button>     
            </form>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>        
      </div>
    </div>
  </div>
</div>
</div>
</div>
<script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>




</body>
</html>