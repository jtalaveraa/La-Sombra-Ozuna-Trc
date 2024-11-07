<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA SOMBRA - OZUNA TRC</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/perforaciones.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>

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

    <div class="container">
            <div id="in" class="titulo row">
                <h1>PERFORACIONES</h1>
            </div>
            
            <div class="content row">
                <div class="about-text col-lg-6 col-sm-12">
                    <h3>Edgar Vilegas Requejo</h3>
                    <br>
                    <p>Edgar realizó dos cursos de perforación, uno de ellos con certificación como perforador.</p>
                    <p>Estamos seguros que donde quieras perforarte, Edgar tendrá mucho cuidado y te dará los mejores consejos de cuidado para tus perforaciones, contáctalo para agendar una cita!</p>
                </div>
                <div class="about-img col-lg-6 col-sm-12">
                    <img src="../IMG/elperforador.jpeg" alt="Perforador">
                </div>
            </div>

            <div class="content row">
            <div id="btn-wha" class="btn">
                    <a target="_blank" href="https://wa.me/+528712237759" class="btn btn-success cta-button">Genera tu cita con Edgar!</a>
                </div>
            </div>
            
            <div class="perforadores-lista">
                <?php
                
                $json_data = file_get_contents('../SCRIPTS/perforadores.json');
                $perforadores = json_decode($json_data, true);

                
foreach ($perforadores as $perforador) {
    echo '<div class="content row mb-4">';
    echo '<div class="about-text col-lg-6 col-sm-12">';
    echo '<h3>' . htmlspecialchars($perforador['nombre']) . '</h3>';
    echo '<p>' . htmlspecialchars($perforador['descripcion']) . '</p>';
    echo '</div>';
    echo '<div class="about-img col-lg-6 col-sm-12">';
    echo '<img src="../SCRIPTS/' . htmlspecialchars($perforador['imagen']) . '" alt="Perforador" class="img-fluid">';
    echo '</div>';
    
    echo '<div class="col-12">';
    echo '<a target="_blank" href="https://wa.me/' . htmlspecialchars($perforador['telefono']) . '" class="btn btn-success mt-2">Contactar por WhatsApp</a>';
    echo '</div>';

    if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1) {  
        echo '<div class="col-12 mt-2">';
        echo '<form action="../SCRIPTS/procesar_perforador.php" method="POST" style="display:inline;">';
        echo '<input type="hidden" name="nombre" value="' . htmlspecialchars($perforador['nombre']) . '">';
        echo '<input type="hidden" name="accion" value="eliminar">';
        echo '<button type="submit" class="btn btn-danger">';
        echo '<i class="fas fa-trash-alt"></i> ';
        echo '</button>';
        echo '</form>';
        echo '</div>';
    }

    echo '</div>';
}
?>

            
            </div>
        </div>
            <div class="perforaciones">
                <h2>Tipos de perforaciones que manejamos</h2>
                <div class="perforaciones-grid row">
                    <div class="col-lg-3 col-sm-6">
                        <img src="../IMG/ceja.webp" alt="Perforación 1">
                        <p>Ceja</p>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <img src="../IMG/oreja.jpg" alt="Perforación 2">
                        <p>Oreja</p>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <img src="../IMG/septum.jpg" alt="Perforación 3">
                        <p>Septum</p>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <img src="../IMG/ombligo.webp" alt="Perforación 4">
                        <p>Ombligo</p>
                    </div>
                </div>
            </div>
            
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1) { ?>
            <div class="content row">
            <div class="form-container"> 
                <h2>Agregar Perforador</h2>
                <form action="../SCRIPTS/procesar_perforador.php" method="POST" enctype="multipart/form-data">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required><br>

                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" required></textarea><br>

                    <label for="telefono">Teléfono:</label>
                    <input type="tel" id="telefono" name="telefono" required pattern="[0-9]{10}" title="Ingrese un número de teléfono válido de 10 dígitos."><br>

                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required><br>

                    <button type="submit">Registrar Perforador</button>
                </form>
            </div>
            </div>
            <?php } ?>


        <footer class="footer row">
            <div class=" offset-lg-1 col-lg-9 text col-sm-12 ">
                <p>Somos una empresa nacional con una trayectoria de 7 años en el mercado, especializada en ofrecer de manera responsable una amplia gama de accesorios para fumar, como pipas de cristal, bongs, bubblers y otros productos similares. Nuestro compromiso se refleja en la calidad y variedad de nuestro catálogo, diseñado para satisfacer las necesidades de nuestros clientes más exigentes.</p>
            </div>
            <div class="col-lg-1  col-sm-12 text-lg-end"><a href="https://www.facebook.com/people/La-Sombra-trc/100072525601731/" target="_blank"><img src="../ICONS/facebookwhite.png" alt="facebook"></a></div>
        </footer>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="../bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
        <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>

    </div>
</body>
</html>
