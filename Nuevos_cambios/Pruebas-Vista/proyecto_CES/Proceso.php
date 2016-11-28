<?php

  include "Equipo.php";

  class Proceso {

    private $id;
    private $nombre;
    private $descripcion;
    private $equipos;
    private $duracion_estimada;

    function __contruct( $datos_proceso ) {
      $this->id = $datos_proceso[ 'id' ];
      $this->nombre = $datos_proceso[ 'nombre' ];
      $this->descripcion = $datos_proceso[ 'descripcion' ];
      $this->equipos = $datos_proceso[ 'equipos' ];
      $this->duracion_estimada = $datos[ 'duracion_estimada' ];
    }


    public function obtener_id() {
      return $this->id;
    }

    public function obtener_nombre() {
      return $this->nombre;
    }

    public function obtener_descripcion() {
      return $this->descripcion;
    }

    public function obtener_equipo( $id_equipo ) {
      return $this->equipos[ 'id_equipo' ];
    }

    public function obtener_duracion_estimada() {
      return $this->duracion_estimada;
    }

  }

?>
