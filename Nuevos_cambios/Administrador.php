<?php

  include_once "Manejador_base_datos.php";

  abstract class Administrador {
    const NUM_IDS_PRINCIPAL = 1;
    public $conector_bd;
    private $nombre_tabla_principal;

    function __construct( $nombre_tabla ) {
      $this->conector_bd = new Conector_base_datos();
      $this->nombre_tabla_principal = $nombre_tabla;
    }

    public function agregar_nuevo( $datos ) {
      $this->conector_bd->insertar( $this->nombre_tabla_principal, $datos );
    }

    public function modificar( $datos ) {
      $this->conector_bd->modificar( $this->nombre_tabla_principal, $datos, self::NUM_IDS_PRINCIPAL );
    }

    public function eliminar( $datos_eliminacion ) {
      $id = $datos_eliminacion[ 'id' ];

      $this->conector_bd->eliminar( $this->nombre_tabla_principal, $id );
    }

    public function obtener_datos( $datos ) {
      $this->conector_bd->obtener_informacion( $this->nombre_tabla_principal, $datos );
    }

  }
?>
