<?php

  include_once "Equipo.php";

  //Clase que representa un proceso.
  class Proceso {
    private $id;
    private $nombre;
    private $descripcion;
    private $equipos;
    private $duracion_estimada;

    /*
     *Construct
     */
    function __construct( $datos_proceso, $equipos, $duracion_estimada ) {
      $this->id = $datos_proceso[ 'id' ];
      $this->nombre = $datos_proceso[ 'nombre' ];
      $this->descripcion = $datos_proceso[ 'descripcion' ];
      $this->equipos = $equipos;
      $this->duracion_estimada = $duracion_estimada;
    }

    /*
     *@return String $id - Retorna el id del proceso.
    */
    public function obtener_id() {
      return $this->id;
    }

    /*
     *@return String $nombre - Retorna el nombre del proceso.
    */
    public function obtener_nombre() {
      return $this->nombre;
    }

    /*
     *@return String $descripcion - Retorna la descripcion del proceso.
    */
    public function obtener_descripcion() {
      return $this->descripcion;
    }

    /*
     *@return Equipo[] $equipos - Retorna los equipos del proceso.
    */
    public function obtener_equipos() {
      return $this->equipos;
    }

    /*
     *@return Double $duracion_estimada - Retorna la duracion estimada del
     *proceso.
    */
    public function obtener_duracion_estimada() {
      return $this->duracion_estimada;
    }

  }

?>
