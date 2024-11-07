<?php

session_start();

include "../CLASS/database.php";
$db = new Database();
$db->conectarBD();

$conexion = $db->getPDO();

$sql = "SELECT u.nombre_usuario, u.id_usuario, ru.rol, e.id_empleado 
        FROM usuarios u
        JOIN rol_usuario ru ON u.id_usuario = ru.usuario 
        LEFT JOIN persona p ON u.id_usuario = p.usuario 
        LEFT JOIN empleado e ON p.id_persona = e.persona
        WHERE u.nombre_usuario = :usuario 
        AND u.password = AES_ENCRYPT(:password, 'clave_segura')";


$stmt = $conexion->prepare($sql);

if (isset($_POST["btningreso"])) {
    if (!empty($_POST["usuario"]) && !empty($_POST["password"])) {
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];

        $stmt->bindParam(":usuario", $usuario, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            var_dump($row);
            $_SESSION['id'] = $row['id_usuario'];
            $_SESSION['nombre'] = $row['nombre_usuario'];
            $_SESSION['rol'] = $row['rol'];
            $_SESSION['id_empleado'] = $row['id_empleado'];

            if ($_SESSION["rol"] == 3) {
                header("location: ../VIEWS/iniciov2.php");
                exit();
            } else if ($_SESSION["rol"] == 4) {
                header("location: ../VIEWS/dash-citas.php");
                exit();
            }
            else {
                header("location: ../VIEWS/dash-ventas.php");
                exit();
            }
        } else {
            echo "<p style='color: red;'>Contraseña o nombre de usuario incorrectos.</p>";
        }
    } else {
        echo "Ingrese todos los datos";
    }
}


?>

