<?php

  include_once 'Administrador_proceso.php';
  include_once 'Administrador_equipo.php';
  include_once 'Administrador_componente.php';
  include_once 'Encargado_simulacion.php';

  /*Clase que sirve como delegador de lo que el usuario quiere hacer*/
  class Asignador_tareas {

    private $tarea;
    private $datos_elemento;
    private $encargado_tarea;

    /*
     *Construct
     *@param String $datos_tarea - Contiene los datos de la tarea a realizar.
     *@param Array $datos_elemento - Contiene los datos sobre el elemento a trabajar.
     */
    function __construct( $datos_tarea, $datos_elemento ) {
      $this->tarea = $datos_tarea[ 'nombre_tarea' ];
      $this->datos_elemento = $datos_elemento;

      $this->encontrar_encargado_tarea( $datos_tarea[ 'tipo_elemento' ] );
      $this->asignar_tarea();
    }


    /*
     *Encuentra quien debería hacer la tarea segun el elemento sobre quien es la tarea
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
          $this->encargado_tarea = new Encargado_simulacion();
          break;
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
          $this->encargado_tarea->agregar_nuevo( $this->datos_elemento );
        break;

        case 'modificar':
          $this->encargado_tarea->modificar( $this->datos_elemento );
        break;

        case 'eliminar':
          $this->encargado_tarea->eliminar( $this->datos_elemento );
        break;

        case 'generar historial':
          $this->encargado_tarea->generar_historial();
        break;

        case 'consultar lista':
          $this->encargado_tarea->obtener_datos( null, true );
        break;

        case 'consulta especifica':
          $this->encargado_tarea->obtener_datos( $this->datos_elemento, true );
        break;

        case 'simular':
          $this->encargado_tarea->mandar_simulacion( $this->datos_elemento['id_procesos_duracion'] );
        break;

        //Tareas del administrador de proceso-----------------------------------
        case 'activar proceso':
          $this->encargado_tarea->iniciar_proceso( $this->datos_elemento );
        break;

        case 'finalizar proceso':
          $this->encargado_tarea->finalizar_proceso( $this->datos_elemento );
        break;

        case 'agregar equipo a proceso':
          $this->encargado_tarea->agregar_equipo( $this->datos_elemento );
        break;

        case 'modificar porcentaje de equipo':
          $this->encargado_tarea->modificar_porcentaje_equipo( $this->datos_elemento );
        break;

        case 'eliminar equipo de proceso':
          $this->encargado_tarea->quitar_equipo( $this->datos_elemento );
        break;

        case 'consultar porcentajes de equipos':
          $this->encargado_tarea->obtener_porcentajes_totales();
        break;

        //Tareas del administrador de equipo------------------------------------
        case 'agregar componente a equipo':
          $this->encargado_tarea->agregar_componente( $this->datos_elemento );
        break;

        case 'modificar porcentaje de componente':
          $this->encargado_tarea->modificar_porcentaje_componente( $this->datos_elemento );
        break;

        case 'eliminar componente de equipo':
          $this->encargado_tarea->quitar_componente( $this->datos_elemento );
        break;

        case 'consultar porcentajes de componentes':
          $this->encargado_tarea->obtener_porcentajes_totales();
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
