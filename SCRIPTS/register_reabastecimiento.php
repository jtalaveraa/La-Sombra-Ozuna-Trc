<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../CLASS/database.php";
    $db = new Database();
    $db->conectarBD();
    $conexion = $db->getPDO();

    // Verifica si se seleccionó un producto
    if (isset($_POST['producto']) && !isset($_POST['proveedor'])) {
        $producto_id = $_POST['producto'];
        // Redirecciona de nuevo a la página del formulario para mostrar los proveedores
        header("Location: ../VIEWS/reabastecimiento.php");
        exit;
    }

    // Verifica si se enviaron los datos para registrar el reabastecimiento
    if (isset($_POST['proveedor']) && isset($_POST['cantidad']) && isset($_POST['fecha']) && isset($_POST['sucursal'])) {
        $producto_proveedor = $_POST['proveedor'];
        $cantidad = $_POST['cantidad'];
        $fecha = $_POST['fecha'];
        $sucursal = $_POST['sucursal'];

        // Calcular el monto de la compra
        $sql = "SELECT precio_unitario_proveedor FROM proveedor_producto WHERE id_provee_producto = :producto_proveedor";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':producto_proveedor', $producto_proveedor);
        $stmt->execute();
        $precio_unitario = $stmt->fetchColumn();
        $monto_compra = $cantidad * $precio_unitario;

        // Insertar en la tabla reabastecimiento
        $sql = "INSERT INTO orden_compra(producto_proveedor, cantidad, fecha_orden_compra, monto_compra, sucursal)
                VALUES (:producto_proveedor, :cantidad, :fecha, :monto_compra, :sucursal)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':producto_proveedor', $producto_proveedor);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':monto_compra', $monto_compra);
        $stmt->bindParam(':sucursal', $sucursal);

        if ($stmt->execute()) {
            header("location: ../VIEWS/reabastecimiento.php");
            exit();
        } else {
            echo "Error al registrar el reabastecimiento.";
            header("refresh:3  ; ../VIEWS/reabastecimiento.php");
            exit();
        }
    }
}
?>

