<?php

  include_once "Administrador.php";

  class Administrador_equipo extends Administrador {

    function __construct() {
      parent::__construct();
    }

    public function agregar_componente( $datos ) {
      $this->manejador_bd->agregar_nuevo( 'porcentajes_componentes', $datos );
    }

    public function quitar_componente( $id_componente ) {
      $this->manejador_bd->eliminar( 'porcentajes_componentes', $id_componente );
    }

  }

?>
