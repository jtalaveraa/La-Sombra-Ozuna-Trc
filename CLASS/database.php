<?php
class Database{
    private $pdolocal;
    private $user = 'root';
    private $password = '';
    private $server = "mysql:host=localhost;dbname=la_sombra";
        
    function conectarBD()
    {
        try {
            $this->pdolocal = new PDO($this->server, $this->user, $this->password);
            $this->pdolocal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Agregado para lanzar excepciones
            } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function desconectarBD()
    {
        try {
            $this->pdolocal = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getPDO()
    {
        return $this->pdolocal;
    }

    function cerrarsesion()
    {
        session_start();
        session_destroy();
        header("Location: ../VIEWS/inicio-sesion.php");
    }
}
