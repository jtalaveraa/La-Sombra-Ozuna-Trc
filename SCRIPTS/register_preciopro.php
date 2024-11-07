<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../CLASS/database.php";
    $db = new Database();
    $db->conectarBD();
    $conexion = $db->getPDO();

    if (isset($_POST['producto']) && !isset($_POST['proveedor'])) {
        $producto_id = $_POST['producto'];
        // Redirecciona de nuevo a la página del formulario para mostrar los proveedores
        header("Location: ../VIEWS/reabastecimiento.php");
        exit;
    }

    if (isset($_POST['proveedor']) && isset($_POST['cantidad'])) {
        $producto_proveedor = $_POST['proveedor'];
        $cantidad = $_POST['cantidad'];

        //update del precio unitario de ese producto con ese proveedor
        $sql="UPDATE proveedor_producto
                SET precio_unitario_proveedor = :cantidad
                WHERE  id_provee_producto = :producto_proveedor";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':producto_proveedor', $producto_proveedor);
        $stmt->bindParam(':cantidad', $cantidad);

        
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