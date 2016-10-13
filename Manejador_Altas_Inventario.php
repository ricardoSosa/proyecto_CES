<?php

require ( 'Administrador_Componentes.php' );
require ( 'Administrador_Equipos.php' );
require ( 'Administrador_Procesos.php' );

class Manejador_Altas_Inventario {

  private $administrador_alta;

  public __construct() {

  }

  public function entender_tipo_alta( $tipo_alta, $datos_alta ) {
    switch ( $tipo_alta ) {
      case 'componente':
        $this->administrador_alta = new Administrador_Componentes();
        $this->administrador_alta->añadir( $datos_alta );
      break;

      case 'equipo':
        $this->administrador_alta = new Administrador_Equipos();
        $this->administrador_alta->añadir( $datos_alta );
      break;

      case 'proceso':
        $this->administrador_alta = new Administrador_Procesos();
        $this->administrador_alta->añadir( $datos_alta );
      break;

      default:
        # code...
      break;
    }
  }
}



 ?>
