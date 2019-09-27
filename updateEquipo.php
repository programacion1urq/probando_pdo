<?php
require_once 'RepositorioEquipo.php';
require_once 'Equipo.php';
$r = new RepositorioEquipo();
//Instanciamos un equipo con los valores recibidos:
$eq = new Equipo($_POST['nombre_equipo'], $_POST['director']);

//Enviamos los datos nuevos junto con el viejo nombre, para identificarlo:
$x = $r->modificar($eq, $_POST['nombre_viejo']);

if ($x === true) {
    echo "Modificado correctamente";
}
else {
    echo $x;
}
