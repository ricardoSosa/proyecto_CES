<?php

  include "Componente.php";

  class Equipo {

    private $id;
    private $nombre;
    private $descripcion;
    private $ubicacion;
    private $componentes;
    private $porcentaje_uso;

    function __construct( $datos_equipo ) {
      $this->id = $datos_equipo[ 'id' ];
      $this->nombre = $datos_equipo[ 'nombre' ];
      $this->descripcion = $datos_equipo[ 'descripcion' ];
      $this->ubicacion = $datos_equipo[ 'ubicacion' ];
      $this->orcentaje_uso = $datos_equipo[ 'porcentaje_uso' ];
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

    public function obtener_ubicacion() {
      return $this->ubicacion;
    }

    public function obtener_componente( $id_componente ) {
      return $this->componentes[ 'id_componente' ];
    }

    public function obtener_porcentaje_uso() {
      return $this->porcentaje_uso;
    }

  }

?>
