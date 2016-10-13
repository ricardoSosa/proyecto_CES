<?php

  require 'ManejadorAltasInventario.php';
  require 'ManejadorCambiosInventario.php';
  require 'ManejadorBajasInventario.php';

  class AsignadorTareas {

    private $tarea;
    private $datosTarea;

    public __construct( $tarea, $datosTarea ) {
      $this->tarea = $tarea;
      $this->datosTarea = $datosTarea;
    }

    public function asignarTarea() {
      switch ( $this->$tarea ) {
        case 'añadir':
          $manejadorTarea = new ManejadorAltasInventario();
          $manejadorTarea->entenderTipoAlta( $this->$datosTarea );
        break;

        case 'modificar':
          $manejadorTarea = new ManejadorCambiosInventario();
          $manejadorTarea->entenderTipoCambio( $this->$datosTarea );
        break;

        case 'eliminar':
          $manejadorTarea = new ManejadorBajasInventario();
          $manejadorTarea->entenderTipoBaja( $this->$datosTarea );
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
