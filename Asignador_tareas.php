<?php

  include 'Administrador_proceso.php';
  include 'Administrador_equipo.php';
  include 'Administrador_componente.php';
  include 'Simulador_procesos.php';

  //Se recive la tarea del usuario y se la pasa a un Asignador_tareas

  $tarea_usuario = $_POST[ 'tarea' ];
  $datos_tarea = $_POST[ 'datos' ];

  $asignador_tareas = new Asignador_tareas( $tarea_usuario, $datos_tarea );

  //----------------------------------------------------------------------------
  // CLASE ASIGNADOR DE TAREAS
  //
  // Esta clase esta encargadas de manejar la tarea que el usuario quiere hacer
  //----------------------------------------------------------------------------

  class Asignador_tareas {

    private $tarea;
    private $datos_tarea;
    private $administrador;
    private $simulador_procesos;

    function __construct( $tarea, $datos_tarea ) {
      $this->tarea = $tarea;
      $this->datos_tarea = $datos_tarea;

      $this->asignar_administrador( $this->datos_tarea[ 'tipo_elemento' ] );
      $this->asignar_tarea();
    }

    //Método que selecciona el tipo de administrador a utilizar.

    public function asignar_administrador( $tipo_elemento ) {
      switch( $tipo_elemento ){
        case 'procesos':
          $this->administrador = new Administrador_proceso();
          break;

        case 'equipos':
          $this->administrador = new Administrador_equipo();
          break;

        case 'componentes':
          $this->administrador = new Administrador_componente();
          break;

        case 'simulador':
          $this->simulador_procesos = new Simulador_procesos();
      }
    }

    public function asignar_tarea() {
      switch ( $this->tarea ) {
        case 'agregar':
          $this->administrador->agregar_nuevo( $this->datos_tarea );
        break;

        case 'modificar':
          $this->administrador->modificar( $this->datos_tarea );
        break;

        case 'eliminar':
          $this->administrador->eliminar( $this->datos_tarea );
        break;

        case 'generar historial':
          $this->administrador->generar_historial();
        break;

        case 'simular':
          $this->simulador_procesos->simular( $procesos );
        break;

        case 'activar proceso':
          $this->administrador->iniciar_proceso( $id_proceso );
        break;

        default:
          # code...
          echo "Tarea invalida";
        break;
      }
    }

  }

?>
