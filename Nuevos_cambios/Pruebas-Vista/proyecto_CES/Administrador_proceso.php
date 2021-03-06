<?php

  include_once "Administrador.php";

  class Administrador_proceso extends Administrador {

    function __construct() {
      parent::__construct();
    }

    public function agregar_equipo( $datos ) {
      $this->manejador_bd->insertar( 'porcentajes_equipos', $datos );
    }

    public function finalizar_proceso( $id_proceso ) {
      $datos = array(
        'atrib_modificar' => 'fecha_finalizacion',
        'dato_nuevo' => '',
        'id' => $id_proceso );

      $this->manejador_bd->modificar( 'historial_procesos', $datos );
    }

    public function generar_historial() {
      //$this->manejador_bd->realizar_consulta( 'historial_procesos',  );
    }

    public function iniciar_proceso( $id_proceso ) {
      $datos = array(
        'atrib_modificar' => 'fecha_inicio',
        'dato_nuevo' => '',
        'id' => $id_proceso );

      $this->manejador_bd->modificar( 'historial_procesos', $datos );
    }

    public function quitar_equipo( $id_equipo ) {
      $this->manejador_bd->eliminar( 'porcentajes_equipos', $id_equipo );
    }


  }

?>
