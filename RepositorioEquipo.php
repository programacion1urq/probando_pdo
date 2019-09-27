<?php
require_once 'Repositorio.php';
require_once 'Equipo.php';

class RepositorioEquipo extends Repositorio
{

    public function guardarEquipoEnBD(Equipo $e)
    {
        /**
         * Guarda el equipo recibido en la BD
         *
         * Recibe como parámetro un equipo y lo guarda en la BD
         * Retorna un string con un mensaje de éxito o fracaso.
         */
        if(is_null(self::$conexion)) {
            return "Error al agregar el equipo. Mensaje: " . self::$error_conexion;
        }
        try {
            //Iniciamos una transacción, que luego deberemos confirmar (commit)
            //o deshacer (rollback):
            self::$conexion->beginTransaction();
            
            //Preparamos la sentencia INSERT, con dos parámetros, a los que
            //llamamos :e y :d
            $insercion = self::$conexion->prepare(
                "INSERT INTO equipos (nombre_equipo, director) VALUES (:e, :d);"
            );
            //La clase PDO (de la que self::$conexion es una instancia), tiene un
            // método llamado prepare, que invocamos en este momento.

            //Le asignamos valor a los parámetros :e y :d
            $insercion -> bindValue(':e',$e->getNombre());
            $insercion -> bindValue(':d',$e->getDirector());

            //Ejecutamos la sentencia preparada antes, y así insertamos el 
            // nuevo equipo:
            $insercion->execute();

            //Si llegado este punto no se ha lanzado la excepción, confirmamos:
            self::$conexion->commit();
            return "El equipo fue agregado";
        }
        catch (PDOException $e) {
            // Si estamos aquí es porque lanzó la excepción. Cancelamos:
            self::$conexion->rollback();
            // y retornamos el error:
            return "Error al agregar el equipo." . self::$error_conexion . " " . $e->getMessage();
        }
    }

    public function getAll()
    {
        /**
         * Obtener todos los equipos que haya guardados en la Base de Datos
         *
         * Retorna un array compuesto por objetos de la clase Equipo
         */
        if(is_null(self::$conexion)) {
            return "Error al agregar el equipo. Mensaje: " . self::$error_conexion;
        }
        try {
            // Creamos el array vacío $e.
            $e = [];

            // Consultamos directamente con el método query(), porque en la 
            // consulta no interviene el input del usuario.
            $sql = "SELECT nombre_equipo, director FROM equipos";
            $r = self::$conexion->query($sql, PDO::FETCH_ASSOC);

            // $r guarda el resultado de la consulta. Lo recorremos con fetch():
            while ( $fila = $r->fetch() ) {
                // Creamos un nuevo objeto de clase Equipo y lo agregamos al
                // array $e:
                $e[] = new Equipo($fila['nombre_equipo'],
                                  $fila['director']);
            }
            return $e;
        }
        catch (PDOException $e) {
            $error =  "Error al consultar" . self::$error_conexion;
            $error.= $e->getMessage();
            return $error;
        }

    }

    public function getOne($nombre_equipo)
    {
        /**
         * Buscar un equipo por nombre
         *
         * Recibe como parámetro un nombre de equipo y retorna un objeto de la
         * clase Equipo.
         * Si falla, retorna un mensaje de error.
         */
        if(is_null(self::$conexion)) {
            return "Error al agregar el equipo. Mensaje: " . self::$error_conexion;
        }
        try {
            // Preparamos la consulta:
            $s = self::$conexion->prepare(
                "SELECT nombre_equipo, director FROM equipos 
                WHERE nombre_equipo = ?"
            );
            // Ejecutamos la consulta preparada con el dato que proviene del 
            // input del usuario:
            $s->execute([ $nombre_equipo ]);

            //Si el equipo fue encontrado en la BD, creamos con estos datos un 
            //objeto equipo y lo retornamos.
            if ( $fila = $s->fetch()) {
                return new Equipo($fila['nombre_equipo'],
                                  $fila['director']);
            }
            else {
                //Si no fue encontrado, retornamos un mensaje:
                return "No hay ningún equipo llamado $nombre_equipo";
            }

        }
        catch (PDOException $e) {
            $error =  "Error al consultar" . self::$error_conexion;
            $error.= $e->getMessage();
            return $error;
        }

    }
    
    
    public function eliminar(Equipo $eq)
    {
        /**
         * Elimina un equipo de la Base de Datos
         *
         * Recibe como parámetro un equipo y lo elimina de la tabla 
         * correspondiente.
         * Retorna true si tiene éxito, o un mensaje de error de lo contrario.
         */
        if(is_null(self::$conexion)) {
            return "Error al eliminar el equipo. Mensaje: " . self::$error_conexion;
        }
        try {
            $s = self::$conexion->prepare(
                "DELETE FROM equipos WHERE nombre_equipo = ?"
            );
            $s->execute([ $eq->getNombre() ]);
            return true;
        }
        catch (PDOException $e) {
            $error =  "Error al consultar" . self::$error_conexion;
            $error.= $e->getMessage();
            return $error;
        }
    }

    public function modificar( Equipo $eq, $nombreViejo) {
        /**
         * Modifica los datos de un equipo en la BD.
         *
         * Recibe como parámetros un objeto de la clase Equipo, que contiene los
         * datos nuevos, y también el nombre que el equipo tiene hasta ahora, 
         * para poder buscarlo en la BD.
         * Retorna true si tuvo éxito o un mensaje de error de lo contrario.
         */
        if(is_null(self::$conexion)) {
            return "Error al eliminar el equipo. Mensaje: " . self::$error_conexion;
        }
        try {
            $s = self::$conexion->prepare(
                "UPDATE equipos SET nombre_equipo = ?, director=?
                WHERE nombre_equipo = ?"
            );
            $s->execute(
                [$eq->getNombre(),$eq->getDirector(),$nombreViejo]
            );
            return true;
        }
        catch (PDOException $e) {
            $error =  "Error al modificar" . self::$error_conexion;
            $error.= $e->getMessage();
            return $error;
        }
    }

}
