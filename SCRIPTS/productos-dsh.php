<?php  
if (isset($_GET['sucursal'])) {
    $_SESSION['sucursal'] = $_GET['sucursal'];
}

$sucursal = isset($_SESSION['sucursal']) ? $_SESSION['sucursal'] : null;
include "../CLASS/database.php";
$db = new Database();
$db->conectarBD();

$conexion = $db->getPDO();

$nm_prod = isset($_GET["nm_prod"]) ? $_GET["nm_prod"] : '';
$id_prod = isset($_GET["id_prod"]) ? $_GET["id_prod"] : '';
$categoria = isset($_GET["categoria"]) ? $_GET["categoria"] : '';
$sucursal = isset($_GET["sucursal"]) ? $_GET["sucursal"] : '';

$productos_por_pagina = 30;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$pagina = $pagina > 0 ? $pagina : 1;
$inicio = ($pagina - 1) * $productos_por_pagina;

$des = isset($_GET["desc"]) ? $_GET["desc"] : '';
$nombre = isset($_GET["nombre"]) ? $_GET["nombre"] : '';
$marca = '';
if (isset($_GET["contact"])) {
    if ($_GET["contact"] == 'otro') {
        $marca = $_GET["extra"];
    }
    else  {
        $marca = isset($_GET["contact"]);
    }
}
if (isset($_GET['logout'])) {
    session_unset(); 
    session_destroy();  

    header("Location: ../VIEWS/iniciov2.php");      
    exit();
}

$precio = isset($_GET["precio"]) ? $_GET["precio"] : '';
$catego = isset($_GET["cate"]) ? $_GET["cate"] : '';
$provee = isset($_GET["proveedores"]) ? $_GET["proveedores"] : '';
$material = isset($_GET["material"]) ? $_GET["material"] : '';


$proveedores = "SELECT nombre, id_proveedor AS id FROM proveedores";
$cate = "SELECT nombre, id_categoria AS id FROM categorias";

$st = $conexion->prepare($proveedores);
$s = $conexion->prepare($cate);

$sql = "SELECT DISTINCT p.id_producto AS id_producto, p.nombre AS nombre, 
        p.precio AS precio, p.stock AS stock, c.nombre AS categoria
        FROM productos AS p
        JOIN producto_categoria AS pc ON p.id_producto = pc.producto
        JOIN categorias AS c ON pc.categoria = c.id_categoria
        JOIN inventario_sucursal AS ins ON p.id_producto = ins.id_producto 
        WHERE 1=1";

        $parametros = [];


if ($sucursal) {
    if ($sucursal != '3') {
        $sql = "SELECT DISTINCT p.id_producto AS id_producto, p.nombre AS nombre, 
        p.precio AS precio, ins.cantidad AS stock, c.nombre AS categoria
        FROM productos AS p
        JOIN producto_categoria AS pc ON p.id_producto = pc.producto
        JOIN categorias AS c ON pc.categoria = c.id_categoria
        JOIN inventario_sucursal AS ins ON p.id_producto = ins.id_producto 
        WHERE 1=1";
        $sql .= " AND ins.id_sucursal = :sucursal";
        $parametros[':sucursal'] = $sucursal;    
    }
    
}
if ($nm_prod) {
    $sql .= " AND p.nombre LIKE :nm_prod";
    $parametros[':nm_prod'] = '%' . $nm_prod . '%';
}
if ($id_prod) {
    $sql .= " AND p.id_producto = :id_prod";
    $parametros[':id_prod'] = $id_prod;
}
if ($categoria ) {
    $sql .= " AND c.id_categoria = :categoria";
    $parametros[':categoria'] = $categoria;
}
if ($sucursal) {
    $sql .= " AND ins.id_sucursal = :sucursal";
    $parametros[':sucursal'] = $sucursal;
}

// Paginación
$sql .= " LIMIT $inicio, $productos_por_pagina";

$stmt = $conexion->prepare($sql);

// Vinculación de todos los parámetros
foreach ($parametros as $key => $value) {
    $stmt->bindValue($key, $value);
}

$stmt->execute();
$st->execute();
$s->execute();

echo "Número de resultados: " . $stmt->rowCount();

$cat = $s->fetchAll(PDO::FETCH_ASSOC);
$prov = $st->fetchAll(PDO::FETCH_ASSOC);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Definir la consulta inicial para contar el total de productos
$total_sql = "SELECT COUNT(DISTINCT p.id_producto) 
              FROM productos AS p
              JOIN producto_categoria AS pc ON p.id_producto = pc.producto
              JOIN categorias AS c ON pc.categoria = c.id_categoria
              JOIN inventario_sucursal AS ins ON p.id_producto = ins.id_producto 
              WHERE 1=1";
if ($sucursal ) {
    $total_sql .= " AND ins.id_sucursal = :sucursal";
}
if ($nm_prod != null) {
    $total_sql .= " AND p.nombre LIKE :nm_prod";
}
if ($categoria != null) {
    $total_sql .= " AND c.id_categoria = :categoria";
}

$total_stmt = $conexion->prepare($total_sql);
if ($sucursal) {
    $total_stmt->bindValue(':sucursal', $sucursal, PDO::PARAM_INT);
}
if ($nm_prod != null) {
    $total_stmt->bindValue(':nm_prod', '%' . $nm_prod . '%');
}
if ($categoria != null) {
    $total_stmt->bindValue(':categoria', $categoria, PDO::PARAM_INT);
}
$total_stmt->execute();
$total_productos = $total_stmt->fetchColumn();
$total_paginas = ceil($total_productos / $productos_por_pagina);


$pdo = null;

/*
$pral = $conexion->prepare("INSERT INTO productos(nombre,marca,precio,stock,material,descripcion,url) VALUES(?,?,?,0,?,?,?)");
if (isset($_GET['btnreg'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $nombreArchivo = $_FILES['img']['name'];
            $temporal = $_FILES['img']['tmp_name'];
            $carpeta = '../IMG';
    
            $url = $carpeta . '/' . $nombreArchivo;
    
            if (move_uploaded_file($temporal, $url)) {
                echo "La imagen se ha subido correctamente. Puedes verla <a href='$url'>aquí</a>.";
                header("Location: ../VIEWS/dashboard.php");
                exit();

            
    

    $pral->bindParam(1, $nombre, PDO::PARAM_STR);
    $pral->bindParam(2, $marca, PDO::PARAM_STR);
    $pral->bindParam(3, $precio, PDO::PARAM_STR);
    $pral->bindParam(4, $material, PDO::PARAM_STR);
    $pral->bindParam(5, $des, PDO::PARAM_STR);
    $pral->bindParam(6, $url, PDO::PARAM_STR);

    $pral->execute();

    $ns = $conexion->prepare("SELECT id_producto FROM productos ORDER BY id_producto DESC LIMIT 1");
    $ns->execute();
    $id_p = $ns->fetch(PDO::FETCH_ASSOC)['id_producto'];
    
    $ll_cat = $conexion->prepare("INSERT INTO producto_categoria (producto,categoria) VALUES (:id,:cat)");
    foreach ($catego as $opcion) {
        $ll_cat->bindParam(':id', $id_p, PDO::PARAM_INT);
        $ll_cat->bindParam(':cat', $opcion, PDO::PARAM_STR);
        $ll_cat->execute(); 
    }
    
    $ll_prpro = $conexion->prepare("INSERT INTO proveedor_producto (proveedor,producto,precio_unitario_proveedor) VALUES (:prove,:id,0)");
    foreach ($provee as $opcion) {
        $opcion_int = intval($opcion);
        $ll_prpro->bindParam(':prove', $opcion_int, PDO::PARAM_INT);
        $ll_prpro->bindParam(':id', $id_p, PDO::PARAM_INT);
        $ll_prpro->execute(); 
    }
            } else {
                echo "Hubo un error al subir la imagen.";
            }
        } else {
            echo "No se ha seleccionado ningún archivo o hubo un error en la subida.";
        }
    }
    header("Location: ../VIEWS/dashboard.php");
}
*/

/*
//AÑADIR UN PRODUCTO
if (isset($_POST['btnreg'])) {
    $db = new Database();
    $db->conectarBD();
    $conexion = $db->getPDO();

    $nombre = $_POST['nombre'];
    $marca = $_POST['contact'] === 'otro' ? $_POST['extra'] : $_POST['contact'];
    $precio = $_POST['precio'];
    $material = $_POST['material'];
    $des = $_POST['desc'];
    $catego = $_POST['cate'];
    $provee = $_POST['proveedores'];

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['img']['name'];
        $temporal = $_FILES['img']['tmp_name'];
        $carpeta = '../IMG';
        $url = $carpeta . '/' . $nombreArchivo;

        if (move_uploaded_file($temporal, $url)) {
            $pral = $conexion->prepare("INSERT INTO productos(nombre, marca, precio, stock, material, descripcion, url) VALUES (?, ?, ?, 0, ?, ?, ?)");
            $pral->bindParam(1, $nombre, PDO::PARAM_STR);
            $pral->bindParam(2, $marca, PDO::PARAM_STR);
            $pral->bindParam(3, $precio, PDO::PARAM_STR);
            $pral->bindParam(4, $material, PDO::PARAM_STR);
            $pral->bindParam(5, $des, PDO::PARAM_STR);
            $pral->bindParam(6, $url, PDO::PARAM_STR);

            if ($pral->execute()) {
                $id_p = $conexion->lastInsertId();

                $ll_cat = $conexion->prepare("INSERT INTO producto_categoria (producto, categoria) VALUES (:id, :cat)");
                foreach ($catego as $opcion) {
                    $ll_cat->bindParam(':id', $id_p, PDO::PARAM_INT);
                    $ll_cat->bindParam(':cat', $opcion, PDO::PARAM_STR);
                    $ll_cat->execute(); 
                }

                $ll_prpro = $conexion->prepare("INSERT INTO proveedor_producto (proveedor, producto, precio_unitario_proveedor) VALUES (:prove, :id, 0)");
                foreach ($provee as $opcion) {
                    $opcion_int = intval($opcion);
                    $ll_prpro->bindParam(':prove', $opcion_int, PDO::PARAM_INT);
                    $ll_prpro->bindParam(':id', $id_p, PDO::PARAM_INT);
                    $ll_prpro->execute(); 
                }

                header("Location: ../VIEWS/dashboard.php");
                exit();
            } else {
                echo "Hubo un error al registrar el producto.";
            }
        } else {
            echo "Hubo un error al subir la imagen.";
        }
    } else {
        echo "No se ha seleccionado ningún archivo o hubo un error en la subida.";
    }
}
*/
If (isset($_POST['btnreg'])) {
    $db = new Database();
    $db->conectarBD();
    $conexion = $db->getPDO();

    $nombre = $_POST['nombre'];
    $marca = $_POST['contact'] === 'otro' ? $_POST['extra'] : $_POST['contact'];
    $precio = $_POST['precio'];
    $material = $_POST['material'];
    $des = $_POST['desc'];
    $catego = $_POST['cate'];
    $provee = $_POST['proveedores'];

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['img']['name'];
        $temporal = $_FILES['img']['tmp_name'];
        $carpeta = '/var/www/html/IMG';  // Usar ruta absoluta
        $url = $carpeta . '/' . $nombreArchivo;

        // Depuración: Imprimir la ruta absoluta
        echo "Ruta absoluta de la carpeta: " . realpath($carpeta) . "<br>";
        echo "Ruta completa del archivo: " . $url . "<br>";

        if (move_uploaded_file($temporal, $url)) {
            $pral = $conexion->prepare("INSERT INTO productos(nombre, marca, precio, stock, material, descripcion, url) VALUES (?, ?, ?, 0, ?, ?, ?)");
            $pral->bindParam(1, $nombre, PDO::PARAM_STR);
            $pral->bindParam(2, $marca, PDO::PARAM_STR);
            $pral->bindParam(3, $precio, PDO::PARAM_STR);
            $pral->bindParam(4, $material, PDO::PARAM_STR);
            $pral->bindParam(5, $des, PDO::PARAM_STR);
            $pral->bindParam(6, $url, PDO::PARAM_STR);

            if ($pral->execute()) {
                $id_p = $conexion->lastInsertId();

                $ll_cat = $conexion->prepare("INSERT INTO producto_categoria (producto, categoria) VALUES (:id, :cat)");
                foreach ($catego as $opcion) {
                    $ll_cat->bindParam(':id', $id_p, PDO::PARAM_INT);
                    $ll_cat->bindParam(':cat', $opcion, PDO::PARAM_STR);
                    $ll_cat->execute(); 
                }

                $ll_prpro = $conexion->prepare("INSERT INTO proveedor_producto (proveedor, producto, precio_unitario_proveedor) VALUES (:prove, :id, 0)");
                foreach ($provee as $opcion) {
                    $opcion_int = intval($opcion);
                    $ll_prpro->bindParam(':prove', $opcion_int, PDO::PARAM_INT);
                    $ll_prpro->bindParam(':id', $id_p, PDO::PARAM_INT);
                    $ll_prpro->execute(); 
                }

                header("Location: ../VIEWS/dashboard.php");
                exit();
            } else {
                echo "Hubo un error al registrar el producto.";
            }
        } else {
            echo "Hubo un error al mover la imagen.";
            var_dump(error_get_last());  // Para depuración
        }
    } else {
        echo "No se ha seleccionado ningún archivo o hubo un error en la subida.";
        switch ($_FILES['img']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                echo "El archivo excede el tamaño máximo permitido.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                echo "El archivo excede el tamaño máximo permitido en el formulario.";
                break;
            case UPLOAD_ERR_PARTIAL:
                echo "El archivo se ha subido parcialmente.";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "No se ha subido ningún archivo.";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo "Falta el directorio temporal.";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                echo "No se puede escribir el archivo en el disco.";
                break;
            case UPLOAD_ERR_EXTENSION:
                echo "Una extensión de PHP detuvo la subida del archivo.";
                break;
            default:
                echo "Error desconocido.";
                break;
        }
    }
}



function get_selected_categories($producto_id, $PDOLOCAL) {
    $selected_categories = [];

    
    $stmt = $PDOLOCAL->prepare("SELECT categoria FROM producto_categoria WHERE producto = :producto_id");
    $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
    $stmt->execute();


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $selected_categories[] = $row['categoria'];
    }

    return $selected_categories;
}



function get_selected_providers($producto_id, $PDOLOCAL) {
    $selected_providers = [];

    
    $stmt = $PDOLOCAL->prepare("SELECT proveedor FROM proveedor_producto WHERE producto = :producto_id");
    $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
    $stmt->execute();

    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $selected_providers[] = $row['proveedor'];
    }

    return $selected_providers;
}




?>

<?php

// MODIFICAR PRODUCTO
if (!empty($_POST["btnsubmit"])) {
    if (!empty($_POST["nombre"]) && !empty($_POST["marca"]) && !empty($_POST["cate"]) 
        && !empty($_POST["proveedores"]) && !empty($_POST["precio"]) 
        && !empty($_POST["material"]) && !empty($_POST["desc"])) {
        
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $marca = $_POST["marca"];
        $precio = $_POST["precio"];
        $material = $_POST["material"];
        $descripcion = $_POST["desc"];
        
        include '../CLASS/database.php';
        $db = new Database();
        $db->conectarBD();
        $conexion = $db->getPDO();

        $sql = "UPDATE productos SET nombre = :nombre, marca = :marca, precio = :precio, 
                material = :material, descripcion = :descripcion WHERE id_producto = :id";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':marca', $marca, PDO::PARAM_STR);
        $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
        $stmt->bindParam(':material', $material, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Producto actualizado exitosamente.</div>";
            header("Location: ../VIEWS/dashboard.php");
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "<div class='alert alert-danger'>Error al actualizar el producto: " . $errorInfo[2] . "</div>";
        }
        
    } else {
        echo "<div class='alert alert-warning'>Por favor, complete todos los campos requeridos.</div>";
    }
}
?>
