<?php

  include 'Administrador_proceso.php';
  include 'Administrador_equipo.php';
  include 'Administrador_componente.php';
  include 'Simulador_procesos.php';
  /*Clase que sirve como delegador de lo que el usuario quiere hacer*/
  class Asignador_tareas {

    private $tarea;
    private $datos_tarea;
    private $encargado_tarea;

    /*
     *Construct
     *@param String $tarea - contiene la tarea que el usuario quiere hacer
     *@param Array[][] $datos_tarea - contiene todos los datos para realizar la tarea
     */
    function __construct( $tarea, $datos_tarea ) {
      $this->tarea = $tarea;
      $this->datos_tarea = $datos_tarea;

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
     *Asigna la tarea del usuario al quien la deberia realizar
     *@return void
     */
    public function asignar_tarea() {
      switch ( $this->tarea ) {
        case 'agregar':
          $this->encargado_tarea->agregar_nuevo( $this->datos_tarea );
        break;

        case 'modificar':
          $tipo_elemento = $this->datos_tarea[ 'tipo_elemento' ];

          $this->encargado_tarea->modificar( $tipo_elemento, $this->datos_tarea );
        break;

        case 'eliminar':
          $tipo_elemento = $this->datos_tarea[ 'tipo_elemento' ];
          $id = $this->datos_tarea[ 'id' ];

          $this->encargado_tarea->eliminar( $tipo_elemento, $id );
        break;

        case 'generar historial':
          $this->encargado_tarea->generar_historial();
        break;

        case 'simular':
          $this->encargado_tarea->simular( $procesos );
        break;

        case 'activar proceso':
          $this->encargado_tarea->iniciar_proceso( $id_proceso );
        break;

        case 'consultar':
          $this->encargado_tarea->leer_datos( $this->datos_tarea );
        break;

        default:
          # code...
          echo "Tarea invalida";
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
