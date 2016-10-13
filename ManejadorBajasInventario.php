<?php

require 'AdministradorComponentes.php';
require 'AdministradorEquipos.php';
require 'AdministradorProcesos.php';

class ManejadorBajasInventario {

  $administradorBajas;

  public __construct() {

  }

  public function entenderTipoBaja( $tipoBaja, $elementoAEliminar ) {
    switch ( $tipoBaja ) {
      case 'componente':
        $this->$administradorBajas = new AdministradorComponentes();
        $this->notificarBajaAdministrador( $elementoAEliminar );
      break;

      case 'equipos':
        $this->$administradorBajas = new AdministradorEquipos();
        $this->notificarBajaAdministrador( $elementoAEliminar );
      break;

      case 'proceso':
        $this->$administradorBajas = new AdministradorProcesos();
        $this->notificarBajaAdministrador( $elementoAEliminar );
      break;

      default:
        # code...
        break;
    }
  }

  private function notificarBajaAdministrador( $elementoAEliminar ) {
    $this->$administradorBajas->eliminar( $elementoAEliminar );
  }

}


 ?>
