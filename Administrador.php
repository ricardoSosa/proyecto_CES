<?php

  include_once "Manejador_base_datos.php";

  abstract class Administrador {

    private $manejador_bd;

    function __construct() {
      $this->manejador_bd = new Manejador_base_datos();
    }

    public function agregar_nuevo( $datos ) {
      $tipo_elemento = $datos[ 'tipo_elemento' ];

      $this->manejador_bd->insertar( $tipo_elemento, $datos );
    }

    public function modificar( $tipo_elemento, $datos ) {
      $this->manejador_bd->modificar( $tipo_elemento, $datos  );
    }

    public function eliminar( $tipo_elemento, $id ) {
      $this->manejador_bd->eliminar( $tipo_elemento, $id );
    }

    public function leer_datos( $tipo_elemento, $datos ) {
      $this->manejador_bd->realizar_consulta( $tipo_elemento, $datos );
    }

  }
?>
