<?php
if (isset($_POST["btnupdateprov"])) {
    include "../CLASS/database.php";

    $db = new Database();
    $db->conectarBD();
    $PDOLOCAL = $db->getPDO();
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $pagina = $_POST["pagina"];
    $id = $_GET["id"];

    $sql = "UPDATE proveedores
            SET nombre = :nombre, telefono = :telefono, pagina = :pagina
            WHERE id_proveedor = :id";

    $stmt = $PDOLOCAL->prepare($sql);
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':pagina', $pagina);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Proveedor actualizado exitosamente.";
        header("Location: ../VIEWS/DASH-PROVEE.php"); 
        exit();
    } else {
        echo "Error al actualizar proveedor.";
    }
}
?>
