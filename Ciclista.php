<?php
class Ciclista
{
    private $numero;
    private $nombre;
    private $edad;
    private $equipo;
    

    public function __construct($num, $nom, $ed, $eq)
    {
        $this->numero = $num;
        $this->nombre = $nom;
        $this->edad = $ed;
        $this->equipo = $eq;
    }

    public function __toString()
    {
        $c = "Ciclista Nº $this->numero: $this->nombre. $this->edad años."; 
        $c.= "Equipo $this->equipo";
        return $c;
    }

    // getters: 
    public function getNumero() { return $this->numero;}
    public function getNombre() { return $this->nombre;}
    public function getEdad() { return $this->edad;}
    public function getEquipo() { return $this->equipo;}


}
