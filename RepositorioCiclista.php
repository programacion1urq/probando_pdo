<?php
require_once 'Repositorio.php';
require_once 'Ciclista.php';

class RepositorioCiclista extends Repositorio
{
    public function guardarCiclistaEnBD(Ciclista $c)
    {
        if(is_null(self::$conexion)) {
            return "Error al agregar el ciclista. Mensaje: " . self::$error_conexion;
        }
        try {
            //Iniciamos una transacción, que luego deberemos confirmar (commit)
            //o deshacer (rollback):
            self::$conexion->beginTransaction();
            //Preparamos la sentencia INSERT, con 4 parámetros,indicados por "?"
            $insercion = self::$conexion->prepare(
                "INSERT INTO ciclistas (numero, nombre, edad, equipo) VALUES (?, ?, ?, ?);"
            );

            //Creamos un array con los 4 elementos que reemplazarán a los "?":
            $datos = [$c->getNumero(), $c->getNombre(), $c->getEdad(), $c->getEquipo()];

            //Ejecutamos la sentencia preparada antes, y así insertamos el 
            //nuevo equipo, y le enviamos el array con los datos:
            $insercion->execute($datos);

            //Si llegado este punto no se ha lanzado la excepción, confirmamos:
            self::$conexion->commit();
            return "El ciclista fue agregado";
        }
        catch (PDOException $e) {
            // Si estamos aquí es porque lanzó la excepción. Cancelamos:
            self::$conexion->rollback();
            // y retornamos el error:
            return "Error al agregar el ciclista . " . self::$error_conexion . " " . $e->getMessage();
        }
    }
}
