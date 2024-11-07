<?php

session_start();

include "../CLASS/database.php";
$db = new Database();
$db->conectarBD();

$conexion = $db->getPDO();

if (isset($_POST["btncrearclient"])) {
    if (!empty($_POST["usuario"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["pass"]) && !empty($_POST["telefono"])) {
        $pass1 = $_POST['password'];
        $pass2 = $_POST['pass'];

        if ($pass1 === $pass2) {
            $usuario = $_POST["usuario"];
            $password = $_POST["password"];
            $email = $_POST["email"];
            $telefono = $_POST["telefono"];

       
            $checkUser = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE nombre_usuario = :usuario");
            $checkUser->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $checkUser->execute();
            $userExists = $checkUser->fetchColumn();

            if ($userExists > 0) {
                echo "<p style='color: red;'>Este nombre de usuario ya está siendo utilizado.</p>";
            } else {
                
                $checkEmail = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
                $checkEmail->bindParam(':email', $email, PDO::PARAM_STR);
                $checkEmail->execute();
                $emailExists = $checkEmail->fetchColumn();

                if ($emailExists > 0) {
                    echo "<p style='color: red;'>Este correo electrónico ya está registrado.</p>";
                } else {
                    
                    $checkPhone = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE telefono = :telefono");
                    $checkPhone->bindParam(':telefono', $telefono, PDO::PARAM_STR);
                    $checkPhone->execute();
                    $phoneExists = $checkPhone->fetchColumn();

                    if ($phoneExists > 0) {
                        echo "<p style='color: red;'>Este número de teléfono ya está registrado.</p>";
                    } else {
                        
                        $stmt = $conexion->prepare("CALL REGISTRO_CLIENTES(?,?,?,?)");

                        $stmt->bindParam(1, $usuario, PDO::PARAM_STR);
                        $stmt->bindParam(2, $password, PDO::PARAM_STR);
                        $stmt->bindParam(3, $email, PDO::PARAM_STR);
                        $stmt->bindParam(4, $telefono, PDO::PARAM_STR);
                        $stmt->execute();

                        
                        $ns = $conexion->prepare("SELECT id_usuario FROM usuarios ORDER BY id_usuario DESC LIMIT 1");
                        $ns->execute();
                        $id = $ns->fetch(PDO::FETCH_ASSOC)['id_usuario'];
                        
                        echo "<p style='color: green;'>Usuario registrado exitosamente.</p>";
                        $_SESSION['id'] = $id;
                        header("refresh:3; ../VIEWS/inicio-sesion.php");
                    }
                }
            }
        } else {
            echo "<p style='color: red;'>Las contraseñas son diferentes.</p>";
        }
    } else {
        echo "Ingrese todos los datos";
    }
}

?>
