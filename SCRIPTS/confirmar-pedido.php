<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include "../CLASS/database.php";
    $db = new Database();
    $db->conectarBD();
    $conexion = $db->getPDO();

    $id_venta = $_POST['id_venta'];

    $sql = "UPDATE venta SET estado = 'COMPLETADA' WHERE id_venta = :id_venta ";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':id_venta', $id_venta);
    $stmt->execute();

    header("Location: ../VIEWS/dash-apartados.php");
    exit;
}

?>
