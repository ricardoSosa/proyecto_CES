<?php

  include_once "Administrador.php";

  class Administrador_proceso extends Administrador {
    const NOMBRE_TABLA_PORCENTAJES = 'porcentajes_equipos';
    const NOMBRE_TABLA_HISTORIAL = 'historial_procesos';
    const NUM_IDS_PORCENTAJES = 2;

    function __construct() {
      parent::__construct( 'procesos' );
    }

    public function iniciar_proceso( $datos ) {
      $this->conector_bd->insertar( self::NOMBRE_TABLA_HISTORIAL, $datos );
    }

    public function finalizar_proceso( $datos ) {
      $this->conector_bd->modificar( self::NOMBRE_TABLA_HISTORIAL, $datos );
    }

    public function agregar_equipo( $datos ) {
      $this->conector_bd->insertar( self::NOMBRE_TABLA_PORCENTAJES, $datos );
    }

    public function modificar_porcentaje_equipo( $datos ) {
      $this->conector_bd->modificar( self::NOMBRE_TABLA_PORCENTAJES, $datos, self::NUM_IDS_PORCENTAJES );
    }

    public function quitar_equipo( $datos ) {
      $this->conector_bd->eliminar( self::NOMBRE_TABLA_PORCENTAJES, $datos );
    }

    public function obtener_porcentajes_equipos() {
      $this->conector_bd->obtener_informacion( self::NOMBRE_TABLA_PORCENTAJES, null );
    }

    public function obtener_ids_equipos() {
      $ids_equipos = array();
      $porcentajes_equipos = $this->obtener_porcentajes_equipos();
      foreach( $porcentajes_equipos as $porcentaje_equipo ) {
        $ids_equipos[] = $porcentaje_equipo[ 'id_equipo' ];
      }

      return $ids_equipos;
    }

  }

?>
