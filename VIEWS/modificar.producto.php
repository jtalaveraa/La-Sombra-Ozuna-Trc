<?php
include "../CLASS/database.php";
include "../SCRIPTS/modificar-prod.php";

$db = new Database();
$db->conectarBD();
$PDOLOCAL = $db->getPDO();

$id = $_GET["id"];


$sql = $PDOLOCAL->query("SELECT * FROM productos WHERE id_producto = $id");


while ($datos = $sql->fetch(PDO::FETCH_OBJ)) {
    
    $selected_categories = get_selected_categories($datos->id_producto, $PDOLOCAL);

    
    $selected_providers = get_selected_providers($datos->id_producto, $PDOLOCAL);

   
    $stmt = $PDOLOCAL->query("SELECT id_categoria, nombre FROM categorias");
    $cat = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    $stmt = $PDOLOCAL->query("SELECT id_proveedor, nombre FROM proveedores");
    $prov = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../CSS/modificar.css">

</head>
<body>
<br>

<form action="../SCRIPTS/modificar-prod.php" method="post" enctype="multipart/form-data">
    <h5>Modificar producto</h5>
    <input type="hidden" name="id" value ="<?=$_GET["id"]?>" >
    <div class="form-group">
        <label for="username">Nombre del Producto:</label><br>
        <input type="text" id="nombre" placeholder="Ingresa el nombre del producto" name="nombre" value="<?= $datos->nombre ?>">
    </div>                   

    
    <fieldset class="mb-3">
        <legend>MARCA:</legend>
        <div class="form-check">
            <input type="radio" id="contactChoice1" class="form-check-input" name="marca" value="Raw" <?= $datos->marca == 'Raw' ? 'checked' : '' ?> onclick="toggleInput()">
            <label for="contactChoice1" class="form-check-label">Raw</label>
        </div>
        <div class="form-check">
            <input type="radio" id="contactChoice2" class="form-check-input" name="marca" value="Blazy Susan" <?= $datos->marca == 'Blazy Susan' ? 'checked' : '' ?> onclick="toggleInput()">
            <label for="contactChoice2" class="form-check-label">Blazy Susan</label>
        </div>
        <div class="form-check">
            <input type="radio" id="marca3" class="form-check-input" name="marca" value="Rolling Circus" <?= $datos->marca == 'Rolling Circus' ? 'checked' : '' ?>>
            <label for="marca3" class="form-check-label">Rolling Circus</label>
        </div>
        <div class="form-check">
            <input type="radio" id="marca4" class="form-check-input" name="marca" value="OCB" <?= $datos->marca == 'OCB' ? 'checked' : '' ?>>
            <label for="marca4" class="form-check-label">OCB</label>
        </div>
        <div class="form-check">
            <input type="radio" id="marca5" class="form-check-input" name="marca" value="Kush" <?= $datos->marca == 'Kush' ? 'checked' : '' ?>>
            <label for="marca5" class="form-check-label">Kush</label>
        </div>
        <div class="form-check">
            <input type="radio" id="marca6" class="form-check-input" name="marca" value="Blunt Wrap" <?= $datos->marca == 'Blunt Wrap' ? 'checked' : '' ?>>
            <label for="marca6" class="form-check-label">Blunt Wrap</label>
        </div>
        <div class="form-check">
            <input type="radio" id="marca7" class="form-check-input" name="marca" value="EYCE" <?= $datos->marca == 'EYCE' ? 'checked' : '' ?>>
            <label for="marca7" class="form-check-label">EYCE</label>
        </div>
        <div class="form-check">
            <input type="radio" id="marca8" class="form-check-input" name="marca" value="otro" <?= $datos->marca == 'otro' || !in_array($datos->marca, ['Raw', 'Blazy Susan', 'Rolling Circus', 'OCB', 'Kush', 'Blunt Wrap', 'EYCE']) ? 'checked' : '' ?> onclick="document.getElementById('otra_marca').style.display='block'">
            <label for="marca8" class="form-check-label">OTRO</label>
        </div>
    </fieldset>

    <div id="otra_marca" style="<?= $datos->marca == 'otro' || !in_array($datos->marca, ['Raw', 'Blazy Susan', 'Rolling Circus', 'OCB', 'Kush', 'Blunt Wrap', 'EYCE']) ? 'display:block;' : 'display:none;' ?>">
        <label for="extra">Ingrese el Nombre de la Marca:</label>
        <input type="text" id="extra" name="extra" value="<?= $datos->marca != 'Raw' && $datos->marca != 'Blazy Susan' && $datos->marca != 'Rolling Circus' && $datos->marca != 'OCB' && $datos->marca != 'Kush' && $datos->marca != 'Blunt Wrap' && $datos->marca != 'EYCE' ? htmlspecialchars($datos->marca) : '' ?>">
    </div>

    
    <fieldset class="mb-3">
        <legend>Categoria(s)</legend>
        <?php foreach ($cat as $row) { ?>
            <div class="form-check">
                <input type="checkbox" id="coding<?php echo $row['id_categoria']; ?>" class="form-check-input" name="cate[]" value="<?php echo $row['id_categoria']; ?>" 
                <?php echo in_array($row['id_categoria'], $selected_categories) ? 'checked' : ''; ?>>
                <label for="coding<?php echo $row['id_categoria']; ?>" class="form-check-label"><?php echo $row['nombre']; ?></label>
            </div>
        <?php } ?>
    </fieldset>

    
    <fieldset>
        <legend>Proveedor(es)</legend>
        <p>(EL PRECIO DE COMPRA SE REGISTRA, DESDE EL REABASTECIMIENTO)</p>
        <?php foreach ($prov as $row) { ?>
            <div>
                <input type="checkbox" id="<?php echo $row['id_proveedor']; ?>" name="proveedores[]" value="<?php echo $row['id_proveedor']; ?>"
                <?php echo in_array($row['id_proveedor'], $selected_providers) ? 'checked' : ''; ?> />
                <label for="coding<?php echo $row['id_proveedor']; ?>"><?php echo $row['nombre'];?></label>
            </div>
        <?php } ?>
    </fieldset>

    
    <div class="form-group">
        <label for="precio">Precio al publico:</label><br>
        <input type="text" id="precio" name="precio" value="<?= $datos->precio ?>" placeholder="Ingresa el precio del producto">
    </div>

    
    <fieldset class="mb-3">
        <legend>MATERIAL:</legend>
        <div class="form-check">
            <input type="radio" id="mt1" class="form-check-input" name="material" value="ceramica" <?= $datos->material == 'ceramica' ? 'checked' : '' ?>>
            <label for="mt1" class="form-check-label">Cerámica</label>
        </div>
        <div class="form-check">
            <input type="radio" id="mt2" class="form-check-input" name="material" value="metal" <?= $datos->material == 'metal' ? 'checked' : '' ?>>
            <label for="mt2" class="form-check-label">Metal</label>
        </div>
        <div class="form-check">
            <input type="radio" id="mt3" class="form-check-input" name="material" value="plastico" <?= $datos->material == 'plastico' ? 'checked' : '' ?>>
            <label for="mt3" class="form-check-label">Plástico</label>
        </div>
        <div class="form-check">
            <input type="radio" id="mt4" class="form-check-input" name="material" value="cristal" <?= $datos->material == 'cristal' ? 'checked' : '' ?>>
            <label for="mt4" class="form-check-label">Cristal</label>
        </div>
        <div class="form-check">
            <input type="radio" id="mt5" class="form-check-input" name="material" value="madera" <?= $datos->material == 'madera' ? 'checked' : '' ?>>
            <label for="mt5" class="form-check-label">Madera</label>
        </div>
        <div class="form-check">
            <input type="radio" id="mt6" class="form-check-input" name="material" value="otro" <?= $datos->material == 'otro' ? 'checked' : '' ?> onclick="document.getElementById('otro_material').style.display='block'">
            <label for="mt6" class="form-check-label">Otro</label>
        </div>
    </fieldset>

    <div class="mb-3">
        <label for="img" class="form-label">Seleccione una imagen del producto:</label>
        <input type="file" id="img" class="form-control" name="img">
    </div>
                      
    
    <div class="mb-3">
        <label for="desc" class="form-label">DESCRIPCIÓN:</label>
        <textarea name="desc" id="desc" class="form-control" rows="5"><?= $datos->descripcion ?></textarea>
    </div>

<?php } ?> 
                 
    <button type="submit" name="btnreg" class="btn btn-primary" value="ok">Registrar</button> 
</form>

</body>
</html>
