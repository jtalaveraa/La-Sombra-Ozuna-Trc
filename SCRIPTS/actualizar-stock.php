<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
}else{
    $id = '';
}


include('../CLASS/database.php'); // Asegúrate de incluir la conexión a la base de datos
$db = new Database();
$db->conectarBD();

$conn = $db->getPDO();


if (isset($_POST['detalleVentaId']) && isset($_POST['cantidad'])) {
    $nuevaCantidad = $_POST['cantidad'];
    $detalleVentaId = $_POST['detalleVentaId'];

    $consulta = $conn->prepare("UPDATE detalle_venta SET cantidad = $nuevaCantidad WHERE id_detalle = $detalleVentaId");
    $consulta->execute();

}
?>
