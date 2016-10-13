<?php

  include( "clase_manejador_bd.php" );

  public abstract class Administrador {

    private $manejador_bd;

    public __construct() {

      $this->manejador_bd = new Manejador_base_datos();

    }

    public abstract function añadirElemento( $datosElemento );

    public function eliminar( $id ) {

    }

    public function modificar( $id, $datos ) {

    }

    public function leer_datos( $datos ) {

    }

    public function generar_historial() {

    }

  }
?>
