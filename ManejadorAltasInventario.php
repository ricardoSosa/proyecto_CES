<?php

require 'AdministradorComponentes.php';
require 'AdministradorEquipos.php';
require 'AdministradorProcesos.php';

class ManejadorAltasInventario {

  private $administradorAlta;

  public __construct() {

  }

  public function entenderTipoAlta( $tipoAlta, $datosAlta ) {
    switch ( $tipoAlta ) {
      case 'componente':
        $this->administradorAlta = new AdministradorComponentes();
        $this->notificarAltaAdministrador( $datosAlta );
      break;

      case 'equipo':
        $this->administradorAlta = new AdministradorEquipos();
        $this->notificarAltaAdministrador( $datosAlta );
      break;

      case 'proceso':
        $this->administradorAlta = new AdministradorProcesos();
        $this->notificarAltaAdministrador( $datosAlta );
      break;

      default:
        # code...
      break;
    }
  }

  private function notificarAltaAdministrador( $datosElemento ) {
    $this->administradorAlta->añadir( $datosElementos );
  }
}



 ?>
