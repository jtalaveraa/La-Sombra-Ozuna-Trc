<?php
include "../CLASS/database.php";

$db = new Database();
$db->conectarBD();
$PDOLOCAL = $db->getPDO();

$id = $_GET['id'];
$precio = $_POST['precio'];

$sqlUpdate = "UPDATE proveedor_producto 
                SET precio_unitario_proveedor = :precio 
                WHERE id_provee_producto = :id";

$stmtUpdate = $PDOLOCAL->prepare($sqlUpdate);
$stmtUpdate->bindParam(':precio', $precio, PDO::PARAM_STR);
$stmtUpdate->bindParam(':id', $id, PDO::PARAM_INT);

if ($stmtUpdate->execute()) {
    echo "Precio actualizado con éxito.";
} else {
    echo "Error al actualizar el precio.";
}

// Redirigir de vuelta al dashboard o a la página de proveedores
header('Location: ../VIEWS/dash-provee.php');
?>
