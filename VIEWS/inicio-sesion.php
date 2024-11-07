<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Sombra - Inicio de Sesión</title>
    <link rel="stylesheet" href="../CSS/inicio-sesion.css">
</head>
<body>
<div class="outer-container">
    <div class="container">
        <img class="logo" src="../IMG/sombra-logo.jpg" alt="La Sombra Ozuna TRC">
        <h2>Inicia sesión</h2>
        <form method="post" action="">
            <label for="user">Ingresa tu nombre de usuario:</label><br>
            <input type="text" id="user" placeholder="Ingresa tu nombre de usuario aquí" name="usuario" maxlength="15" required><br>

            <label for="password">Ingresa tu contraseña:</label><br>
            <div class="input-container">
                <input type="password" id="password" placeholder="Ingresa tu contraseña aquí" name="password" maxlength="20" required>
                <img class="toggle-password" id="togglePasswordImage" src="../IMG/closeeye.png" alt="Mostrar contraseña" onclick="togglePasswordVisibility('password', 'togglePasswordImage')">
            </div>
            <?php 
            include '../SCRIPTS/login-script.php';
            ?>
            <button type="submit" name="btningreso" value="INICIAR SESION">Entrar</button>
        </form>
        <p>¿No tienes cuenta? <a href="../VIEWS/crear-cuenta.php" class="create-account"><p id="crear">Crear tu cuenta aquí</p></a></p>
        <a href="../VIEWS/iniciov2.php" class="back"><p id="regre" class="p-back">Regresar a inicio</p></a>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId, imageId) {
    var input = document.getElementById(inputId);
    var image = document.getElementById(imageId);

    if (input.type === "password") {
        input.type = "text";
        image.src = "../IMG/redeye.png";  
        image.alt = "Ocultar contraseña";
    } else {
        input.type = "password";
        image.src = "../IMG/closeeye.png";  
        image.alt = "Mostrar contraseña";
    }
}
</script>

</body>
</html>
