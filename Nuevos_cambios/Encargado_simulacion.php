<?php

  include_once 'Simulador_procesos.php';
  include_once 'Administrador.php';
  include_once 'Proceso.php';
  include_once 'Equipo.php';
  include_once 'Componente.php';

  class Encargado_simulacion {
    private $simulador_procesos;
    private $administrador_proceso;
    private $administrador_equipo;
    private $administrador_componente;

    function __construct( ) {
      $this->simulador_procesos = new Simulador_procesos();
    }

    public function mandar_simulacion( $datos_procesos ) {
      $procesos = $this->construir_procesos( $datos_procesos );
      $this->simulador_procesos->iniciar_simulacion( $procesos );
    }

    private function construir_procesos( $datos_procesos ) {
      foreach( $datos_procesos as $id_proceso=>$duracion_estimada ) {
        $procesos = $this->recrear_proceso( $datos_proceso, $duracion_estimada );
      }

      return $procesos;
    }

    private function recrear_proceso( $id_proceso, $duracion_estimada ) {
      $equipos_necesarios = array();
      $ids_equipos = $this->administrador_proceso->obtener_ids_equipos( $id_proceso );
      foreach( $ids_equipos as $id_equipo ) {
        $equipos_necesarios[] = $this->recrear_equipo( $datos_componente );
      }
      $datos_proceso = $this->administrador_proceso->obtener_datos( $id_proceso );
      $proceso = new Proceso( $datos_proceso, $equipos_necesarios, $duracion_estimada );

      return $proceso;
    }

    private function recrear_equipo( $id_equipo ) {
      $componentes_necesarios = array();
      $ids_componentes = $this->administrador_equipo->obtener_ids_componentes( $id_equipo );
      foreach( $ids_componentes as $id_componente ) {
        $componentes_necesarios[] = $this->recrear_componente( $datos_componente );
      }
      $datos_equipo = $this->administrador_equipo->obtener_datos( $id_equipo );
      $equipo = new Equipo( $datos_equipo, $componentes_necesarios );

      return $equipo;
    }

    private function recrear_componente( $id_componente ) {
      $datos_componente = $this->administrador_componente->obtener_datos( $id_componente );
      $componente = new Componente( $datos_componente );

      return $componente;
    }

  }

?>
