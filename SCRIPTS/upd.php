<?php
include "../CLASS/database.php";

$db = new Database();
$db->conectarBD();

$conexion = $db->getPDO();
session_start(); 

if(!empty($_POST['id']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['telefono'])){
$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];

$sql="UPDATE usuarios SET nombre_usuario = :nom, email = :corr, telefono = :tel WHERE id_usuario = :id";
$stmt= $conexion->prepare($sql);

$stmt->bindParam(":nom", $username);
$stmt->bindParam(":corr", $email);
$stmt->bindParam(":tel", $telefono);
$stmt->bindParam(":id", $id);
    if($stmt->execute()){
        header("location: ../VIEWS/detalle-cuenta.php");
    }else{
        echo"Complete todos los campos del formulario";
    }

}
?>