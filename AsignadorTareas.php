<?php

  require 'ManejadorAltasInventario.php';
  require 'ManejadorCambiosInventario.php';
  require 'ManejadorBajasInventario.php';

  public class AsignadorTareas {

    private $tarea;
    private $datosTarea;
    private $administradorTarea;

    public __construct( $tarea, $datosTarea ) {
      $this->tarea = $tarea;
      $this->datosTarea = $datosTarea;
    }

    public function asignarTarea() {
      switch ( $this->$tarea ) {
        case 'añadir':
          $this->$administradorTarea = new ManejadorAltasInventario();
          $this->$administradorTarea->entenderTipoAlta( $this->$datosTarea );
        break;

        case 'modificar':
          $this->$administradorTarea = new ManejadorCambiosInventario();
          $this->$administradorTarea->entenderTipoCambio( $this->$datosTarea );
        break;

        case 'eliminar':
          $this->$administradorTarea = new ManejadorBajasInventario();
          $this->$administradorTarea->entenderTipoBaja( $this->$datosTarea );
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
