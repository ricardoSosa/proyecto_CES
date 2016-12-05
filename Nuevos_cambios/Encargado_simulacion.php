<?php

  include_once 'Simulador_procesos.php';
  include_once 'Administrador_proceso.php';
  include_once 'Administrador_equipo.php';
  include_once 'Administrador_componente.php';
  include_once 'Proceso.php';
  include_once 'Equipo.php';
  include_once 'Componente.php';

  /*Clase encargada de recolectar los datos del simulador.*/
  class Encargado_simulacion {
    const BANDERA_RET_INMEDIATO = false;
    private $simulador_procesos;
    private $administrador_proceso;
    private $administrador_equipo;
    private $administrador_componente;

    /*
     *Construct
     */
    function __construct() {
      $this->simulador_procesos = new Simulador_procesos();
      $this->administrador_proceso = new Administrador_proceso();
      $this->administrador_equipo = new Administrador_equipo();
      $this->administrador_componente = new Administrador_componente();
    }

    /*Método ingresa los datos dentro del simulador.
     *@param String[] $datos_procesos - Recibe un arreglo con las duraciones
     *estimadas de los procesos y sus respectivos ids como llaves.
    */
    public function mandar_simulacion( $datos_procesos ) {
      $procesos = $this->construir_procesos( $datos_procesos );
      $this->simulador_procesos->iniciar_simulacion( $procesos );
    }

    /*Método que construye los procesos que se ingresarán dentro del simulador.
     *@param String[] $datos_procesos - Recibe un arreglo con las duraciones
     *estimadas de los procesos y sus respectivos ids como llaves.
     *@return Proceso[] procesos - Retorna un arreglo con los procesos ya
     *creados y listos para simular.
    */
    private function construir_procesos( $datos_procesos ) {
      $procesos = [];
      foreach( $datos_procesos as $id_proceso=>$duracion_estimada ) {
        $procesos[] = $this->recrear_proceso( $id_proceso, $duracion_estimada );
      }

      return $procesos;
    }

    /*Método que estructura y forma un proceso en específico.
     *@param String $id_proceso - Recibe el id del proceso a construir.
     *@param Integer $duracion_estimada - Recibe la duración estimada por el
     *usuario.
     *@return Proceso $proceso - Retorna un proceso creado.
    */
    private function recrear_proceso( $id_proceso, $duracion_estimada ) {
      $equipos_necesarios = [];
      $porcentajes_equipos = $this->administrador_proceso->obtener_porcentajes_proceso( $id_proceso );
      foreach( $porcentajes_equipos as $id_equipo=>$porcentaje_equipo ) {
        $equipos_necesarios[] = $this->recrear_equipo( $id_equipo, $porcentaje_equipo );
      }
      $id_p = array(
        'id' => $id_proceso
      );
      $datos_proceso = $this->administrador_proceso->obtener_datos( $id_p, self::BANDERA_RET_INMEDIATO )[0];
      $proceso = new Proceso( $datos_proceso, $equipos_necesarios, $duracion_estimada );

      return $proceso;
    }

    /*Método que estructura y forma un equipo en específico.
     *@param String $id_equipo - Recibe el id del equipo a construir.
     *@param Integer $porcentaje_equipo - Recibe el porcentaje de uso de un
     *equipo dentro de un proceso.
     *@return Equipo $equipo - Retorna un equipo creado.
    */
    private function recrear_equipo( $id_equipo, $porcentaje_equipo ) {
      $componentes_necesarios = [];
      $porcentajes_componentes = $this->administrador_equipo->obtener_porcentajes_equipo( $id_equipo );
      foreach( $porcentajes_componentes as $id_componente=>$porcentaje_componente ) {
        $componentes_necesarios[] = $this->recrear_componente( $id_componente, $porcentaje_componente );
      }
      $id_e = array(
        'id' => $id_equipo
      );
      $datos_equipo = $this->administrador_equipo->obtener_datos( $id_e, self::BANDERA_RET_INMEDIATO )[0];
      $equipo = new Equipo( $datos_equipo, $componentes_necesarios, $porcentaje_equipo );

      return $equipo;
    }

    /*Método que estructura y forma un componente en específico.
     *@param String $id_componente - Recibe el id del componente a construir.
     *@param Integer $porcentaje_componente - Recibe el porcentaje de uso de un
     *componente dentro de un equipo.
     *@return Componente $componente - Retorna un componente creado.
    */
    private function recrear_componente( $id_componente, $porcentaje_componente ) {
      $id_c = array(
        'id' => $id_componente
      );
      $datos_componente = $this->administrador_componente->obtener_datos( $id_c, self::BANDERA_RET_INMEDIATO )[0];
      $componente = new Componente( $datos_componente, $porcentaje_componente );

      return $componente;
    }

  }
?>
