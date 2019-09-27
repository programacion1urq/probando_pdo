<?php
abstract class Repositorio
{
    //Datos del servidor
    const SERVIDOR =  'localhost';
    const NOMBREBD = 'ciclismo';
    const USUARIO = 'mi_usuario';
    const CLAVE = 'mi_clave';
    
    protected static $conexion = null;
    protected static $error_conexion = "Sin errores de conexión";

    public function __construct()
    {
        if ( self::$conexion === null) {
            self::conectar();
        }
    }

    protected static function conectar()
    {
        try {
            //Instanciamos un nuevo objeto de la clase PDO, y lo guardamos
            self::$conexion = new PDO(
                "mysql:host=".self::SERVIDOR.";dbname=".self::NOMBREBD.";charset=utf8", 
                self::USUARIO, self::CLAVE);

            //Indicamos que lance una excepción cuando falle una query SQL:
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            //Si falló la conexión del try, lanza una excepción que capturamos aquí.
            self::$error_conexion =  "¡Error de conexión! " . $e->getMessage();
        }
    }

}
