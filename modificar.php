<?php
require_once 'RepositorioEquipo.php';
require_once 'Equipo.php';
$r = new RepositorioEquipo();

$nombreViejo = $_GET['e'];
// Buscamos al equipo que coincida con el nombre recibido:
$eq = $r->getOne($nombreViejo);

//Si en lugar de retornar una instancia de Equipo, getOne ha retornado un 
//mensaje de error, mostramos el error y salimos:
if (!is_a($eq, "Equipo")) die($eq);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Modificar Equipo</title>
</head>
<body>
<h1>Modificar equipos</h1>
<form action="updateEquipo.php" method="post">
<!-- Agregamos un campo "hidden" (oculto) con el nombre anterior del equipo -->
<input type="hidden" name="nombre_viejo" value="<?=$nombreViejo?>">
<!-- Mostramos como valor por defecto de los input los valores actuales. El
usuario puede cambiarlos según lo necesite: -->
Equipo: <input name="nombre_equipo" value="<?=$eq->getNombre()?>">
<br>
Director: <input name="director" value="<?=$eq->getDirector()?>">
<br>
<input type="submit" value="Atualizar equipo">
</form>
</body></html>
