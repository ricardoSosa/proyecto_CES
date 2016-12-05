<?php

  include_once "Componente.php";

  //Clase que representa un equipo.
  class Equipo {
    private $id;
    private $nombre;
    private $descripcion;
    private $ubicacion;
    private $componentes;
    private $porcentaje_uso;

    /*
     *Construct
     */
    function __construct( $datos_equipo, $componentes, $porcentaje_uso ) {
        $this->id = $datos_equipo[ 'id' ];
        $this->nombre = $datos_equipo[ 'nombre' ];
        $this->descripcion = $datos_equipo[ 'descripcion' ];
        $this->ubicacion = $datos_equipo[ 'ubicacion' ];
        $this->componentes = $componentes;
        $this->porcentaje_uso = $porcentaje_uso;
    }

    /*
     *@return String $id - Retorna el id del equipo.
    */
    public function obtener_id() {
        return $this->id;
    }

    /*
     *@return String $nombre - Retorna el nombre del equipo.
    */
    public function obtener_nombre() {
        return $this->nombre;
    }

    /*
     *@return String $descripcion - Retorna la descripcion del equipo.
    */
    public function obtener_descripcion() {
        return $this->descripcion;
    }

    /*
     *@return String $ubicacion - Retorna la ubicacion del equipo.
    */
    public function obtener_ubicacion() {
        return $this->ubicacion;
    }

    /*
     *@return Componente[] $componentes - Retorna los componentes del equipo.
    */
    public function obtener_componentes() {
        return $this->componentes;
    }

    /*
     *@return Integer $porcentaje_uso - Retorna el porcentaje de uso del equipo.
    */
    public function obtener_porcentaje_uso() {
        return $this->porcentaje_uso;
    }

  }

?>
