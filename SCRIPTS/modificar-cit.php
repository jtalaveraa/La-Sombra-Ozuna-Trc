<?php
if (isset($_POST["btnupdatecit"])) {
    include "../CLASS/database.php";

    $db = new Database();
    $db->conectarBD();
    $PDOLOCAL = $db->getPDO();

    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $costo = $_POST["costo"];
    $perforacion = $_POST["perforacion"];
    $fecha_hora = $_POST["datetime"]; 
    $sucursal = $_POST["sucursal"];
    $comentarios = $_POST["comentarios"];
    $id = $_GET["id"];

    $check = $PDOLOCAL->prepare("SELECT COUNT(*) FROM empleado WHERE id_empleado = :perforador");
    $check->bindParam(':perforador', $perforador, PDO::PARAM_INT);
    $check->execute();
    $exists = $check->fetchColumn();



    $sql = "UPDATE citas
            SET nombre_cliente = :nombre, telefono = :telefono, costo = :costo,
                tipo_perforacion = :perforacion, fecha_hora = :fecha_hora, sucursal = :sucursal,
                comentarios = :comentarios
            WHERE id_cita = :id";

    $stmt = $PDOLOCAL->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':costo', $costo);
    $stmt->bindParam(':perforacion', $perforacion);
    $stmt->bindParam(':fecha_hora', $fecha_hora); 
    $stmt->bindParam(':sucursal', $sucursal);
    $stmt->bindParam(':comentarios', $comentarios);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Cita actualizada exitosamente.";
        header("Location: ../VIEWS/dash-citas.php"); 
        exit();
    } else {
        echo "Error al actualizar cita.";
    }
}
?>
