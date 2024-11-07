<?php
$ventas = [];
$detalles = [];
include "../CLASS/database.php";
$db = new Database();
$db->conectarBD();
$conexion = $db->getPDO();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['numero_pedido']) && isset($_POST['estado'])) {
        $numero_pedido = $_POST['numero_pedido'];
        $estado = $_POST['estado'];

        $sql = "SELECT v.id_venta, u.nombre_usuario, v.estado, v.tipo_venta, v.monto_total, s.nombre AS sucursal
                FROM venta v
                JOIN cliente c ON v.id_cliente = c.id_cliente
                LEFT JOIN persona p ON c.persona = p.id_persona
                LEFT JOIN usuarios u ON p.usuario = u.id_usuario
                LEFT JOIN sucursales s ON v.sucursal = s.id_sucursal
                WHERE v.id_venta = :numero_pedido AND v.estado = :estado";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':numero_pedido', $numero_pedido);
        $stmt->bindParam(':estado', $estado);
        $stmt->execute();
        $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_GET['logout'])) {
            session_unset(); 
            session_destroy();  
            header("Location: ../VIEWS/iniciov2.php");      
            exit();
        }
    }

    // Detalles de venta
    if (isset($_POST['venta_id'])) {
        $idVenta = $_POST['venta_id'];
        try {
            $stmt_detalles = $conexion->prepare("
                SELECT p.nombre, p.precio, dv.cantidad, v.monto_total
                FROM venta v
                JOIN detalle_venta dv ON dv.venta = v.id_venta
                JOIN productos p ON dv.producto = p.id_producto
                WHERE dv.venta = :idVenta;
            ");
            $stmt_detalles->bindParam(':idVenta', $idVenta, PDO::PARAM_INT);
            $stmt_detalles->execute();
            $detalles = $stmt_detalles->fetchAll(PDO::FETCH_ASSOC);

            if ($detalles && count($detalles) > 0) {
                echo '<table class="table table-borderless">';
                echo '<thead><tr><th>Producto</th><th>Precio</th><th>Cantidad</th></tr></thead>';
                echo '<tbody>';
                foreach ($detalles as $detalle) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($detalle['nombre']) . '</td>';
                    echo '<td>' . htmlspecialchars($detalle['precio']) . '</td>';
                    echo '<td>' . htmlspecialchars($detalle['cantidad']) . '</td>';
                    echo '</tr>';
                }
                echo '</tbody></table>';
                echo '<table class="table table-borderless">';
                echo '<thead> <tr> <th></th> </thead>';
                echo '<tbody>';
                echo '<tr>';
                echo '<td>  <b>Total:</b> $' . htmlspecialchars($detalles[0]['monto_total']) . '</td>';
                echo '</tr>';
                echo '</tbody></table>';
            } else {
                echo '<div class="alert alert-warning">No se encontraron detalles para esta compra.</div>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $db->desconectarBD();
        }
    } 
}
?>
