<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }
    require '../SCRIPTS/detalle-prod.php';
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = 0;
    }   
    
    if (isset($_SESSION['id'])) {
        $venta = $_SESSION['id'];    
    }
    else{
        $venta = '';
    }

    // Inicializa la variable $sucursal
    $sucursal = isset($_SESSION['sucursal']) ? $_SESSION['sucursal'] : null;


    if($venta){
    $consulta = $conexion->prepare("SELECT v.sucursal from venta as v join cliente as c on v.id_cliente = c.id_cliente
    join persona as p on c.persona = p.id_persona join usuarios as u on p.usuario
    = u.id_usuario where u.id_usuario = $venta and v.estado = 'CARRITO'");
    $consulta->execute();
    $sucuact = $consulta->fetch(PDO::FETCH_ASSOC);

     // Verificar si se obtuvo un resultado
    if ($sucuact) {
        $sucuact = $sucuact['sucursal'];
    } else {
        // Manejo del caso cuando no hay resultado
        $sucuact = null;
    }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - La Sombra</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/detalle_producto.css">
    <script>
       const toastTrigger = document.getElementById('liveToastBtn')
        const toastLiveExample = document.getElementById('liveToast')

        if (toastTrigger) {
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
            toastTrigger.addEventListener('click', () => {
            toastBootstrap.show()
            })
        }
    </script>
</head>
<body>
<?php  ?>
<header>
<nav id="contenedor-todo" class="navbar navbar-dark  fixed-top">
    <div  class="container">
    <div class="row align-items-center">
    

    <div class="col-md-3 d-none d-lg-flex justify-content-start">
    <div class="user-cart dropdown">
                <?php
                    if(isset($_SESSION["rol"]) && $_SESSION['rol'] == 3) 
                    { ?>
                    
                    <a href='../VIEWS/detalle-cuenta.php'><img src='../ICONS/user.png' alt='cart'></a>

                    <a href="../VIEWS/carrito.php"><img src="../ICONS/cart.png" alt="cart"></a>
                    <?php }

                    else{ ?>
                    <a href='../VIEWS/inicio-sesion.php'><img src='../ICONS/user.png' alt='cart'></a>
                    <a href="../VIEWS/inicio-sesion.php"><img src="../ICONS/cart.png" alt="cart"></a>
                    <?php } ?>
                    
                    
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
                    
                    <?php
                    if(isset($_SESSION["rol"]) && $_SESSION["rol"] == 3) 
                    { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/carrito.php">CARRITO</a>
                    </li>
                    
                    
                    
                        <li class='nav-item'>
                        <a class='nav-link' href='../VIEWS/detalle-cuenta.php'>CUENTA</a>
                        </li>
                    <?php } ?>

                    <?php if (!isset($_SESSION['id'])) { ?>
                        <li class='nav-item'>
                        <a class='nav-link' href='../VIEWS/inicio-sesion.php'>CUENTA</a>
                        </li>

                        <li class="nav-item">
                        <a class="nav-link" href="../VIEWS/inicio-sesion.php">CARRITO</a>
                        </li>
                    <?php } ?>
                    

                    <?php if (isset($_SESSION['id'])) { ?>
                    <li class='nav-item'>
                        <a class='nav-link' href='../SCRIPTS/cerrarsesion.php'>
                            <button id="cerrar" class="btn btn-danger"> CERRAR SESION</button>
                        </a>
                        </li>
                    <?php } ?>
                    
                    
                    
                    <?php  if(isset($_SESSION["rol"]) && $_SESSION['rol'] == 1) {?>
                            <div  class="admin">
                                <li id="panel" class='nav-item'>
                                    <button class="btn btn-success">
                                        <a class='nav-link' href='../VIEWS/dash-ventas.php'>PANEL DE ADMINISTRADOR</a>
                                    </button>
                                </li>
                            </div>
                    <?php } else if (isset($_SESSION["rol"]) && $_SESSION['rol'] == 4) {?>
                            <div  class="admin">
                                <li id="panel" class='nav-item'>
                                    <button class="btn btn-success">
                                        <a class='nav-link' href='../VIEWS/dash-citas.php'>PANEL DE PERFORADOR</a>
                                    </button>
                                </li>
                            </div>
                    <?php } else if(isset($_SESSION["rol"]) && $_SESSION['rol'] == 2){ ?>
                            <div  class="admin">
                                <li id="panel" class='nav-item'>
                                    <button class="btn btn-success">
                                        <a class='nav-link' href='../VIEWS/dash-ventas.php'>PANEL DE EMPLEADO</a>
                                    </button>
                                </li>
                            </div>
                    <?php } ?>
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
<?php ?>
    <div class="container" id="in">
        <div class="row" style="padding-top: 150px;">
            <div class="col-lg-6 col-sm-12">                                
                <img src="<?php echo $url; ?>" alt="<?php echo $nombre;?>" class="img-fluid">
            </div>
            <div class="col-lg-6 col-sm-12">
                <h1><?php echo $nombre;?></h1>
                <h2>$ <?php echo $precio;?></h2>
                <p><strong>Cantidad disponible:</strong> <?php echo $stock;?> piezas</p>
                <form action="" method="post">
                <select class="form-control" name="cantidad">
                <?php for ($i = 1; $i <= $stock && $i <= 5; $i++) { ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php } ?>
            </select> <br> <br>
                <button  <?php if ($_SESSION['carrito'] > 20) {
                    echo " id='liveToastBtn' type='button'";                    
                } else if($sucuact != null) {  if($sucuact != $sucursal) { echo " id='liveToastBtn' type='button' disabled ";} }
                else if($sucuact == $sucursal){ echo "type='submit' name='btncarrito' "; } ?>  class="btn btn-pink btn-lg
                <?php if ($stock <= 0 || !isset($_SESSION["sucursal"]) || !isset($_SESSION["id"]) || $_SESSION['rol'] != 3 /*|| $sucuact != $sucursal*/) {
                    echo "disabled";
                }?>"type='submit' name='btncarrito'>AGREGAR A CARRITO <?php /* echo $sucursal; echo $sucuact;*/?></button>
                </form>
                <?php if (isset($_POST['btncarrito'])) { ?>
                    <br>
                    <div class="alert alert-success" role="alert">
                    Tu solicitud se agregó correctamente a tu carrito, puedes ir a checarlo si gustas.
                </div>
                <?php } ?>   
                
                <?php if($sucuact != null) { ?>
                <?php if ($sucuact != $sucursal && $sucursal != null) { ?>
                    <br>
                    <div class="alert alert-danger" role="alert">
                    Estas en diferente sucursal a la de tu carrito, cambia tu sucursal o completa tu pedido en la otra sucursal para agregar de la nueva sucursal.
                </div>
                <?php } ?>  
                <?php } ?>  
                
                <?php 
                    if (!isset($_SESSION["id"])) {                                            
                ?>
                <div class="alert alert-warning" role="alert">
                    Inicie sesión para poder ordenar
                </div>
                <?php } elseif (!isset($_SESSION['sucursal'])) {                
                    ?>
                <div class="alert alert-warning" role="alert">
                    Seleccione una sucursal para poder ordenar
                </div>
                    <div class="container">
                        <h5 style="text-align: center;">Seleccione una sucursal:</h5> <br>
                        <form method="post" action="" style="text-align:center">                            
                            <button type="submit" class="btn btn-secondary" name="nazas">Nazas</button>
                            <button type="submit" class="btn btn-success" name="matamoros">Matamoros</button>
                        </form>
                    </div>
                </div>
                <?php } ?>

                <div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="..." class="rounded me-2" alt="...">
      <strong class="me-auto">ALERTA</strong>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      TIENES DEMASIADOS ARTICULOS EN TU CARRITO, CONFIRMA TU PEDIDO Y RECOGELO PARA PODER ORDENAR MÁS
    </div>
  </div>
</div>

        </div>
        <h2 class="mt-5">Productos relacionados:</h2>
        <div class="row">
            <?php 
            
            foreach($row2 as $row) {?>

        <div class="col-lg-4 col-sm-12">
                <div class="card mb-4">
                    <a href="../VIEWS/detalle_producto.php?id=<?php echo $row['id_producto'];?>&token=<?php 
                echo hash_hmac('sha256',$row['id_producto'],K_TOKEN);?>">
                    <div class="card-img-container">
                    <?php
                            if ($row['url'] == null) {  ?>
                                <img src="../IMG/PRODUCTOS/notfound.png" alt="<?php echo $row['nombre']; ?>" class="card-img-top">
                            <?php } 
                            else { ?>
                                <img src="<?php echo $row['url']; ?>" alt="<?php echo $row['nombre']; ?>" class="card-img-top">
                            <?php } ?>                                                                        
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                        <p class="card-text">$ <?php echo $row['precio']; ?></p>
                        <p class="card-text"><?php echo $row['stock']; ?> piezas disponibles</p>
                    </div>
                    </a>
                </div>
            </div>
            <?php } ?>            
        </div>
        <footer class="footer row">
            <div class="col-lg-11 text">
                <p>Somos una empresa nacional con una trayectoria de 7 años en el mercado, especializada en ofrecer de manera responsable una amplia gama de accesorios para fumar, como pipas de cristal, bongs, bubblers y otros productos similares. Nuestro compromiso se refleja en la calidad y variedad de nuestro catálogo, diseñado para satisfacer las necesidades de nuestros clientes más exigentes.</p>
            </div>
            <div class="col-lg-1 rs"><a href="https://www.facebook.com/people/La-Sombra-trc/100072525601731/" target="_blank"><img src="../ICONS/facebookwhite.png" alt="facebook"></a></div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>        

</body>
</html>