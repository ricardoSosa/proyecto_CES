<?php

  include_once "Administrador.php";

  //Clase administradora de los datos de los procesos de la empresa.
  class Administrador_proceso extends Administrador {
    const NOMBRE_TABLA_PORCENTAJES = 'porcentajes_equipos';
    const NOMBRE_TABLA_HISTORIAL = 'historial_procesos';
    const NUM_IDS_PORCENTAJES = 2;

    /*
     *Construct
     */
    function __construct() {
      parent::__construct( 'procesos' );
    }

    /*
     *@param String[ASSOC] $datos - Recibe el id del proceso a iniciar y su
     * respectiva fecha de inicio.
     *@return void
    */
    public function iniciar_proceso( $datos ) {
      $this->conector_bd->insertar( self::NOMBRE_TABLA_HISTORIAL, $datos );
    }

    /*
     *@param String[ASSOC] $datos - Recibe el id del proceso a iniciar y su
     * respectiva fecha de inicio.
     *@return void
    */
    public function finalizar_proceso( $datos ) {
      $this->conector_bd->modificar( self::NOMBRE_TABLA_HISTORIAL, $datos );
    }

    /*
     *@param String[ASSOC] $datos - Recibe el id del equipo a agregar y su
     *respectivo porcentaje de uso.
     *@return void
    */
    public function agregar_equipo( $datos ) {
      $this->conector_bd->insertar( self::NOMBRE_TABLA_PORCENTAJES, $datos );
    }

    /*
     *@param String[ASSOC] $datos - Recibe el id del equipo y el nuevo
     *porcentaje de uso a ingresar.
     *@return void
    */
    public function modificar_porcentaje_equipo( $datos ) {
      $this->conector_bd->modificar( self::NOMBRE_TABLA_PORCENTAJES, $datos, self::NUM_IDS_PORCENTAJES );
    }

    /*
     *@param String[ASSOC] $datos - Recibe los ids del equipo a quitar.
     *@return void
    */
    public function quitar_equipo( $ids ) {
      $this->conector_bd->eliminar( self::NOMBRE_TABLA_PORCENTAJES, $datos );
    }

    public function obtener_porcentajes_totales(  ) {
      $this->conector_bd->obtener_informacion( self::NOMBRE_TABLA_PORCENTAJES, null, true );
    }

    /*
     *@param String $datos - Recibe el id del proceso del que se quiere
     *obtener sus componentes y respectivos porcentajes.
     *@return String[ASSOC] $porcentajes_componentes - Retorna un arreglo asociativo
     *con los ids de los equipos como llaves y sus respectivos porcentajes.
    */
    public function obtener_porcentajes_proceso( $id_proceso ) {
      $porcentajes_equipos = array();
      $porcs_equipos = $this->conector_bd->obtener_informacion( self::NOMBRE_TABLA_PORCENTAJES, null, $bandera_retorno_inmediato );
      for( $indice = 0; $indice < count($porcs_equipos); $indice++ ) {
        if( $porcs_equipos[ $indice ][ 'id_proceso' ] == $id_proceso) {
          $porcentajes_equipos[$porcs_equipos[ $indice ][ 'id_equipo' ]] = $porcs_equipos[ $indice ][ 'porcentaje_uso' ];
        }
      }

      return $porcentajes_equipos;
    }

  }

?>
