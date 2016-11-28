<?php

  class Generador_consultas {

    function __construct() {
    }

    public function obtener_consulta_insercion( $nombre_tabla, $datos, $nombres_columnas ) {
      $cadena_atributos = '';
      $cadena_valores = '';

      foreach( $nombres_columnas as $atributo ) {
        if( $cadena_atributos == '' ) {
          $cadena_atributos = "( $atributo";
          $cadena_valores = '( "' . $datos[$atributo] . '"';
        } else {
          $cadena_atributos = $cadena_atributos . ', ' . $atributo;
          $cadena_valores = $cadena_valores . ', "' . $datos[$atributo] . '"';
        }
      } //foreach

      $cadena_atributos = "$cadena_atributos )";
      $cadena_valores = "$cadena_valores )";

      $consulta = "INSERT INTO $nombre_tabla $cadena_atributos VALUES $cadena_valores";

      return $consulta;
    }

    public function obtener_consulta_modificacion( $nombre_tabla, $datos, $nombres_columnas ) {
      $cadena_modificacion = '';
      $nombre_id = '';
      $valor_id = '';

      foreach( $nombres_columnas as $atributo ) {
        if( $cadena_modificacion == '' ) {
          $cadena_modificacion = "$atributo = " . $datos[ $atributo ];
          $nombre_id = $atributo;
          $valor_id = $datos[ $atributo ];
        } else {
          $cadena_modificacion = ", $cadena_modificacion, $atributo = " . $datos[ $atributo ];
        }
      } //foreach

      $consulta = "UPDATE $nombre_tabla SET $cadena_modificacion WHERE $nombre_id = '$valor_id'";
      echo $consulta;
      //return $consulta;
    }

    public function obtener_consulta_eliminacion( $nombre_tabla, $nombre_id, $valor_id ) {
      $consulta = "DELETE FROM $nombre_tabla WHERE $nombre_id = '$valor_id'";

      return $consulta;
    }

    public function obtener_consulta_informacion( $nombre_tabla, $datos ){
      $consulta = '';

      switch( $datos[ 'tipo_consulta' ] ){
        case 'lista':
          $consulta = "SELECT * FROM $nombre_tabla";
          break;
        case 'elemento':
          $id = $datos[ 'id' ];
          $consulta = "SELECT * FROM $nombre_tabla WHERE id = '$id'";
          break;
      }

      return $consulta;
    }

    public function obtener_consulta_columnas( $nombre_tabla ) { //PROVICIONAL
      $consulta = "DESCRIBE $nombre_tabla;";

      return $consulta;
    }

  }

?>
