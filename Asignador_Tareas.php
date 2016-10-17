<?php

  include 'Administrador.php';

  class Asignador_tareas {

    private $tarea;
    private $datos_tarea;
    private $administrador;
    private $simulador_procesos;

    function __construct( $tarea, $datos_tarea ) {
      $this->tarea = $tarea;
      $this->datosTarea = $datos_tarea;
      $this->administrador = new Administrador();
      $this->simulador_procesos = new simulador_procesos();
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
          #code...
        break;

        case 'simular':
          $this->simulador_procesos->simular( $procesos );
        break;

        case 'activar proceso':

        break;

        default:
          # code...
        break;
      }
    }

  }

?>
