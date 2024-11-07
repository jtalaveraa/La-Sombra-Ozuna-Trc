<?php


include "../CLASS/database.php";
$db = new Database();
$db->conectarBD();

$conexion = $db->getPDO();


# CONSULTA PARRA MOSTRAR LOS REABASTECIMIENTOS
$ordenes = $conexion->prepare(" SELECT p.nombre AS producto, oc.cantidad AS cantidad,
oc.fecha_orden_compra AS fecha, oc.monto_compra AS monto,
s.nombre AS sucursal FROM orden_compra AS oc JOIN 
proveedor_producto AS prpr ON oc.producto_proveedor =
prpr.id_provee_producto JOIN productos AS p ON prpr.producto
= p.id_producto JOIN sucursales AS s ON oc.sucursal =
s.id_sucursal
ORDER BY 
oc.fecha_orden_compra DESC;");

$ordenes->execute();

$or = $ordenes->fetchAll(PDO::FETCH_ASSOC);


# CONSULTA PARA MOSTRAR LOS PRODUCTOS QUE SURTE DETERMINADO PROVEEDOR
$stmt = $conexion->prepare("SELECT prpr.id_provee_producto AS id,
p.nombre AS nombre, p.marca AS marca FROM productos AS p
JOIN proveedor_producto AS prpr ON p.id_producto = prpr.producto
JOIN proveedores AS pro ON prpr.proveedor = pro.id_proveedor
WHERE pro.id_proveedor = :proveedor");


if (isset($_GET['logout'])) {
    session_unset(); 
    session_destroy();  

    header("Location: ../VIEWS/iniciov2.php");      
    exit();
}

?>