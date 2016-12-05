<?php

  class Generador_consultas {

    function __construct() {
    }

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

    public function obtener_consulta_eliminacion( $nombre_tabla, $ids ) {
      $cadena_id = $this->obtener_cadena_id( $ids, count( $ids ) );

      $consulta = "DELETE FROM $nombre_tabla WHERE $cadena_id";

      return $consulta;
    }

    public function obtener_consulta_lista( $nombre_tabla ) {
      $consulta = "SELECT * FROM $nombre_tabla";

      return $consulta;
    }

    public function obtener_consulta_especifica( $nombre_tabla, $ids ) {
      $cadena_id = $this->obtener_cadena_id( $ids, count( $ids ) );

      $consulta = "SELECT * FROM $nombre_tabla WHERE $cadena_id";

      return $consulta;
    }

    private function obtener_cadena_id( $datos, $num_ids ) {
      $cadena_id = '';
      $contador = 0;
      // print_r($datos);
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
