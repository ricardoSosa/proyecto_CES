<?php

  include_once "Administrador.php";

  class Administrador_equipo extends Administrador {

    function __construct() {
      parent::__construct( 'equipos' );
    }

    public function agregar_componente( $datos ) {
      $this->conector_bd->insertar( 'porcentajes_componentes', $datos );
    }

    public function quitar_componente( $datos ) {
      $this->conector_bd->eliminar( 'porcentajes_componentes', $datos );
    }

  }

?>
