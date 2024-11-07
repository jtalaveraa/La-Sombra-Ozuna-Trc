<?php

    include "../CLASS/database.php";
    $db = new Database();
    $db->conectarBD();
    
    $conexion = $db->getPDO();

$sql = "SELECT id_proveedor AS id ,nombre, telefono, pagina FROM proveedores";
$stm = $conexion->prepare($sql);
$stm->execute();

$insert = $conexion->prepare("INSERT INTO proveedores(nombre,telefono,pagina) 
VALUES(?,?,?)");

$results = $stm->fetchAll(PDO::FETCH_ASSOC);

$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
$telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : '';
$url = isset($_POST["url"]) ? $_POST["url"] : '';
if (isset($_GET['logout'])) {
    session_unset(); 
    session_destroy();  

    header("Location: ../VIEWS/iniciov2.php");      
    exit();
}
if (isset($_POST['btnreg'])) {
    $insert->bindParam(1, $nombre, PDO::PARAM_STR);
    $insert->bindParam(2, $telefono, PDO::PARAM_STR);
    $insert->bindParam(3, $url, PDO::PARAM_STR);
    $insert->execute();
}

//FILTRADO

$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
$provee = isset($_POST['provee']) ? $_POST['provee'] : '';

$filteredResults = [];
if (isset($_POST['btnfiltrar'])) {
    $sql = "SELECT p.nombre AS producto_nombre, pr.nombre AS proveedor_nombre, pp.precio_unitario_proveedor AS precio,
            pp.id_provee_producto
            FROM proveedor_producto pp
            INNER JOIN productos p ON pp.producto = p.id_producto
            INNER JOIN proveedores pr ON pp.proveedor = pr.id_proveedor";

    $whereClauses = [];
    $params = [];

    if (!empty($categoria)) {
        $whereClauses[] = "p.id_producto = ?";
        $params[] = $categoria;
    }

    if (!empty($provee)) {
        $whereClauses[] = "pr.id_proveedor = ?";
        $params[] = $provee;
    }

    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    $stmt = $conexion->prepare($sql);
    $stmt->execute($params);
    $filteredResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}



?>