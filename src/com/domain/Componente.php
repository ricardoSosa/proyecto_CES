<?php

  //Clase que representa un componente.
  class Componente {
    private $id;
    private $nombre;
    private $descripcion;
    private $tiempo_vida_max;
    private $tiempo_vida_actual;
    private $porcentaje_uso;

    /*
     *Construct
     */
    function __construct( $datos_componente, $porcentaje_uso ) {
      $this->id = $datos_componente[ 'id' ];
      $this->nombre = $datos_componente[ 'nombre' ];
      $this->descripcion = $datos_componente[ 'descripcion' ];
      $this->tiempo_vida_max = $datos_componente[ 'tiempo_vida_max' ];
      $this->tiempo_vida_actual = $datos_componente[ 'tiempo_vida_actual' ];
      $this->porcentaje_uso = $porcentaje_uso;
    }

    /*
     *@return String $id - Retorna el id del componente.
    */
    public function obtener_id() {
      return $this->id;
    }

    /*
     *@return String $nombre - Retorna el nombre del componente.
    */
    public function obtener_nombre() {
      return $this->nombre;
    }

    /*
     *@return String $descripcion - Retorna la descripcion del componente.
    */
    public function obtener_descripcion() {
      return $this->descripcion;
    }

    /*
     *@return Double $tiempo_vida_max - Retorna el tiempo de vida máximo del
     *componente.
    */
    public function obtener_tiempo_vida_max() {
      return $this->tiempo_vida_max;
    }

    /*
     *@return Double $tiempo_vida_actual - Retorna el tiempo de vida actual del
     *componente.
    */
    public function obtener_tiempo_vida_actual() {
      return $this->tiempo_vida_actual;
    }

    /*
     *@return Double $porcentaje_uso - Retorna el porcentaje de uso del
     *componente.
    */
    public function obtener_porcentaje_uso() {
      return $this->porcentaje_uso;
    }

    /*
     *@param Double $tiempo_vida - Modifica el tiempo de vida actual del
     *componente.
    */
    public function modificar_tiempo_vida_actual( $tiempo_vida ){
      $this->tiempo_vida_actual = $tiempo_vida;
    }

  }

?>
