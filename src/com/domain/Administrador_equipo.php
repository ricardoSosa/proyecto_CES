<?php

  include_once "Administrador.php";

  /*Clase administradora de los datos de los equipos de la empresa.*/
  class Administrador_equipo extends Administrador {
    const NOMBRE_TABLA_PORCENTAJES = 'porcentajes_componentes';
    const NUM_IDS_PORCENTAJES = 2;

    /*
     *Construct
    */
    function __construct() {
      parent::__construct( 'equipos' );
    }

    /*
     *@param String[ASSOC] $datos - Recibe e id del componente a agregar y su
     respectivo porcentaje de uso.
     *@return void
    */
    public function agregar_componente( $datos ) {
      $this->conector_bd->insertar( self::NOMBRE_TABLA_PORCENTAJES, $datos );
    }

    /*
     *@param String[ASSOC] $datos - Recibe el id del componente y el nuevo
     *porcentaje de uso a ingresar.
     *@return void
    */
    public function modificar_porcentaje_componente( $datos ) {
      $this->conector_bd->modificar( self::NOMBRE_TABLA_PORCENTAJES, $datos, self::NUM_IDS_PORCENTAJES );
    }

    /*
     *@param String[ASSOC] $ids - Recibe los ids del componente a quitar.
     *@return void
    */
    public function quitar_componente( $ids ) {
      $this->conector_bd->eliminar( self::NOMBRE_TABLA_PORCENTAJES, $ids );
    }

    /*
    *Método que obtiene la lista de porcentajes totales de los procesos mediante
    * un json.
    */
    public function obtener_porcentajes_totales() {
      $this->conector_bd->obtener_informacion( self::NOMBRE_TABLA_PORCENTAJES, null, true );
    }

    /*
     *@param String $id_equipo - Recibe el id del equipo del que se quiere
     *obtener sus componentes y respectivos porcentajes.
     *@return String[ASSOC] $porcentajes_componentes - Retorna un arreglo asociativo
     *con los ids de los componentes como llaves y sus respectivos porcentajes.
    */
    public function obtener_porcentajes_equipo( $id_equipo ) {
      $porcentajes_componentes = array();
      $porcs_componentes = $this->conector_bd->obtener_informacion( self::NOMBRE_TABLA_PORCENTAJES, null, false );
      for( $indice = 0; $indice < count($porcs_componentes); $indice++ ) {
        if( $porcs_componentes[ $indice ][ 'id_equipo' ] == $id_equipo) {
          $porcentajes_componentes = array(
            $porcs_componentes[ $indice ][ 'id_componente' ] => $porcs_componentes[ $indice ][ 'porcentaje_uso' ]
          );
        }
      }

      return $porcentajes_componentes;
    }

  }

?>
