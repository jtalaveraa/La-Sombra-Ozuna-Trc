<?php
include "../CLASS/database.php";

$db = new Database();
$db->conectarBD();
$PDOLOCAL = $db->getPDO();

$id = $_GET['id'];

// Obtener los datos del proveedor-producto
$sqlProveedor = "SELECT pp.id_provee_producto, p.nombre AS producto_nombre, pr.nombre AS proveedor_nombre, pp.precio_unitario_proveedor AS precio 
                 FROM proveedor_producto pp
                 INNER JOIN productos p ON pp.producto = p.id_producto
                 INNER JOIN proveedores pr ON pp.proveedor = pr.id_proveedor
                 WHERE pp.id_provee_producto = :id";

$stmtProveedor = $PDOLOCAL->prepare($sqlProveedor);
$stmtProveedor->bindParam(':id', $id, PDO::PARAM_INT);
$stmtProveedor->execute();
$proveedor = $stmtProveedor->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar precio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>   
    <link rel="stylesheet" href="../CSS/modificar.css"> 
</head>
<body>
<form action="../SCRIPTS/modificar-prprov.php?id=<?= $id ?>" method="post">
    <div class="form-group">
        <label for="proveedor_nombre">Nombre del Proveedor:</label>
        <input type="text" class="form-control" id="proveedor_nombre" name="proveedor_nombre" required value="<?= htmlspecialchars($proveedor->proveedor_nombre) ?>" readonly>
    </div>
    <div class="form-group">
        <label for="producto_nombre">Nombre del Producto:</label>
        <input type="text" class="form-control" id="producto_nombre" name="producto_nombre" value="<?= htmlspecialchars($proveedor->producto_nombre) ?>" readonly>
    </div>
    <div class="form-group">
        <label for="precio">Precio:</label>
        <input type="text" class="form-control" id="precio" name="precio" value="<?= htmlspecialchars($proveedor->precio) ?>">
    </div>
    <button type="submit" name="btnupdateprov" class="btn btn-success">Modificar Precio</button>
    <br><br>
    <button type="submit" name="btnupdateprov" href="../VIEWS/dash-provee.php" class="btn btn-danger">Cancelar</button>
</form>

</body>
</html>