<?php

  class Componente {
    private $id;
    private $nombre;
    private $descripcion;
    private $tiempo_vida_max;
    private $tiempo_vida_actual;
    private $porcentaje_uso;

    function __construct( $datos_componente, $porcentaje_uso ) {
      $this->id = $datos_componente[ 'id' ];
      $this->nombre = $datos_componente[ 'nombre' ];
      $this->descripcion = $datos_componente[ 'descripcion' ];
      $this->tiempo_vida_max = $datos_componente[ 'tiempo_vida_max' ];
      $this->tiempo_vida_actual = $datos_componente[ 'tiempo_vida_actual' ];
      $this->porcentaje_uso = $porcentaje_uso;
    }

    public function obtener_id() {
      return $this->id;
    }

    public function obtener_nombre() {
      return $this->nombre;
    }

    public function obtener_descripcion() {
      return $this->descripcion;
    }

    public function obtener_tiempo_vida_max() {
      return $this->tiempo_vida_max;
    }

    public function obtener_tiempo_vida_actual() {
      return $this->tiempo_vida_actual;
    }

    public function obtener_porcentaje_uso() {
      return $this->porcentaje_uso;
    }

    public function modificar_tiempo_vida_actual($tiempo_vida){
      $this->tiempo_vida_actual = $tiempo_vida;
    }

  }

?>
