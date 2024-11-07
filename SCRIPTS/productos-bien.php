<?php
define('SESSION_STARTED', true);
session_start();

$_SESSION['marca'] = null;

if (isset($_GET['sucursal'])) {
    $_SESSION['sucursal'] = $_GET['sucursal'];
}

$sucursal = isset($_SESSION['sucursal']) ? $_SESSION['sucursal'] : null;

include "../CLASS/database.php";
require '../SCRIPTS/config-prod.php';

// Conectar a la base de datos
$db = new Database();
$db->conectarBD();
$conexion = $db->getPDO();

$nm_prod = isset($_GET["nm_prod"]) ? $_GET["nm_prod"] : '';
$categoria = isset($_GET["categoria"]) ? $_GET["categoria"] : '';
$productos_por_pagina = 18;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$pagina = $pagina > 0 ? $pagina : 1;
$inicio = ($pagina - 1) * $productos_por_pagina;

$sql = "SELECT DISTINCT p.id_producto AS id_producto, p.nombre AS nombre, 
        p.precio AS precio, ins.cantidad AS stock, c.nombre AS categoria, p.url
        FROM productos AS p
        JOIN producto_categoria AS pc ON p.id_producto = pc.producto
        JOIN categorias AS c ON pc.categoria = c.id_categoria
        JOIN inventario_sucursal AS ins ON p.id_producto = ins.id_producto 
        WHERE 1 = 1";

$parametros = [];

// Filtrar por sucursal
if ($sucursal) {
    $sql .= " AND ins.id_sucursal = :sucursal";
    $parametros[':sucursal'] = $sucursal;
}

// Filtrar por nombre de producto
if ($nm_prod) {
    $sql .= " AND p.nombre LIKE :nm_prod";
    $parametros[':nm_prod'] = '%' . $nm_prod . '%';
}

// Filtrar por categoría
if ($categoria) {
    $sql .= " AND c.id_categoria = :categoria";
    $parametros[':categoria'] = $categoria;
}

// Paginación
$sql .= " LIMIT $inicio, $productos_por_pagina";

$stmt = $conexion->prepare($sql);

// Enlazar parámetros
foreach ($parametros as $key => $value) {
    $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
}

$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Contar el total de productos
$total_sql = "SELECT COUNT(DISTINCT p.id_producto) as total
            FROM productos AS p
            JOIN producto_categoria AS pc ON p.id_producto = pc.producto
            JOIN inventario_sucursal AS ins ON p.id_producto = ins.id_producto
            JOIN categorias AS c ON pc.categoria = c.id_categoria
            WHERE 1 = 1";

if ($sucursal != null) {
    $total_sql .= " AND ins.id_sucursal = :sucursal";
}
if ($nm_prod != null) {
    $total_sql .= " AND p.nombre LIKE :nm_prod";
}
if ($categoria != null) {
    $total_sql .= " AND c.id_categoria = :categoria";
}

$total_stmt = $conexion->prepare($total_sql);

if ($sucursal != null) {
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

$db->desconectarBD();
?>
