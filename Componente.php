<?php

  class Componente {

    private $id;
    private $nombre;
    private $descripcion;
    private $tiempo_vida_max;
    private $tiempo_vida_actual;
    private $porcentaje_uso;

    public function Componente() {

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

  }

?>
