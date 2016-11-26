<?php

  class Generador_consultas {

    function __construct() {
    }

    private function obtener_consulta_insercion( $nombre_tabla, $datos ) {
      $columnas = $this->obtener_columnas( $nombre_tabla );
      $nombres_columnas = $this->obtener_nombres_columnas( $columnas );

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

    private function obtener_consulta_modificacion( $nombre_tabla, $datos ) {
      $columnas = $this->obtener_columnas( $nombre_tabla );
      $nombres_columnas = $this->obtener_nombres_columnas( $columnas );

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

      $consulta = "UPDATE $nombre_tabla SET $cadena_modificacion WHERE $nombre_id = $valor_id";

      return $consulta;
    }

    private function obtener_consulta_eliminacion( $nombre_tabla, $nombre_id, $valor_id ) {
      $consulta = "DELETE FROM $nombre_tabla WHERE $nombre_id = $valor_id";

      return $consulta;
    }

    private function obtener_consulta_informacion( $nombre_tabla, $datos ){
      $cadena_atributos = '';
      foreach( $datos as $llave=>$atributo ) {
        if( $llave == 'tipo_consulta' || $llave == 'nombre_id' || $llave == 'valor_id'){
          continue;
        } else if( $cadena_atributos == '' ){
          $cadena_atributos = "$atributo";
        } else {
          $cadena_atributos = $cadena_atributos . ", $atributo";
        }
      } //foreach

      switch( $datos[ 'tipo_consulta' ] ){
        case 'lista':
          $consulta = "SELECT $cadena_atributos FROM $nombre_tabla";
          break;
        case 'elemento':
          $nombre_id = $datos[ 'nombre_id' ];
          $valor_id = $datos[ 'valor_id' ];
          $consulta = "SELECT $cadena_atributos FROM $nombre_tabla WHERE
            $nombre_id = $valor_id";
          break;
      }

      return $consulta;
    }

    private function obtener_columnas( $nombre_tabla ) {
      $consulta_atributos = "DESCRIBE $nombre_tabla;";
      $columnas = $this->conexion->query( $consulta_atributos );

      return $columnas;
    }

    private function obtener_nombres_columnas( $columnas ) {
      $indice = 0;

      while( $columnas_provisional = $columnas->fetch( PDO::FETCH_ASSOC ) ) {
        $nombres_columnas[ $indice ] = $columnas_provisional[ 'Field' ];
        $indice++;
      }
      $columnas->closeCursor();

      return $nombres_columnas;
    }
  }

?>
