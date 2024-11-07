<?php
include "../CLASS/database.php";

$db = new Database();
$db->conectarBD();
$PDOLOCAL = $db->getPDO();

$id = $_GET['id'];

// Obtener los datos del proveedor
$sqlProveedor = "SELECT * FROM proveedores WHERE id_proveedor = :id";
$stmtProveedor = $PDOLOCAL->prepare($sqlProveedor);
$stmtProveedor->bindParam(':id', $id, PDO::PARAM_INT);
$stmtProveedor->execute();
$proveedor = $stmtProveedor->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Proveedor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../CSS/modificar.css">
</head>
<body>

<form action="../SCRIPTS/modificar-prov.php?id=<?= $id ?>" method="post">
    <div class="form-group">
        <label for="nombre">Nombre del Proveedor:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required value="<?= htmlspecialchars($proveedor->nombre) ?>">
    </div>
    <div class="form-group">
        <label for="telefono">Teléfono:</label>
        <input type="tel" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($proveedor->telefono) ?>">
    </div>
    <div class="form-group">
        <label for="url">Página Web:</label>
        <input type="url" class="form-control" id="url" name="pagina" value="<?= htmlspecialchars($proveedor->pagina) ?>">
    </div>
    <button type="submit" name="btnupdateprov" class="btn btn-success">Modificar Proveedor</button>
    <br><br>
    <button type="submit" name="btnupdateprov" href="../VIEWS/dash-provee.php" class="btn btn-danger">Cancelar</button>
</form>

</body>
</html>
