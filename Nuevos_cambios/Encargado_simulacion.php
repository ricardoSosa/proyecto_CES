<?php

  include_once 'Simulador_procesos.php';
  include_once 'Administrador_proceso.php';
  include_once 'Administrador_equipo.php';
  include_once 'Administrador_componente.php';
  include_once 'Proceso.php';
  include_once 'Equipo.php';
  include_once 'Componente.php';

  class Encargado_simulacion {
    const BANDERA_RET_INMEDIATO = false;
    private $simulador_procesos;
    private $administrador_proceso;
    private $administrador_equipo;
    private $administrador_componente;

    function __construct() {
      $this->simulador_procesos = new Simulador_procesos();
      $this->administrador_proceso = new Administrador_proceso();
      $this->administrador_equipo = new Administrador_equipo();
      $this->administrador_componente = new Administrador_componente();
    }

    public function mandar_simulacion( $datos_procesos ) {
      $procesos = $this->construir_procesos( $datos_procesos );
      $this->simulador_procesos->iniciar_simulacion( $procesos );
    }

    private function construir_procesos( $datos_procesos ) {
      $procesos = [];
      foreach( $datos_procesos as $id_proceso=>$duracion_estimada ) {
        $procesos[] = $this->recrear_proceso( $id_proceso, $duracion_estimada );
      }

      return $procesos;
    }

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
