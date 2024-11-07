<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <link rel="stylesheet" href="../CSS/index.css">
</head>

<body>
    <div class="container">
        <div class="logo"><img src="IMG/sombra-logo.jpg" alt=""></div>
        <h1>SELECCIONE UNA SUCURSAL</h1>
        <div class="buttons">
            <a href="../SCRIPTS/cdsss.php?sucursal=2"><button  class="entrar">Nazas</button></a>
            <a href="../SCRIPTS/cdsss.php?sucursal=1"><button  class="entrar">Matamoros</button></a>            
        </div>
    </div>
</body>

</html>