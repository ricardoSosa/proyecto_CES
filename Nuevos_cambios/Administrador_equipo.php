<?php

  include_once "Administrador.php";

  class Administrador_equipo extends Administrador {
    const NOMBRE_TABLA_PORCENTAJES = 'porcentajes_componentes';
    const NUM_IDS_PORCENTAJES = 2;

    function __construct() {
      parent::__construct( 'equipos' );
    }

    public function agregar_componente( $datos ) {
      $this->conector_bd->insertar( self::NOMBRE_TABLA_PORCENTAJES, $datos );
    }

    public function modificar_porcentaje_componente( $datos ) {
      $this->conector_bd->modificar( self::NOMBRE_TABLA_PORCENTAJES, $datos, self::NUM_IDS_PORCENTAJES );
    }

    public function quitar_componente( $datos ) {
      $this->conector_bd->eliminar( self::NOMBRE_TABLA_PORCENTAJES, $datos );
    }

    public function obtener_porcentajes_componentes( $datos ) {
      $this->conector_bd->obtener_informacion( self::NOMBRE_TABLA_PORCENTAJES, $datos );
    }

  }

?>
