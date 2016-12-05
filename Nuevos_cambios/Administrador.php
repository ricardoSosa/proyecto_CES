<?php

  include_once "Manejador_base_datos.php";

  /*Clase administradora de una base de datos general*/
  abstract class Administrador {
    const NUM_IDS_PRINCIPAL = 1;
    private $conector_bd;
    private $nombre_tabla_principal;

    /*
     *Construct
     *@param String $nombre_tabla - Recibe el nombre de la tabla donde se
     administra la información.
    */
    function __construct( $nombre_tabla ) {
      $this->conector_bd = new Conector_base_datos();
      $this->nombre_tabla_principal = $nombre_tabla;
    }

    /*
     *@param String[ASSOC] $datos - Recibe los datos del elemento a agregar.
    */
    public function agregar_nuevo( $datos ) {
      $this->conector_bd->insertar( $this->nombre_tabla_principal, $datos );
    }

    /*
     *@param String[ASSOC] $datos - Recibe los datos del elemento a modificar.
    */
    public function modificar( $datos ) {
      $this->conector_bd->modificar( $this->nombre_tabla_principal, $datos, self::NUM_IDS_PRINCIPAL );
    }

    /*
     *@param String[] $ids - Recibe los ids del elemento a eliminar.
    */
    public function eliminar( $ids ) {
      $this->conector_bd->eliminar( $this->nombre_tabla_principal, $ids );
    }

    /*
     *@param String[] $ids - Recibe los ids del elemento al cual se quiere
     *obtener sus datos.
     *@param boolean $bandera_retorno_inmediato - Si es true, se retorna el
     *resultado de forma directa mediante un jason, si es false, se retorna de
     *forma normal.
    */
    public function obtener_datos( $ids, $bandera_retorno_inmediato ) {
      $datos = $this->conector_bd->obtener_informacion( $this->nombre_tabla_principal, $ids, $bandera_retorno_inmediato );
      return $datos;
    }

  }
?>
