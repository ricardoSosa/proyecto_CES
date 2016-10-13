<?php

<<<<<<< HEAD
=======
  include( "Equipo.php" );

>>>>>>> 7b856c010ab40608596c1d50212d9de84570a1b5
  class Proceso {

    private $id;
    private $nombre;
    private $descripcion;
    private $equipos;
    private $duracionEstimada;

    public function Proceso() {

    }

<<<<<<< HEAD
    public function obtenerId() {

    }

    public function obtenerNombre() {

    }

    public function obtenerDescripcion() {

    }

    public function obtenerEquipo( $idEquipo ) {
=======
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
>>>>>>> 7b856c010ab40608596c1d50212d9de84570a1b5

    public function obtener_duracion_estimada() {
      return $this->duracion_estimada;
    }

  }

?>
