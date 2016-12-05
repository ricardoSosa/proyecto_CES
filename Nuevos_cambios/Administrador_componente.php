<?php

  include_once "Administrador.php";

  /*Clase administradora de los datos de los componentes de la empresa*/
  class Administrador_componente extends Administrador {

    /*
     *Construct
     */
    function __construct() {
      parent::__construct( 'componentes' );
    }

  }

?>
