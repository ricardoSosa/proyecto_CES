<?php

  include( "Manejador_bd.php" );

  abstract class Administrador {

    private $manejador_bd;

    public function Administrador() {

      $this->manejador_bd = new Manejador_base_datos();

    }

    public function agregarNuevo( $datos ) {

      $this->manejador_bd->insertar( $datos );

    }

    public function eliminar( $datos ) {

      $this->manejador_bd->eliminar( $datos );

    }

    public function modificar( $id, $datos ) {

    }

    public function leer_datos( $datos ) {

    }

    public function generar_historial() {

    }

  }
?>
