<?php
session_start();
if ($_SESSION["rol"] == 3 || $_SESSION["rol"] == null) {
    header("location: ../VIEWS/iniciov2.php");
    exit();    
}

if ($_SESSION["sucursal"] == null) {
    header("location: ../VIEWS/CONTROL-SUCURSAL.php");
    exit();    
}

include '../SCRIPTS/llenar-venta.php';
?>

<?php
$_SESSION['marca'] = null;

if (isset($_GET['sucursal'])) {
    $_SESSION['sucursal'] = $_GET['sucursal'];
}

$sucursal = isset($_SESSION['sucursal']) ? $_SESSION['sucursal'] : null;

require '../SCRIPTS/config-prod.php';

// Sucursales
$db = new Database();
$db->conectarBD();
$conexion = $db->getPDO();

$nm_prod = isset($_GET["nm_prod"]) ? $_GET["nm_prod"] : '';
$categoria = isset($_GET["categoria"]) ? $_GET["categoria"] : '';
$productos_por_pagina = 20;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$pagina = $pagina > 0 ? $pagina : 1;
$inicio = ($pagina - 1) * $productos_por_pagina;

$sql = "SELECT DISTINCT p.id_producto AS id_producto, p.nombre AS nombre, 
        p.precio AS precio, ins.cantidad AS stock, c.nombre AS categoria, p.url
        FROM productos AS p
        JOIN producto_categoria AS pc ON p.id_producto = pc.producto
        JOIN categorias AS c ON pc.categoria = c.id_categoria
        JOIN inventario_sucursal AS ins ON p.id_producto = ins.id_producto 
        WHERE ins.cantidad > 0";

// Filtrar por sucursal
if ($sucursal) {
    $sql .= " AND ins.id_sucursal = :sucursal";
}

// Filtrar por nombre de producto
if ($nm_prod) {
    $sql .= " AND p.nombre LIKE :nm_prod";
}

// Filtrar por categoría
if ($categoria) {
    $sql .= " AND c.id_categoria = :categoria";
}

// Paginación
$sql .= " LIMIT :inicio, :productos_por_pagina";

$stmt = $conexion->prepare($sql);

if ($sucursal !== null) {
    $stmt->bindValue(':sucursal', $sucursal, PDO::PARAM_INT);
}
if ($nm_prod) {
    $stmt->bindValue(':nm_prod', '%' . $nm_prod . '%');
}
if ($categoria) {
    $stmt->bindValue(':categoria', $categoria, PDO::PARAM_INT);
}
$stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
$stmt->bindValue(':productos_por_pagina', $productos_por_pagina, PDO::PARAM_INT);

$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_sql = "SELECT COUNT(DISTINCT p.id_producto)
            FROM productos AS p
            JOIN producto_categoria AS pc ON p.id_producto = pc.producto
            JOIN inventario_sucursal AS ins ON p.id_producto = ins.id_producto
            JOIN categorias AS c ON pc.categoria = c.id_categoria
            WHERE ins.cantidad > 0";

if ($sucursal !== null) {
    $total_sql .= " AND ins.id_sucursal = :sucursal";
}
if ($nm_prod) {
    $total_sql .= " AND p.nombre LIKE :nm_prod";
}
if ($categoria) {
    $total_sql .= " AND c.id_categoria = :categoria";
}

$total_stmt = $conexion->prepare($total_sql);

if ($sucursal !== null) {
    $total_stmt->bindValue(':sucursal', $sucursal, PDO::PARAM_INT);
}
if ($nm_prod) {
    $total_stmt->bindValue(':nm_prod', '%' . $nm_prod . '%');
}
if ($categoria) {
    $total_stmt->bindValue(':categoria', $categoria, PDO::PARAM_INT);
}
$total_stmt->execute();
$total_productos = $total_stmt->fetchColumn();
$total_paginas = ceil($total_productos / $productos_por_pagina);

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llenado Venta</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/productos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/49e84e2ffb.js" crossorigin="anonymous"></script>
</head>
<body>
<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
    .card-title {
        font-weight: 500;
    }
    .offcanvas-title {
        font-weight: 600;
    }
</style>
<div class="container" id="in">
    <!-- Botón para salir de la página -->
    <a href="../VIEWS/dash-ventas.php" class="btn btn-danger mt-3 float-end">
    <i class="bi bi-x-circle"></i> Salir
    </a>

    <div class="container">
        <div class="text-center">
            <p style="margin-top: 0px;">Actualmente estás registrando para la sucursal: <?php if($sucursal == 1){echo "Matamoros";}else{echo "Nazas";} ;?></p>
        </div>
    </div>

    <div class="search-bar mb-3">
    <form method="get" action="">
    <div class="row g-3">
        <div class="col-md-6 col-lg-4 p-1">
            <input type="text" class="form-control" placeholder="Buscar artículo..." name="nm_prod" value="<?php echo htmlspecialchars($nm_prod); ?>">
        </div>
        <div class="col-md-4 col-lg-4 p-1">
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
        <div class="col-md-2 col-lg-4 p-1">
            <button type="submit" class="btn btn-primary w-100">Buscar</button>
        </div>
    </div>
</form>

<div class="btn-cart-container">
    <button class="btn btn-success btn-cart" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
        <i class="fa fa-shopping-cart"></i>
    </button>
</div>



    </div>
    
    <?php if ($_SESSION['sucursal'] !== null) { ?>
        <div class="row">
        <?php foreach ($productos as $row) { ?>
    <div class="col-lg-3 col-sm-12">
        <div class="card mb-3 shadow-sm rounded">
            <div class="card-img-container p-3">
                <img class="img-pro" src="<?php echo $row['url'] ?? '../IMG/PRODUCTOS/notfound.png'; ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" class="card-img-top">
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($row['nombre']); ?></h5>
                <p class="card-text text-muted">$ <?php echo htmlspecialchars($row['precio']); ?></p>
                <p class="card-text"><small class="text-success"><?php echo htmlspecialchars($row['stock']); ?> piezas disponibles</small></p>
                <form action="" method="post" class="d-flex align-items-center justify-content-between">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id_producto']); ?>">
                    <select name="cantidad" class="form-select me-2" style="width: auto;">
                        <?php
                        $max_cantidad = min($row['stock'], 5); // Mínimo entre stock y 5
                        for ($i = 1; $i <= $max_cantidad; $i++) {
                            echo "<option value=\"$i\" " . ($i == 1 ? 'selected' : '') . ">$i</option>";
                        }
                        ?>
                    </select>
                    <button name="btn-reg" type="submit" class="btn btn-success">
                        <i class="bi bi-cart-plus"></i> Agregar
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php } ?>         
        </div>
    <?php } ?>
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

<div class="offcanvas offcanvas-start bg-light shadow-sm rounded" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header bg-light">    
        <h5 class="offcanvas-title" id="staticBackdropLabel">REGISTRO</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Subtotal</th>            
                </tr>
            </thead>
            <tbody>
                <?php foreach ($details as $row) {?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($row['precio']); ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="dv" value="<?php echo htmlspecialchars($row['id']);?>">
                            <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>                    
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <form action="" method="post">
            <select name="pago" class="form-select mb-2">
                <option value="EFECTIVO">EFECTIVO</option>
                <option value="TARJETA">TARJETA</option>
            </select>
            <button type="submit" name="registrar_venta" class="btn btn-primary w-100">Registrar Venta</button>                
        </form>
    </div>
</div>
    
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast <?php echo $producto_agregado ? 'show' : ''; ?>" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Notificación</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Producto agregado exitosamente, dirígete al carrito.
        </div>
    </div>
    <style>
        .toast {
    background-color: #333; 
    color: #f1f1f1; 
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5); 
}

.toast-header {
    background-color: #444; 
    color: #f1f1f1;
    border-bottom: 1px solid #555;
}

.toast-body {
    background-color: #333; 
    color: #f1f1f1; 
}

.btn-close {
    color: #f1f1f1; 
}

    </style>
</div>


</body>
</html>
