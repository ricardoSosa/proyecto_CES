<?php

  include "Manejador_bd.php";

  abstract class Administrador {

    private $manejador_bd;

    function __construct() {
      $this->manejador_bd = new Manejador_base_datos();
    }

    public function agregar_nuevo( $nombre_tabla, $datos ) {
      $this-$manejador_bd->insertar( $nombre_tabla, $datos );
    }

    public function modificar( $nombre_tabla, $datos ) {
      $this->manejador_bd->modificar( $nombre_tabla, $datos  );
    }

    public function eliminar( $nombre_tabla, $id ) {
      $this->manejador_bd->eliminar( $nombre_tabla, $id );
    }

    public function leer_datos( $nombre_tabla, $datos ) {
      $this->manejador_bd->realizar_consulta( $nombre_tabla, $datos );
    }

  }
?>
