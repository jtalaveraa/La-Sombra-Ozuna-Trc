<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../CLASS/database.php";
$db = new Database();
$db->conectarBD();
$conexion = $db->getPDO();

if (!in_array($_SESSION["rol"], [4, 1])) {
    echo "Rol inválido: " . $_SESSION["rol"];
    exit();    
}

if ($_SESSION["rol"] == 4 && !isset($_SESSION["perforador_id"])) {
    if (isset($_SESSION["id_empleado"])) {
        $_SESSION["perforador_id"] = $_SESSION["id_empleado"];
    } else {
        echo "Error: El ID del empleado no está definido en la sesión.";
        exit();
    }
}

$perforador = isset($_SESSION["perforador_id"]) ? $_SESSION["perforador_id"] : null;

$sucursal = isset($_POST['sucursal']) ? $_POST['sucursal'] : '';
$date = isset($_POST['fecha']) ? $_POST['fecha'] : '';

if ($_SESSION["rol"] == 1) {
    $sql = "SELECT c.id_cita AS id, e.nombres AS perforador, c.nombre_cliente AS cliente, 
            c.tipo_perforacion AS perforacion, c.fecha_hora AS fecha,
            s.nombre AS sucursal, c.telefono AS telefono, c.comentarios
            FROM empleado AS e
            JOIN citas AS c ON e.id_empleado = c.empleado
            JOIN sucursales AS s ON c.sucursal = s.id_sucursal
            WHERE 1=1"; 
    $params = [];
} else if ($_SESSION["rol"] == 4) { 
    $sql = "SELECT c.id_cita AS id, e.nombres AS perforador, c.nombre_cliente AS cliente, 
            c.tipo_perforacion AS perforacion, c.fecha_hora AS fecha,
            s.nombre AS sucursal, c.telefono AS telefono, c.comentarios
            FROM empleado AS e
            JOIN citas AS c ON e.id_empleado = c.empleado
            JOIN sucursales AS s ON c.sucursal = s.id_sucursal
            WHERE c.empleado = :perforadorId";
    $params = [':perforadorId' => $perforador];
}

if (!empty($sucursal)) {
    $sql .= " AND c.sucursal = :sucursal";
    $params[':sucursal'] = $sucursal;
}

if (!empty($date)) {
    $sql .= " AND c.fecha_hora LIKE :date";
    $params[':date'] = $date . '%';
}

$stmt = $conexion->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($results) {
    foreach ($results as $cita) {
        
    }
} else {
    echo '<div class="alert alert-warning">No se encontraron citas para este perforador.</div>';
}

$con = "SELECT e.nombres AS perforadores, e.id_empleado AS id 
        FROM empleado AS e 
        JOIN persona AS p ON e.persona = p.id_persona 
        JOIN usuarios AS u ON p.usuario = u.id_usuario 
        JOIN rol_usuario AS ru ON u.id_usuario = ru.usuario
        WHERE ru.rol = 4;";

$perf = $conexion->prepare($con);
$perf->execute();
$pe = $perf->fetchAll(PDO::FETCH_ASSOC);

$insert = $conexion->prepare("INSERT INTO citas(nombre_cliente,empleado,tipo_perforacion,fecha_hora,sucursal,comentarios,telefono,costo)
VALUES(?,?,?,?,?,?,?,?)");
if (isset($_POST['btnreg'])) {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $empleado = isset($_SESSION['perforador_id']) ? $_SESSION['perforador_id'] : '';
    $tipo_perforacion = isset($_POST['perfo']) ? $_POST['perfo'] : '';
    $fecha_hora = isset($_POST['datetime']) ? $_POST['datetime'] : '';
    $sucursal = isset($_POST['sucursal']) ? $_POST['sucursal'] : '';
    $comentarios = isset($_POST['coments']) ? $_POST['coments'] : '';
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $costo = isset($_POST['costo']) ? $_POST['costo'] : '';
}
    if (!empty($nombre) && !empty($empleado) && !empty($tipo_perforacion) && !empty($fecha_hora) && !empty($sucursal)) {
        $insert = $conexion->prepare("INSERT INTO citas(nombre_cliente,empleado,tipo_perforacion,fecha_hora,sucursal,comentarios,telefono,costo)
            VALUES(?,?,?,?,?,?,?,?)");

        $insert->bindParam(1, $nombre, PDO::PARAM_STR);
        $insert->bindParam(2, $empleado, PDO::PARAM_INT);
        $insert->bindParam(3, $tipo_perforacion, PDO::PARAM_STR);
        $insert->bindParam(4, $fecha_hora, PDO::PARAM_STR);
        $insert->bindParam(5, $sucursal, PDO::PARAM_INT);
        $insert->bindParam(6, $comentarios, PDO::PARAM_STR);
        $insert->bindParam(7, $telefono, PDO::PARAM_STR);
        $insert->bindParam(8, $costo, PDO::PARAM_STR);

        if ($insert->execute()) {
            header("Location: dash-citas.php");
            exit();
        } else {
            echo '<div class="alert alert-danger">Error al registrar la cita. Inténtalo nuevamente.</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Por favor, complete todos los campos obligatorios.</div>';
    }



?>
