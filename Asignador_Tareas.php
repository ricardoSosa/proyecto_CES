<?php

  include 'Administrador.php';

  $tarea = $_POST[ 'tarea' ];
  $tipo_tarea = $_POST[ 'tipo_insercion' ];
  $datos_peticion = $_POST[ 'datos' ];

  $datos_tarea = array( 'tipo_insercion' => $tipo_tarea ,
                        'datos' => $datos_peticion );

  $asignador_tareas = new Asignador_tareas( $tarea, $datos_tarea );
  $asignador_tareas->asignar_tarea();


//------------------------------------------------------------------------------
  class Asignador_tareas {

    private $tarea;
    private $datos_tarea;
    private $administrador;

    function __construct( $tarea, $datos_tarea ) {
      $this-$administrador = new Administrador();

      $this->tarea = $tarea;
      $this->datosTarea = $datos_tarea;
    }

    public function asignar_tarea() {
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
