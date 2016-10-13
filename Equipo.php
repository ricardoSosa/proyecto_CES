<?php

  include( "Componente.php" );

  class Equipo {

    private $id;
    private $nombre;
    private $descripcion;
    private $ubicacion;
    private $componentes;
    private $porcentaje_uso;

    public function Equipo() {

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
