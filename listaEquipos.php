<?php
require_once 'RepositorioEquipo.php';
require_once 'Equipo.php';

$r = new RepositorioEquipo();

// $equipos es un array compuesto por objetos de clase Equipo, tantos como 
// haya en la Base de Datos:
$equipos = $r->getAll();

// Si getAll no retornó un array, mostrar el error y finalizar de inmediato:
if (! is_array($equipos)) die($equipos);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Lista de equipos</title>
    </head>
    <body>
        <h1>Lista de equipos</h1>
        <table border="1">
            <tr>
                <th>Equipo</th><th>Director</th>
                <th>Modificar</th><th>Eliminar</th>
            </tr>
<?php
foreach ( $equipos as $unEquipo ) {
            echo '<tr>';
            echo '<td>' . $unEquipo->getNombre() . '</td>';
            echo '<td>' . $unEquipo->getDirector() . '</td>';

            //Agregamos dos enlaces, uno para modificar...
            $link = "modificar.php?e=" . $unEquipo->getNombre(); 
            echo "<td><a href='$link'>Modificar</td>";

            // ... y el otro para eliminar:
            $link = "eliminar.php?e=" . $unEquipo->getNombre(); 
            echo "<td><a href='$link'>Eliminar</td>";
            echo '</tr>';
}
?>
        </table>
    </body>
</html>
