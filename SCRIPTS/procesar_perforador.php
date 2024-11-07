<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'eliminar') {
        
        $nombre = $_POST['nombre'];

        $json_data = file_get_contents('perforadores.json');
        $perforadores = json_decode($json_data, true);

        foreach ($perforadores as $key => $perforador) {
            if ($perforador['nombre'] === $nombre) {
                unset($perforadores[$key]);
                break;
            }
        }
        $perforadores = array_values($perforadores);
        if (file_put_contents('perforadores.json', json_encode($perforadores, JSON_PRETTY_PRINT))) {
            echo "Perforador eliminado exitosamente.<br>";
        } else {
            echo "Hubo un problema al eliminar el perforador.";
            exit();
        }

        header("Location: ../VIEWS/perforaciones.php");
        exit();
    } else {
        
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $telefono = $_POST['telefono']; 
        $imagen = $_FILES['imagen']['name'];

        $target_dir = "imagenes_perforadores/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($imagen);

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
            echo "La imagen se subió correctamente.<br>";
        } else {
            echo "Hubo un problema al subir la imagen.";
            exit();
        }

        $json_data = file_get_contents('perforadores.json');
        $perforadores = json_decode($json_data, true);

        $nuevo_perforador = array(
            "nombre" => $nombre,
            "descripcion" => $descripcion,
            "telefono" => $telefono, 
            "imagen" => $target_file
        );

        $perforadores[] = $nuevo_perforador;

        if (file_put_contents('perforadores.json', json_encode($perforadores, JSON_PRETTY_PRINT))) {
            echo "Perforador agregado exitosamente.<br>";
        } else {
            echo "Hubo un problema al guardar el perforador.";
            exit();
        }

        header("Location: ../VIEWS/perforaciones.php");
        exit();
    }
}
?>
