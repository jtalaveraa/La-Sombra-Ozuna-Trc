<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$suc = $_SESSION['sucursal'];
$usuario = $_SESSION['id'];
$id = isset($_POST["id"]) ? $_POST["id"] : '';
$pago = isset($_POST["pago"]) ? $_POST["pago"] : '';
$cantidad = isset($_POST["cantidad"]) ? $_POST["cantidad"] : '';
$control = isset($_SESSION['control']) ? $_SESSION['control'] : 1;
$venta = isset($_SESSION['venta']) ? $_SESSION['venta'] : null;

$dv =  isset($_POST["dv"]) ? $_POST["dv"] : '';


include "../CLASS/database.php";
$db = new Database();
$db->conectarBD();

$conexion = $db->getPDO();

$consulta = $conexion->prepare("SELECT id_empleado FROM empleado
        JOIN persona ON empleado.persona = persona.id_persona
        JOIN usuarios ON persona.usuario = usuarios.id_usuario
        WHERE id_usuario = $usuario");

$consulta->execute();
$emp = $consulta->fetch(PDO::FETCH_ASSOC)['id_empleado'];
$producto_agregado = false;

if ($_SESSION['sucursal'] == null) {
    $sql = $sql = "SELECT id_producto, nombre, descripcion, precio, stock 
    FROM productos WHERE stock > 0";
    $stmt = $conexion->prepare($sql);
}
else{
if ($_SESSION['sucursal'] == '2') {
    $sql = "SELECT id_producto, nombre, descripcion, precio, stock 
    FROM productos_nazas WHERE stock > 0";
    $stmt = $conexion->prepare($sql);
}
if ($_SESSION['sucursal'] == '1') {
    $sql = "SELECT id_producto, nombre, descripcion, precio, stock 
    FROM productos_matamoros WHERE stock > 0";
    $stmt = $conexion->prepare($sql);
}
}    


$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$details=[];

$llenado = $conexion->prepare("INSERT INTO detalle_venta(venta,producto,cantidad) 
VALUES(?,?,?)");

$detalles = $conexion->prepare("SELECT MIN(dv.id_detalle) AS id, 
           dv.producto AS id_producto, 
           p.nombre AS nombre, 
           SUM(dv.cantidad) AS cantidad, 
           p.precio AS precio_unitario, 
           SUM(dv.cantidad) * p.precio AS precio 
    FROM detalle_venta dv
    JOIN productos p ON dv.producto = p.id_producto
    WHERE dv.venta = ?
    GROUP BY dv.producto, p.nombre, p.precio
    ORDER BY p.nombre ASC
");

$detalles->bindParam(1, $venta, PDO::PARAM_INT);
$detalles->execute();
$details = $detalles->fetchAll(PDO::FETCH_ASSOC);

$registrar = $conexion->prepare("UPDATE venta SET estado = 'COMPLETADA', tipo_pago = ? WHERE id_venta = ?");

$eliminar = $conexion->prepare("DELETE FROM detalle_venta WHERE id_detalle = ?");

if (isset($_POST['btn-reg'])) {
    if ($control == 1) {    
        $insert = $conexion->prepare("INSERT INTO venta(id_empleado,estado,tipo_venta,sucursal)
        VALUES(?,'PENDIENTE','FISICA',?)");   
        $insert->bindParam(1, $emp, PDO::PARAM_INT); 
        $insert->bindParam(2, $suc, PDO::PARAM_INT); 
        $insert->execute();

        $venta_consulta = $conexion->prepare("SELECT id_venta FROM venta ORDER BY id_venta DESC LIMIT 1");
        $venta_consulta->execute();
        $venta = $venta_consulta->fetch(PDO::FETCH_ASSOC)['id_venta'];

        $_SESSION['control'] = 2;
        $_SESSION['venta'] = $venta;
    }

    if (isset($venta)) {
        $llenado->bindParam(1, $venta, PDO::PARAM_INT);
        $llenado->bindParam(2, $id, PDO::PARAM_INT);
        $llenado->bindParam(3, $cantidad, PDO::PARAM_INT);
        $llenado->execute();

        $detalles->bindParam(1, $venta, PDO::PARAM_INT);
        $detalles->execute();
        $details = $detalles->fetchAll(PDO::FETCH_ASSOC);
        $producto_agregado = true;
        
    }
}    

if (isset($_POST['registrar_venta'])) {
    if (isset($venta)) {
        $registrar->bindParam(2,$venta,PDO::PARAM_INT);
        $registrar->bindParam(1,$pago,PDO::PARAM_STR);
        $registrar->execute();


        $_SESSION['control'] = 1;
        unset($_SESSION['venta']);
    }

    header("Location: ../VIEWS/dash-ventas.php");
}

if (isset($_POST['eliminar'])) {
    $eliminar->bindParam(1, $dv, PDO::PARAM_INT);
    $eliminar->execute();

    $detalles->bindParam(1, $venta, PDO::PARAM_INT);
    $detalles->execute();
    $details = $detalles->fetchAll(PDO::FETCH_ASSOC);
}

$pdo = null; 


?>