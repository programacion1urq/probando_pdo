<?php
require_once 'RepositorioEquipo.php';
$r = new RepositorioEquipo();
$nombre = $_GET['e'];

//Obtenemos desde el repositorio el objeto de clase Equipo cuyo nombre coincida 
//con el nombre recibido por GET:
$equipo = $r->getOne($nombre);

//Si en lugar de retornar una instancia de Equipo, getOne ha retornado un 
//mensaje de error, mostramos el error y salimos:
if (!is_a($equipo, "Equipo")) die($equipo);

//Eliminamos el equipo:
$x =  $r->eliminar($equipo);
if ( $x === true) {
    echo "Eliminado correctamente";
}
else {
    echo $x;
}






