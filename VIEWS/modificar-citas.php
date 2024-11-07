<?php


include "../CLASS/database.php";

$db = new Database();
$db->conectarBD();
$PDOLOCAL = $db->getPDO();

$id = $_GET["id"];

$sql = "SELECT c.nombre_cliente, c.telefono, c.costo, c.tipo_perforacion, c.fecha_hora AS fecha, c.comentarios, 
               CONCAT(e.nombres, ' ', e.ap_paterno, ' ', e.ap_materno) AS perforador, s.nombre AS sucursal
        FROM citas AS c
        JOIN empleado AS e ON c.empleado = e.id_empleado
        JOIN sucursales AS s ON c.sucursal = s.id_sucursal
        WHERE c.id_cita = :id";

$stmt = $PDOLOCAL->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$cita = $stmt->fetch(PDO::FETCH_OBJ);

$f = new DateTime();
$max_fecha = clone $f;
$max_fecha->modify('+2 month');
$fecha_max = $max_fecha->format('Y-m-d\TH:i');
$fecha_min = $f->format('Y-m-d\TH:i');


$sqlCita = "SELECT * FROM citas WHERE id_cita = :id";
$stmtCita = $PDOLOCAL->prepare($sqlCita);
$stmtCita->bindParam(':id', $id, PDO::PARAM_INT);
$stmtCita->execute();
$cita = $stmtCita->fetch(PDO::FETCH_OBJ);
$sqlEmpleados = "
    SELECT e.id_empleado, CONCAT(e.nombres, ' ', e.ap_paterno, ' ', e.ap_materno) AS nombre_completo 
    FROM empleado AS e
    JOIN persona AS p ON e.persona = p.id_persona
    JOIN usuarios AS u ON p.usuario = u.id_usuario
    JOIN rol_usuario AS ru ON u.id_usuario = ru.usuario
    WHERE ru.rol = 7";

$stmtEmpleados = $PDOLOCAL->query($sqlEmpleados);
$empleados = $stmtEmpleados->fetchAll(PDO::FETCH_OBJ);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Cita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/modificar.css">
</head>
<body>
<br>
<form action="../SCRIPTS/modificar-cit.php?id=<?= htmlspecialchars($id) ?>" method="post">
    <h1>Modificar Cita</h1>
    <div class="row">
        <div class="form-group">
            <label for="nombre">Nombre del Cliente:</label><br>
            <input type="text" id="nombre" name="nombre" required value="<?= htmlspecialchars($cita->nombre_cliente) ?>">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label><br>
            <input type="tel" id="telefono" name="telefono" required value="<?= htmlspecialchars($cita->telefono) ?>">
        </div>
        <div class="form-group">
            <label for="costo">Costo:</label><br>
            <input type="text" id="costo" name="costo" required value="<?= htmlspecialchars($cita->costo) ?>">
        </div>
        <div class="form-group">
            <label for="perforacion">Tipo de Perforación:</label><br>
            <input type="text" id="perforacion" name="perforacion" required value="<?= htmlspecialchars($cita->tipo_perforacion) ?>">
        </div>
        <div class="form-group">
            <label for="datetime">Fecha y Hora:</label><br>
            <input type="datetime-local" id="datetime" name="datetime" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($cita->fecha))) ?>" min="<?= $fecha_min ?>" max="<?= $fecha_max ?>" />
        </div>
        <div class="form-group">
            <label for="sucursal">Sucursal:</label><br>
            <select class="form-select" name="sucursal" required>
                <option value="2" <?= $cita->sucursal == 'Nazas' ? 'selected' : '' ?>>Nazas</option>
                <option value="1" <?= $cita->sucursal == 'Matamoros' ? 'selected' : '' ?>>Matamoros</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="comentarios">Comentarios:</label><br>
            <textarea name="comentarios" id="comentarios" class="form-control" rows="5"><?= htmlspecialchars($cita->comentarios) ?></textarea>
        </div>
    </div> 
    <button id="regcita" type="submit" name="btnupdatecit" class="btn btn-primary">Modificar</button>     
</form>
<script src="../bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>
