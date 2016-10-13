<?php

  include 'Administrador.php';

  class Asignador_Tareas {

    private $tarea;
    private $datos_tarea;
    private $administrador;

    public __construct( $tarea, $datos_tarea ) {
      $this-$administrador = new Administrador();

      $this->tarea = $tarea;
      $this->datosTarea = $datos_tarea;
    }

    public function asignarTarea() {
      switch ( $this->$tarea ) {
        case 'añadir':
          $administrador->añadir( $datos_tarea );
        break;

        case 'modificar':
          $administrador->modificar( $datos_tarea );
        break;

        case 'eliminar':
          $administrador->eliminar( $datos_tarea );
        break;

        case 'generar reporte':
          #code...
        break;

        case 'simular':
          # code...
        break;

        case 'activar proceso':
          # code...
        break;

        default:
          # code...
        break;
      }
    }

  }

?>
