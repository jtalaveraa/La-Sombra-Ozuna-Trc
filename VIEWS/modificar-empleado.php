<?php
include "../CLASS/database.php";

$db = new Database();
$db->conectarBD();
$PDOLOCAL = $db->getPDO();

$id = $_GET["id"];
$sql = "SELECT u.nombre_usuario AS usuario, u.email, u.telefono, 
               e.nombres, e.ap_paterno, e.ap_materno, e.rfc, e.nss, e.curp, 
               ru.rol
        FROM empleado AS e 
        JOIN persona AS p ON e.persona = p.id_persona 
        JOIN usuarios AS u ON p.usuario = u.id_usuario 
        JOIN rol_usuario AS ru ON u.id_usuario = ru.usuario
        WHERE e.id_empleado = :id";

$stmt = $PDOLOCAL->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$employee = $stmt->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/modificar.css">
</head>
<body>
<br>
<form action="../SCRIPTS/modificar-emp.php?id=<?= htmlspecialchars($id) ?>" method="post">
    <h1>Modificar Empleado</h1>
    <div class="row">
        <div class="form-group">
            <label for="username">Nombre de usuario:</label><br>
            <input type="text" id="username" placeholder="Ingresa tu nombre de usuario aquí" name="usuario" value="<?= htmlspecialchars($employee->usuario) ?>">
        </div>
        <div class="form-group">
            <label for="email">Correo:</label><br>
            <input type="email" id="email" placeholder="ejemplo@mail.com" name="email" required value="<?= htmlspecialchars($employee->email) ?>">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label><br>
            <input type="text" id="telefono" placeholder="Ingresa tu teléfono" name="telefono" required value="<?= htmlspecialchars($employee->telefono) ?>">
        </div>
        
        <div class="form-group">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" placeholder="Ingresa Nombre(s)" name="nombre" required value="<?= htmlspecialchars($employee->nombres) ?>">                        
        </div>  
        <div class="form-group">
            <label for="paterno">Apellido Paterno:</label><br>
            <input type="text" id="paterno" placeholder="Ingresa Apellido Paterno" name="paterno" required value="<?= htmlspecialchars($employee->ap_paterno) ?>">
        </div> 
        <div class="form-group">
            <label for="materno">Apellido Materno:</label><br>
            <input type="text" id="materno" placeholder="Ingresa Apellido Materno" name="materno" required value="<?= htmlspecialchars($employee->ap_materno) ?>">                        
        </div> 
        <div class="form-group">
            <label for="rfc">RFC:</label><br>
            <input type="text" id="rfc" placeholder="Ingresa RFC" name="rfc" required value="<?= htmlspecialchars($employee->rfc) ?>">                        
        </div> 
        <div class="form-group">
            <label for="nss">NSS:</label><br>
            <input type="text" id="nss" placeholder="Ingresa NSS" name="nss" required value="<?= htmlspecialchars($employee->nss) ?>">
        </div> 
        <div class="form-group">
            <label for="curp">CURP:</label><br>
            <input type="text" id="curp" placeholder="Ingresa CURP" name="curp" required value="<?= htmlspecialchars($employee->curp) ?>">
        </div> 
        <div class="form-group">
            <label for="rol">Rol:</label><br>
            <select class="form-select" aria-label="Default select example" name="rol" required>
                <option value="2" <?= $employee->rol == 2 ? 'selected' : '' ?>>Empleado</option>
                <option value="1" <?= $employee->rol == 1 ? 'selected' : '' ?>>Administrador</option>
                <option value="4" <?= $employee->rol == 4 ? 'selected' : '' ?>>Perforador</option>                        
            </select> 
        </div>
    </div> 
    <button id="regemp" type="submit" name="btnupdateemp" class="btn btn-success">Modificar</button> 
    <br><br>
    <button id="regemp" type="buton" href="../VIEWS/dsh-empl.php" name="btnupdateemp" class="btn btn-danger">Cancelar</button> 

    
   
</form>
</body>
</html>
