<?php
class Equipo
{
    private $nombre;
    private $director;

    public function __construct($n, $d)
    {
        $this->nombre = $n;
        $this->director = $d;
    }

    public function __toString()
    {
        return "Equipo $this->nombre. Director: $this->director";
    }

    public function getNombre() { return $this->nombre;}
    public function getDirector() { return $this->director;}

}
