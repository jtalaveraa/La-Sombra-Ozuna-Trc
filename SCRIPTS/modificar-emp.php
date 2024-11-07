<?php
if (isset($_POST["btnupdateemp"])) {
    include "../CLASS/database.php";

    $db = new Database();
    $db->conectarBD();
    $PDOLOCAL = $db->getPDO();

    $usuario = $_POST["usuario"];
    $email = $_POST["email"];
    $telefono = $_POST["telefono"];
    $nombre = $_POST["nombre"];
    $paterno = $_POST["paterno"];
    $materno = $_POST["materno"];
    $rfc = $_POST["rfc"];
    $nss = $_POST["nss"];
    $curp = $_POST["curp"];
    $rol = $_POST["rol"];
    $id = $_GET["id"];

    $sql = "UPDATE empleado e
            JOIN persona p ON e.persona = p.id_persona
            JOIN usuarios u ON p.usuario = u.id_usuario
            JOIN rol_usuario ru ON u.id_usuario = ru.usuario
            SET u.nombre_usuario = :usuario, u.email = :email, u.telefono = :telefono,
                e.nombres = :nombre, e.ap_paterno = :paterno, e.ap_materno = :materno,
                e.rfc = :rfc, e.nss = :nss, e.curp = :curp, ru.rol = :rol
            WHERE e.id_empleado = :id";

    $stmt = $PDOLOCAL->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':paterno', $paterno);
    $stmt->bindParam(':materno', $materno);
    $stmt->bindParam(':rfc', $rfc);
    $stmt->bindParam(':nss', $nss);
    $stmt->bindParam(':curp', $curp);
    $stmt->bindParam(':rol', $rol);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Empleado actualizado exitosamente.";
        header("Location: ../VIEWS/dsh-empl.php"); 
        exit();
    } else {
        echo "Error al actualizar empleado.";
    }
}
?>
