<?php

  class Componente {

    private $id;
    private $nombre;
    private $descripcion;
    private $tiempoVidaMax;
    private $tiempoVidaActual;
    private $porcentajeUso;

    public __construct( $datosComponente ) {
      $this->$id = $datosComponente[ 'id' ];
      $this->$nombre = $datosComponente[ 'nombre' ];
      $this->$descripcion = $datosComponente[ 'descripcion' ];
      $this->$tiempoVidaMax = $datosComponente[ 'tiempoVidaMax' ];
      $this->$tiempoVidaActual = $datosComponente[ 'tiempoVidaActual' ];
      $this->$porcentajeUso[ 'porcentajeUso' ];
    }

    public function obtenerId() {
      return $this->$id;
    }

    public function obtenerDescripcion() {
      return $this->$descripcion;
    }

    public function obtenerTiempoVidaMax() {
      return $this->$tiempoVidaMax;
    }

    public function obtenerTiempoVidaActual() {
      return $this->$tiempoVidaActual;
    }

    public function obtenerPorcentajeUso() {
      return $this->$porcentajeUso;
    }

  }

?>
