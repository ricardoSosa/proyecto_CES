<?php

  public class Asignador_Tareas {

    private $tarea;
    private $datos_tarea;
    private $administrador_tarea;

    public __construct( $tarea, $datos_tarea ) {
      $this->tarea = $tarea;
      $this->datos_tarea = $datos_tarea;
    }

    public function asignar_tarea() {
      switch ( $this->$tarea ) {
        case 'añadir':
          $this->$administrador_tarea = new Manejador_Altas_Inventario();
          $this->$administrador_tarea->entender_tipo_alta( $this->$datos_tarea );
        break;

        case 'modificar':
          $this->$administrador_tarea = new Manejador_Cambios_Inventario();
          $this->$administrador_tarea->entender_tipo_cambio( $this->$datos_tarea );
        break;

        case 'eliminar':
          $this->$administrador_tarea = new Manejador_Bajas_Inventario();
          $this->$administrador_tarea->entender_tipo_baja( $this->$datos_tarea );
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
