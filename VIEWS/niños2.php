<?php 

include "../CLASS/database.php";
$db = new Database();
$db->conectarBD();
$conexion = $db->getPDO();

$sql_niños = "SELECT ID_NIÑO, NOMBRES FROM NIÑOS N JOIN PERSONAS P ON N.PERSONA = P.ID_PERSONA";
$statement_niños = $conexion->prepare($sql_niños);
$statement_niños->execute();
$niños = $statement_niños->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener los grupos y cuidadores
$sql_grupos_cuidadores = "SELECT GC.ID_GC, G.NOMBRE AS GRUPO, P.NOMBRES AS CUIDADOR
                          FROM G_C GC
                          JOIN GRUPOS G ON GC.GRUPO = G.ID_GRUPO
                          JOIN CUIDADORES C ON GC.CUIDADOR = C.ID_CUIDADOR
                          JOIN PERSONAS P ON C.PERSONA = P.ID_PERSONA";
$statement_grupos_cuidadores = $conexion->prepare($sql_grupos_cuidadores);
$statement_grupos_cuidadores->execute();
$grupos_cuidadores = $statement_grupos_cuidadores->fetchAll(PDO::FETCH_ASSOC);



if (isset($_POST['regis'])) {
    $id_niño = $_POST['niño'];
    $id_grupo_cuidador = $_POST['grupo_cuidador'];
    $fecha_egreso = $_POST['fecha_egreso'];

    // Consulta 
    $sql_select = "SELECT ID_ASIG FROM ASIGNACIONES 
                   WHERE NIÑO = :nino AND GRUPO_CUIDADOR = :grupo_cuidador";
    
    $stmt_select = $conexion->prepare($sql_select);
    $stmt_select->bindParam(':nino', $id_niño, PDO::PARAM_INT);
    $stmt_select->bindParam(':grupo_cuidador', $id_grupo_cuidador, PDO::PARAM_INT);
    $stmt_select->execute();

    $asignacion = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if ($asignacion) {
        // Actualizar la fecha de egreso
        $sql_update = "UPDATE ASIGNACIONES 
                       SET F_EGRESO_ESTANCIA = :fecha_egreso 
                       WHERE ID_ASIG = :id_asignacion";

        $stmt_update = $conexion->prepare($sql_update);
        $stmt_update->bindParam(':fecha_egreso', $fecha_egreso, PDO::PARAM_STR);
        $stmt_update->bindParam(':id_asignacion', $asignacion['ID_ASIG'], PDO::PARAM_INT);

        $stmt_update->execute();

        echo "Fecha de egreso actualizada con éxito.";
    } else {
        echo "No se encontró ninguna asignación con los parámetros proporcionados.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Registrar Asignación</h2>
    <form method="post">
        <label for="niño">Niño:</label>
        <select name="niño" id="niño" required>
            <option value="" disabled selected>Seleccione un niño</option>
            <?php foreach ($niños as $niño): ?>
                <option value="<?= $niño['ID_NIÑO']; ?>"><?= $niño['NOMBRES']; ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="grupo_cuidador">Grupo y Cuidador:</label>
        <select name="grupo_cuidador" id="grupo_cuidador" required>
            <option value="" disabled selected>Seleccione un grupo y cuidador</option>
            <?php foreach ($grupos_cuidadores as $gc): ?>
                <option value="<?= $gc['ID_GC']; ?>"><?= $gc['GRUPO']; ?> - <?= $gc['CUIDADOR']; ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="fecha_ingreso">Fecha de Egreso:</label>
        <input type="date" name="fecha_egreso" id="fecha_egreso" required>
        <br><br>

        <button name="regis" type="submit">Registrar</button>
    </form>
</body>
</html>