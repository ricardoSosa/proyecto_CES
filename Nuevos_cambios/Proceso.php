<?php

  include_once "Equipo.php";

  class Proceso {
    private $id;
    private $nombre;
    private $descripcion;
    private $equipos;
    private $duracion_estimada;

    function __construct( $datos_proceso, $equipos, $duracion_estimada ) {
      $this->id = $datos_proceso[ 'id' ];
      $this->nombre = $datos_proceso[ 'nombre' ];
      $this->descripcion = $datos_proceso[ 'descripcion' ];
      $this->equipos = $equipos;
      $this->duracion_estimada = $datos_proceso[ 'duracion_estimada' ];
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

    public function obtener_equipos() {
      return $this->equipos;
    }

    public function obtener_duracion_estimada() {
      return $this->duracion_estimada;
    }

  }

?>
