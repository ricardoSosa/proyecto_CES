<?php

  include_once "Manejador_base_datos.php";

  abstract class Administrador {

    private $conector_bd;
    private $nombre_tabla_principal;

    function __construct( $nombre_tabla ) {
      $this->conector_bd = new Conector_base_datos();
      $this->nombre_tabla_principal = $nombre_tabla;
    }

    public function agregar_nuevo( $datos ) {
      $this->conector_bd->insertar( $nombre_tabla_principal, $datos );
    }

    public function eliminar( $datos ) {
      $nombre_id = $datos[ 'nombre_id' ];
      $valor_id = $datos[ 'valor_id' ];
      $this->conector_bd->eliminar( $nombre_tabla_principal, $nombre_id, $valor_id );
    }

    public function leer_datos( $datos ) {
      $this->conector_bd->obtener_informacion( $nombre_tabla_principal, $datos );
    }

    public function modificar( $datos ) {
      $this->conector_bd->modificar( $nombre_tabla_principal, $datos );
    }

  }
?>
