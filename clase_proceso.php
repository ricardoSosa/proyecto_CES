<?php

  include("clase_equipo.php");

  class Proceso{

    private $id;
    private $nombre;
    private $descripcion;
    private $equipos;
    private $duracion_estimada;

    public function Proceso(){

    }

    public function obtener_id(){
      return $this->id;
    }

    public function obtener_nombre(){
      return $this->nombre;
    }

    public function obtener_descripcion(){
      return $this->descripcion;
    }

    public function obtener_equipo($id_equipo){
      return $this->equipos['id_equipo'];
    }

    public function obtener_duracion_estimada(){
      return $this->duracion_estimada;
    }

  }

?>
