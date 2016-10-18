<?php

  include 'Administrador_proceso.php';
  include 'Administrador_equipo.php';
  include 'Administrador_componente.php';
  include 'Simulador_procesos.php';

  class Asignador_tareas {

    private $tarea;
    private $datos_tarea;
    private $administrador;
    private $simulador_procesos;

    function __construct( $tarea, $datos_tarea ) {
      $this->tarea = $tarea;
      $this->datosTarea = $datos_tarea;
      $this->asignar_administrador( $datos_tarea[ 'tipo_administrador' ] );
    }

    public function asignar_tarea() {
      switch ( $this->tarea ) {
        case 'agregar':
          $this->administrador->agregar_nuevo( $datos_tarea );
        break;

        case 'modificar':
          $this->administrador->modificar( $datos_tarea );
        break;

        case 'eliminar':
          $this->administrador->eliminar( $datos_tarea );
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
        break;
      }
    }

    //Método que selecciona el tipo de administrador a utilizar.

    public function asignar_administrador( $tipo_administrador ) {
      switch( $administrador ){
        case 'proceso':
          $this->administrador = new Administrador_proceso();
          break;

        case 'equipo':
          $this->administrador = new Administrador_equipo();
          break;

        case 'componente':
          $this->administrador = new Administrador_componente();
          break;

        case 'simulador':
          $this->simulador_procesos = new Simulador_procesos();
      }
    }

  }

?>
