<?php

    include '../SCRIPTS/productos-bien.php';
    require '../SCRIPTS/config-prod.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - La Sombra</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/productos.css">

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
                    
                    
            </div>x 
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
<div class="container" id="in">
    <div class="search-bar mb-3">
        <form method="get" action="">
            <div class="row g-3">
                <div class="col-md-6 col-lg-7 p-1">
                    <input type="text" class="form-control" placeholder="Buscar artículo..." name="nm_prod" value="<?php echo htmlspecialchars($nm_prod); ?>">
                </div>
                <div class="col-md-4 col-lg-2 p-1">
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
                <div class="col-md-6 col-lg-2 p-1">
                    <select class="form-control" name="sucursal">
                        <option value="1" <?php if ($sucursal == 1) echo 'selected'; ?>>Matamoros</option>
                        <option value="2" <?php if ($sucursal == 2) echo 'selected'; ?>>Nazas</option>
                    </select>
                </div>
                <div class="col-md-2 col-lg-1 p-1">
                    <button type="submit" class="btn btn-primary btn-reg">Buscar</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">      
        <?php
        if (!empty($results)) {
            foreach ($results as $row) { ?>
                <div class="col-lg-4 col-sm-12">
                    <div class="card mb-4">
                        <a href="../VIEWS/detalle_producto.php?id=<?php echo $row['id_producto']; ?>&token=<?php 
                echo hash_hmac('sha256', $row['id_producto'], K_TOKEN); ?>">
                            <div class="card-img-container p-3">                 
                                <img class="img-pro" src="<?php echo $row['url'] ?? '../IMG/PRODUCTOS/notfound.png'; ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" class="card-img-top">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                                <p class="card-text">$ <?php echo $row['precio']; ?></p>
                                <?php if($row['stock'] <= 0){?>
                                <p class="card-text">Articulo no disponble</p> <?php } else{ ?>
                                <p class="card-text"><?php echo $row['stock']; ?> piezas disponibles</p> <?php } ?>
                            </div>
                        </a>
                    </div>
                </div>          
            <?php
            }
        } else {
            echo "No hay productos disponibles";
        }
        ?>           
    </div>
        
    <nav aria-label="Paginación de productos">
        <ul class="pagination justify-content-center">
            <?php if ($pagina > 1) { ?>
                <li class="page-item">
                    <a class="page-link" href="?pagina=<?= $pagina - 1 ?>&nm_prod=<?= urlencode($nm_prod) ?>&categoria=<?= urlencode($categoria) ?>&sucursal=<?= urlencode($sucursal) ?>">Anterior</a>
                </li>
            <?php } ?>
            <?php for ($i = max(1, $pagina - 2); $i <= min($total_paginas, $pagina + 2); $i++) { ?>
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
</div>
        <footer class="footer row">
            <div class="offset-lg-1 col-lg-9 text">
                <p>Somos una empresa nacional con una trayectoria de 7 años en el mercado, especializada en ofrecer de manera responsable una amplia gama de accesorios para fumar, como pipas de cristal, bongs, bubblers y otros productos similares. Nuestro compromiso se refleja en la calidad y variedad de nuestro catálogo, diseñado para satisfacer las necesidades de nuestros clientes más exigentes.</p>
            </div>
            <div class="col-lg-1 rs"><a href="https://www.facebook.com/people/La-Sombra-trc/100072525601731/" target="_blank"><img src="../ICONS/facebookwhite.png" alt="facebook"></a></div>
        </footer>
    </div> 

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>




