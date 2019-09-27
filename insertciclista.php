<?php
require_once 'Ciclista.php';
require_once 'RepositorioCiclista.php';

$numero = (int) $_POST['numero'];
$nombre = $_POST['nombre'];
$edad = (int) $_POST['edad'];
$equipo = $_POST['equipo'];

$c = new Ciclista($numero, $nombre, $edad, $equipo);
echo "Creado el nuevo ciclista: $c<br>"; 

$r = new RepositorioCiclista();
echo $r->guardarCiclistaEnBD($c);
