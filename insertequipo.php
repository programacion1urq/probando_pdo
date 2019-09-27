<?php
require_once 'Equipo.php';
require_once 'RepositorioEquipo.php';

$equipo = $_POST['nombre_equipo'];
$director = $_POST['director'];

$e = new Equipo($equipo, $director);
echo "Creado el nuevo equipo: $e<br>"; 

$r = new RepositorioEquipo();
echo $r->guardarEquipoEnBD($e);
