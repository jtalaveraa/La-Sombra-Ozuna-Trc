<?php
session_start();
if ($_SESSION["rol"] != 1 || $_SESSION["rol"] == null) {
    header("location: ../VIEWS/iniciov2.php");
    exit();    
}
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Usuario';
include '../SCRIPTS/provee-dsh.php';

// Variables para la paginación
$productosPorPagina = 10; // Número de resultados por página
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($paginaActual > 1) ? ($paginaActual * $productosPorPagina) - $productosPorPagina : 0;

// FILTRADO
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : (isset($_GET['categoria']) ? $_GET['categoria'] : '');
$provee = isset($_POST['provee']) ? $_POST['provee'] : (isset($_GET['provee']) ? $_GET['provee'] : '');

$filteredResults = [];
$params = [];

$sql = "SELECT p.nombre AS producto_nombre, pr.nombre AS proveedor_nombre, pp.precio_unitario_proveedor AS precio,
        pp.id_provee_producto
        FROM proveedor_producto pp
        INNER JOIN productos p ON pp.producto = p.id_producto
        INNER JOIN proveedores pr ON pp.proveedor = pr.id_proveedor";

// Construir la cláusula WHERE
$whereClauses = [];
if (!empty($categoria) && $categoria != 'todos') {
    $whereClauses[] = "p.id_producto = ?";
    $params[] = $categoria;
}

if (!empty($provee) && $provee != 'todos') {
    $whereClauses[] = "pr.id_proveedor = ?";
    $params[] = $provee;
}

if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}

// Contar el total de registros filtrados
$sqlCount = "SELECT COUNT(*) AS total FROM ($sql) AS subquery";
$stmt = $conexion->prepare($sqlCount);
$stmt->execute($params);
$totalResultados = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Añadir límites de paginación
$sql .= " LIMIT $inicio, $productosPorPagina";
$stmt = $conexion->prepare($sql);
$stmt->execute($params);
$filteredResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular el número total de páginas
$totalPaginas = ceil($totalResultados / $productosPorPagina);
// Rango de páginas para mostrar en la paginación
$maxVisiblePages = 5; // Número máximo de páginas visibles
$paginaInicio = max(1, $paginaActual - floor($maxVisiblePages / 2));
$paginaFin = min($totalPaginas, $paginaInicio + $maxVisiblePages - 1);

if ($paginaFin - $paginaInicio + 1 < $maxVisiblePages) {
    $paginaInicio = max(1, $paginaFin - $maxVisiblePages + 1);
}
// Determinar la página siguiente
$paginaSiguiente = $paginaActual < $totalPaginas ? $paginaActual + 1 : $totalPaginas;
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
    <link rel="stylesheet" href="../CSS/productos-proveedores.css">
</head>
<body>
<div class="d-flex">
    <div class="container-fluid">
        <div class="row">
        <div><a href="../VIEWS/dash-provee.php" class="btn btn-danger mt-3 float-end">
    <i class="bi bi-x-circle" ></i> Salir
    </a></div>
        </div>
        
    
        <div class="forms">
            <form method="get" class="d-flex row" role="search">
                <div class="col-lg-4 col-sm-6 p-2">
                    <select class="form-select" aria-label="Default select example" name="categoria">
                        <option value="todos" <?php echo empty($categoria) || $categoria == 'todos' ? 'selected' : ''; ?>>Todos los productos</option>
                        <?php 
                            $sql = "SELECT id_producto, nombre FROM productos";
                            $stmt = $conexion->prepare($sql);
                            $stmt->execute();
                            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($productos as $producto) {
                                $selected = ($categoria == $producto['id_producto']) ? 'selected' : '';
                                echo "<option value='{$producto['id_producto']}' $selected>{$producto['nombre']}</option>";
                            }
                        ?>  
                    </select>
                </div>

                <div class="col-lg-4 col-sm-6 p-2">
                    <select class="form-select" aria-label="Default select example" name="provee">
                        <option value="todos" <?php echo empty($provee) || $provee == 'todos' ? 'selected' : ''; ?>>Todos los proveedores</option>
                        <?php 
                            $sql = "SELECT id_proveedor, nombre FROM proveedores";
                            $stmt = $conexion->prepare($sql);
                            $stmt->execute();
                            $proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($proveedores as $proveedor) {
                                $selected = ($provee == $proveedor['id_proveedor']) ? 'selected' : '';
                                echo "<option value='{$proveedor['id_proveedor']}' $selected>{$proveedor['nombre']}</option>";
                            }
                        ?>  
                    </select>
                </div>

                <div class="botonprinci col-lg-4 col-sm-6 p-2 text-start-lg text-center-sm">
                    <button name="btnfiltrar" id="botonfiltrar" type='submit' class='btn btn-success' style="width: 100%">Filtrar </button>
                </div>

                <!-- Añadido parámetro de página 1 para el filtro -->
                <input type="hidden" name="pagina" value="1">
            </form>
            

            <?php
            if (!empty($filteredResults)) {
                echo "<div class='table-responsive'><table class='table table-hover'>
                    <tr>
                        <th>Producto</th>
                        <th>Proveedor</th>
                        <th>Precio</th>
                    </tr>";
                foreach ($filteredResults as $row) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['producto_nombre']) . "</td>
                        <td>" . htmlspecialchars($row['proveedor_nombre']) . "</td>
                        <td>" . htmlspecialchars($row['precio']) . "</td>
                        <td><a href='modificarpreciopro.php?id=" . htmlspecialchars($row['id_provee_producto']) . "' class='btn btn-success'><i class='fa-solid fa-pen-to-square'></i></a></td>
                    </tr>";
                }
                echo "</table></div>";
            } else {
                echo "<h2>No se encontraron resultados.</h2>";
            }

            // Construir la paginación
            echo "<nav aria-label='Page navigation example'><ul class='pagination justify-content-center'>";

            // Botón de Página Anterior
            if ($paginaActual > 1) {
                $paginaAnterior = $paginaActual - 1;
                echo "<li class='page-item'>
                        <a class='page-link' href='?pagina=$paginaAnterior&categoria=$categoria&provee=$provee' aria-label='Previous'>
                            <span aria-hidden='true'>&laquo;</span>
                        </a>
                      </li>";
            }

            // Mostrar páginas antes y después de la página actual
            for ($i = $paginaInicio; $i <= $paginaFin; $i++) {
                $query_params = [
                    'pagina' => $i,
                    'categoria' => $categoria,
                    'provee' => $provee
                ];
                $query_string = http_build_query($query_params);

                echo "<li class='page-item " . ($i == $paginaActual ? 'active' : '') . "'>
                        <a class='page-link' href='?$query_string'>$i</a>
                      </li>";
            }

            // Botón de Página Siguiente
            if ($paginaActual < $totalPaginas) {
                echo "<li class='page-item'>
                        <a class='page-link' href='?pagina=$paginaSiguiente&categoria=$categoria&provee=$provee' aria-label='Next'>
                            <span aria-hidden='true'>&raquo;</span>
                        </a>
                      </li>";
            }

            echo "</ul></nav>";
            ?>
        </div>
    </div>
</body>
</html>
