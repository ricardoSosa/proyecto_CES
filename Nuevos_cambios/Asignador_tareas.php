<?php

  include 'Administrador_proceso.php';
  include 'Administrador_equipo.php';
  include 'Administrador_componente.php';
  include 'Simulador_procesos.php';
  /*Clase que sirve como delegador de lo que el usuario quiere hacer*/
  class Asignador_tareas {

    private $tarea;
    private $datos_elemento;
    private $encargado_tarea;

    /*
     *Construct
     *@param String $tarea - contiene la tarea que el usuario quiere hacer
     *@param Array $datos_tarea - contiene todos los datos para realizar la tarea
     */
    function __construct( $datos_tarea, $datos_elemento ) {
      $this->tarea = $datos_tarea[ 'nombre_tarea' ];
      $this->datos_elemento = $datos_elemento;

      $this->encontrar_encargado_tarea( $this->datos_tarea[ 'tipo_elemento' ] );
      $this->asignar_tarea();
    }


    /*
     *Encuentra quien deberia hacer la tarea segun el elemento sobre quien es la tarea
     *@param String $tipo_elemento - Contiene el nombre del elemento sobre quien se va a hacer la tarea
     *@return void
     */
    public function encontrar_encargado_tarea( $tipo_elemento ) {
      switch( $tipo_elemento ){
        case 'procesos':
          $this->encargado_tarea = new Administrador_proceso();
          break;

        case 'equipos':
          $this->encargado_tarea = new Administrador_equipo();
          break;

        case 'componentes':
          $this->encargado_tarea = new Administrador_componente();
          break;

        case 'simulador':
          $this->encargado_tarea = new Simulador_procesos();
      }
    }

    /*
     *Asigna la tarea del usuario a quien la deberia realizar
     *@return void
     */
    public function asignar_tarea() {
      switch ( $this->tarea ) {

        //Tareas generales------------------------------------------------------
        case 'agregar':
          $this->encargado_tarea->agregar_nuevo( $this->datos_tarea );
        break;

        case 'modificar':
          $this->encargado_tarea->modificar( $this->datos_tarea );
        break;

        case 'eliminar':
          $this->encargado_tarea->eliminar( $this->datos_tarea );
        break;

        case 'generar historial':
          $this->encargado_tarea->generar_historial();
        break;

        case 'consultar lista':
          $this->encargado_tarea->obtener_datos( null );
        break;

        case 'consulta especifica':
          $this->encargado_tarea->obtener_datos( $this->datos_tarea );
        break;

        case 'simular':
          $this->encargado_tarea->simular( $procesos );
        break;

        //Tareas del administrador de proceso-----------------------------------
        case 'activar proceso':
          $this->encargado_tarea->iniciar_proceso( $this->datos_tarea );
        break;

        case 'finalizar proceso':
          $this->encargado_tarea->finalizar_proceso( $this->datos_tarea );
        break;

        case 'agregar equipo a proceso':
          $this->encargado_tarea->agregar_equipo( $this->datos_tarea );
        break;

        case 'modificar porcentaje de equipo':
          $this->encargado_tarea->modificar_porcentaje_equipo( $this->datos_tarea );
        break;

        case 'eliminar equipo de proceso':
          $this->encargado_tarea->quitar_equipo( $this->datos_tarea );
        break;

        case 'consultar porcentajes de equipos':
          $this->encargado_tarea->obtener_porcentajes_equipos( null );
        break;

        //Tareas del administrador de equipo------------------------------------
        case 'agregar componente a equipo':
          $this->encargado_tarea->agregar_componente( $this->datos_tarea );
        break;

        case 'modificar porcentaje de componente':
          $this->encargado_tarea->modificar_porcentaje_componente( $this->datos_tarea );
        break;

        case 'eliminar componente de equipo':
          $this->encargado_tarea->quitar_componente( $this->datos_tarea );
        break;

        case 'consultar porcentajes de componentes':
          $this->encargado_tarea->obtener_porcentajes_componentes( null );
        break;

        default:
          # code...
          echo "Tarea inválida";
        break;
      }
    }

  }

/**
 *
 */
function Main() {
    $_POST = json_decode(file_get_contents('php://input'),true);
    $tarea_usuario = $_POST[ 'tarea' ];
    $datos_tarea = $_POST[ 'datos' ];

    $asignador_tareas = new Asignador_tareas( $tarea_usuario, $datos_tarea );
  }

  Main();

?>
