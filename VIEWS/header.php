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