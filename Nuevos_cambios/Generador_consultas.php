<?php

  class Generador_consultas {

    /*
     *Construct
     */
    function __construct() {
    }

    /*Método que genera la consulta(query) para insertar un elemento.
     *@param String $nombre_tabla - Recibe el nombre de la tabla en la cual se
     *realizará la inserción
     *@param String[ASSOC] $datos - Recibe los datos de inserción con el
     *atributo como llave.
     *@return String $consulta - Retorna la cadena de la consulta(query).
    */
    public function obtener_consulta_insercion( $nombre_tabla, $datos ) {
      $cadena_atributos = '';
      $cadena_valores = '';

      foreach( $datos as $atributo=>$valor ) {
        if( $cadena_atributos == '' ) {
          $cadena_atributos = "( $atributo";
          $cadena_valores = "( '$valor'";
        } else {
          $cadena_atributos = "$cadena_atributos, $atributo";
          $cadena_valores = "$cadena_valores, '$valor'";
        }
      } //foreach

      $cadena_atributos = "$cadena_atributos )";
      $cadena_valores = "$cadena_valores )";

      $consulta = "INSERT INTO $nombre_tabla $cadena_atributos VALUES $cadena_valores";

      return $consulta;
    }

    /*Método que genera la consulta(query) para modificar un elemento.
     *@param String $nombre_tabla - Recibe el nombre de la tabla en la cual se
     *realizará la inserción
     *@param String[ASSOC] $datos - Recibe los datos de modificación con el
     *atributo como llave.
     *@param Integer $num_ids - Recibe el número de los identificadores que se
     *se toman de los datos de modificación.
     *@return String $consulta - Retorna la cadena de la consulta(query).
    */
    public function obtener_consulta_modificacion( $nombre_tabla, $datos, $num_ids ) {
      $cadena_modificacion = '';
      foreach( $datos as $atributo=>$valor ) {
        if( $cadena_modificacion == '' ) {
          $cadena_modificacion = "$atributo = '$valor'";
        } else {
          $cadena_modificacion = "$cadena_modificacion, $atributo = '$valor'";
        }
      } //foreach
      $cadena_id = $this->obtener_cadena_id( $datos, $num_ids );

      $consulta = "UPDATE $nombre_tabla SET $cadena_modificacion WHERE $cadena_id";

      return $consulta;
    }

    /*Método que genera la consulta(query) para eliminar un elemento.
     *@param String $nombre_tabla - Recibe el nombre de la tabla en la cual se
     *realizará la inserción
     *@param String[] $ids - Recibe los ids del elemento a eliminar.
     *@return String $consulta - Retorna la cadena de la consulta(query).
    */
    public function obtener_consulta_eliminacion( $nombre_tabla, $ids ) {
      $cadena_id = $this->obtener_cadena_id( $ids, count( $ids ) );

      $consulta = "DELETE FROM $nombre_tabla WHERE $cadena_id";

      return $consulta;
    }

    /*Método que genera la consulta(query) para consultar la lista completa de
    *una tabla.
     *@param String $nombre_tabla - Recibe el nombre de la tabla en la cual se
     *realizará la inserción
     *@return String $consulta - Retorna la cadena de la consulta(query).
    */
    public function obtener_consulta_lista( $nombre_tabla ) {
      $consulta = "SELECT * FROM $nombre_tabla";

      return $consulta;
    }

    /*Método que genera la consulta(query) para consultar la información de un
    *elemento específico en una tabla.
     *@param String $nombre_tabla - Recibe el nombre de la tabla en la cual se
     *realizará la inserción
     *@param String[] $ids - Recibe los ids del elemento a buscar.
     *@return String $consulta - Retorna la cadena de la consulta(query).
    */
    public function obtener_consulta_especifica( $nombre_tabla, $ids ) {
      $cadena_id = $this->obtener_cadena_id( $ids, count( $ids ) );

      $consulta = "SELECT * FROM $nombre_tabla WHERE $cadena_id";

      return $consulta;
    }

    /*Método que genera la cadena de evaluación de un "WHERE" para una consulta
     *a partir de los ids proporcionados.
     *@param String[ASSOC] $datos - Recibe los datos del elemento y el atributo
     *ce cada valor como su respectiva llave.
     *@param Integer $num_ids - Recibe el número de identificadores que se
     *tomarán del arreglo de $datos.
     *@return String $consulta - Retorna la cadena de la consulta(query).
    */
    private function obtener_cadena_id( $datos, $num_ids ) {
      $cadena_id = '';
      $contador = 0;
      foreach ( $datos as $atributo=>$valor ) {
        if( $contador < $num_ids ) {
          if( $cadena_id == '' ) {
            $cadena_id = "$atributo = '$valor'";
          } else {
            $cadena_id = "$cadena_id AND $atributo = '$valor'";
          } //if
          $contador++;
        } else {
          break;
        } //if
      } //foreach

      return $cadena_id;
    }

  }

?>
