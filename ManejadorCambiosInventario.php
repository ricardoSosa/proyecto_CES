<?php

require 'AdministradorComponentes.php';
require 'AdministradorEquipos.php';
require 'AdministradorProcesos.php';

class ManejadorCambiosInventario {

  private $administradorCambios;

  public __construct() {

  }

  public function entenderTipoCambio( $tipoCambio, $datosACambiar ) {
    switch ( $tipoCambio ) {
      case 'componente':
        $this->$administradorCambios = new AdministradorComponentes();
        $this->notificarCambiosAdministrador( $datosACambiar );
      break;

      case 'equipo':
        $this->$administradorCambios = new AdministradorEquipos();
        $this->notificarCambiosAdministrador( $datosACambiar );
      break;

      case 'proceso':
        $this->$administradorCambios = new AdministradorProcesos();
        $this->notificarCambiosAdministrador( $datosACambiar );
      break;

      default:
        # code...
        break;
    }
  }

  private function notificarCambiosAdministrador( $datosACambiar ) {
    $this->$administradorCambios->modificar( $datosACambiar );
  }
}


 ?>
