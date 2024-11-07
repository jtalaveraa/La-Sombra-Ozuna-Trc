<?php
require '../SCRIPTS/config-prod.php';
require '../SCRIPTS/con-carrito.php';


if (session_status() == PHP_SESSION_NONE) {
  session_start();
}


if (isset($_SESSION['sucursal'])) {
  $sucursal = $_SESSION['sucursal'];
} else {
  $_SESSION['sucursal'] = null;
}

  
  $id = isset($_GET['id']) ? $_GET['id'] : '';
  $token = isset($_GET['token']) ? $_GET['token'] : '';


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nazas'])) {
    $_SESSION['sucursal'] = 2;
    
    header("Location: ../VIEWS/detalle_producto.php?id=".$id."&token=".$token);
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['matamoros'])) {
    $_SESSION['sucursal'] = 1;
    
    header("Location: ../VIEWS/detalle_producto.php?id=".$id."&token=".$token);
    exit();
}
  
if ($id == '' || $token == '') {
      # HACER UNA PAGINA DE PRODUCTO NO ENCONTRADO
      echo "ERROR llll";
      exit;
}

else {
      $token_tmp = hash_hmac('sha256',$id,K_TOKEN);
      if ($token == $token_tmp) {
                  
      }
      else {
        # HACER UNA PAGINA DE DATOS NO VALIDOS
        echo "ERROR";
          exit;
      }         
          $sql = $conexion->prepare("SELECT COUNT(id_producto) FROM productos
          WHERE id_producto = ?");
          $sql->execute([$id]);
          if ($sql->fetchColumn() > 0) { 
            if ($_SESSION['sucursal'] == null) {
              $sql = $conexion->prepare("SELECT nombre, marca, stock, descripcion, precio, material, url FROM productos
            WHERE id_producto = ?");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $stock = $row['stock'];
            $marca = $row['marca'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $url = $row['url'];

            $sql2= $conexion->prepare("SELECT id_producto ,nombre, marca, descripcion, precio, material, stock, url FROM productos
            WHERE marca = ? LIMIT 3");
            $sql2->execute([$marca]);
            $row2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
            }
            if ($_SESSION['sucursal'] == 2) {
              $sql = $conexion->prepare("SELECT nombre, marca, stock, descripcion, precio, material, url FROM productos_nazas
            WHERE id_producto = ?");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $stock = $row['stock'];
            $marca = $row['marca'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $url = $row['url'];

            $sql2= $conexion->prepare("SELECT id_producto ,nombre, marca, descripcion, precio, material, stock, url FROM productos
            WHERE marca = ? LIMIT 3");
            $sql2->execute([$marca]);
            $row2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
            }
            if ($_SESSION['sucursal'] == 3) {
              $sql = $conexion->prepare("SELECT nombre, marca, stock, descripcion, precio, material, url FROM productos
            WHERE id_producto = ?");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $stock = $row['stock'];
            $marca = $row['marca'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $url = $row['url'];

            $sql2= $conexion->prepare("SELECT id_producto ,nombre, marca, descripcion, precio, material, stock, url FROM productos
            WHERE marca = ? LIMIT 3");
            $sql2->execute([$marca]);
            $row2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
            }
            if ($_SESSION['sucursal'] == 1) {
              $sql = $conexion->prepare("SELECT nombre, marca, stock, descripcion, precio, material, url FROM productos_matamoros
            WHERE id_producto = ?");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $stock = $row['stock'];
            $marca = $row['marca'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $url = $row['url'];

            $sql2= $conexion->prepare("SELECT id_producto ,nombre, marca, descripcion, precio, material, stock, url FROM productos
            WHERE marca = ? LIMIT 3");
            $sql2->execute([$marca]);
            $row2 = $sql2->fetchAll(PDO::FETCH_ASSOC);
            }                                    
          }
          else{
            echo "no hay padrino";
          }        
          }        




?>