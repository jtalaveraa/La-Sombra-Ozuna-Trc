<?php
class Database
{  
    // (S) RESPONSABILIDAD ÚNICA
    // (0) ABIERTO-CERRADO

    private $PDOlOCAL; // Si pones esta variable en null se cierra
    private $user = 'root';
    private $password = '';
    private $server = "mysql:host=localhost;dbname=la_sombra"; 
        
    function conectarBD()
    {
        try {
            $this->PDOlOCAL = new PDO($this->server, $this->user, $this->password);
            $this->PDOlOCAL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Agregado para lanzar excepciones
            } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function desconectarBD()
    {
        try {
            $this->PDOlOCAL = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getPDO()
    {
        return $this->PDOlOCAL;
    }

    function cerrarsesion()
    {
        session_start();
        session_destroy();
        header("Location: ../VIEWS/inicio-sesion.php");
    }
}
?>