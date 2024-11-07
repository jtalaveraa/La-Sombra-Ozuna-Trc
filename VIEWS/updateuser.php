<?php


include "../CLASS/database.php";

$db = new Database();
$db->conectarBD();

$conexion = $db->getPDO();
session_start(); 



if(isset($_GET['upd'])) $iduser = $_GET['upd'];

$sql = "SELECT * FROM usuarios WHERE id_usuario = :id";
$stmt = $conexion->prepare($sql);
$stmt ->bindParam(":id",$iduser);
$stmt->execute();
$count = $stmt->rowCount();

if($count > 0){
    $datos = $stmt->fetch();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar datos</title>
    <link type="text/css" rel="stylesheet" href="../CSS/updateusuario.css">

    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
</head>
<body class="body">
<header>
<nav id="contenedor-todo" class="navbar navbar-dark  fixed-top">
    <div  class="container">
    <div class="row align-items-center">
    

    <div class="col-md-3 d-none d-lg-flex justify-content-start">
            <div class="user-cart dropdown">
                <?php
                    if(isset($_SESSION["id"])) 
                    { ?>
                    
                    <a href='../VIEWS/detalle-cuenta.php'><img src='../ICONS/user.png' alt='cart'></a>
                    <?php }

                    else{ ?>
                    <a href='../VIEWS/inicio-sesion.php'><img src='../ICONS/user.png' alt='cart'></a>
                    
                    <?php } ?>
                    
                    <a href="../VIEWS/carrito.php"><img src="../ICONS/cart.png" alt="cart"></a>
            </div>
        </div>


    <div id="logo" class="col-6 col-lg-4 order-1 order-lg-3 text-start text-lg-end logo">
        <a href="#in"><img src="../IMG/sombra-logo.jpg" alt="La Sombra"></a>
    </div>

    <div class="col-6 col-lg-4 text-end order-2 order-lg-4">
        
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <div class="logo">
                <a href="#in"><img src="../IMG/sombra-logo.jpg" alt="La Sombra"></a>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div  id="body-burger"   class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="../VIEWS/iniciov2.php">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/productos.php">PRODUCTOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/perforaciones.php">PERFORACIONES</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/carrito.php">CARRITO</a>
                    </li>
                    
                    <?php
                    if(isset($_SESSION["rol"]) && $_SESSION["rol"] == 3) 
                    { ?>
                    
                        <li class='nav-item'>
                        <a class='nav-link' href='../VIEWS/detalle-cuenta.php'>CUENTA</a>
                        </li>

                        <li class='nav-item'>

                        <a class='nav-link' href='../SCRIPTS/cerrarsesion.php'>
                            <button id="cerrar" class="btn btn-danger"> CERRAR SESION</button>
                        </a>
                        </li>
                    <?php }

                    else{ ?>
                        <li class='nav-item'>
                        <a class='nav-link' href='../VIEWS/inicio-sesion.php'>CUENTA</a>
                        </li>
                    <?php } ?>
                    
                    
                    
                    <div  class="admin">
                    
                    <?php  if(isset($_SESSION["rol"]) && $_SESSION["rol"] == 1 || $_SESSION["rol"] == 2) {?>
                            <li id="panel" class='nav-item'>
                            <button class="btn btn-success">
                                    <a class='nav-link' href='../VIEWS/dash-ventas.php'>PANEL DE ADMINISTRADOR</a>
                                </button>
                            </li>
                    <?php } else if (isset($_SESSION["rol"]) && $_SESSION["rol"] == 4) {?>
                    <li id="panel" class='nav-item'>
                            <button class="btn btn-success">
                                    <a class='nav-link' href='../VIEWS/dash-citas.php'>PANEL DE PERFORADOR</a>
                                </button>
                            </li>
                    <?php }?>
                    </div>

                    <div class="contacto">
                        <p>Whatsapp: 8715066383</P>
                        <p>Correo: lasombratrc@hotmail.com</P>
                    </div>
                    

                </ul>
            </div>
        </div>
    </div>
    </div>
    </div>
    </nav>
</header>

<div id="containerdata"  class="container m-auto">
    <div class="my-3 text-center d-flex flex-row justify-content-center"><p><h1>Actualizar Usuario</h1></p></div>

    <form action="../SCRIPTS/upd.php" method="post">
        <div class="form-group">
            <input type="hidden" name="id" value="<?= $datos['id_usuario']?>">
            <input type="text" name="username" id="username" class="form-control" required maxlength="15"  minlength="8" placeholder="Nombre de usuario" value="<?= $datos['nombre_usuario']?> ">
        </div>

        <div class="form-group">
            <input type="email" name="email" id="email" class="form-control" required placeholder="Email" value="<?= $datos['email']?>">
        </div>

        <div class="form-group">
            <input type="text" name="telefono" id="telefono" class="form-control" required maxlength="15"  minlength="8" placeholder="Telefono" value="<?= $datos['telefono']?>">
        </div>
        <input id="actualizar" type="submit" value="Actualizar" class="btn btn-success"> <button class="btn btn-danger">Regresar</button>

    </form>
</div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>

