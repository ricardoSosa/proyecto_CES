<?php

  class Manejador_base_datos {

    const BASE_DATOS = 'mysql:host=localhost; dbname=proyecto_ces';
    const USUARIO = 'root';
    const CONTRASEÑA = '';
    private $conexion;

    //Método constructor.

    function __construct() {
      $this->realizar_conexion();
      $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //Método que realiza la conexión con la base de datos.

    private function realizar_conexion() {

      $this->conexion = new PDO( self::BASE_DATOS, self::USUARIO, self::CONTRASEÑA );

      //Consulta de manejo del utf8, para admitir símbolos extraños.

      $consulta_utf8 = "SET CHARACTER SET utf8";
      $this->conexion->exec( $consulta_utf8 );

    }

    /*Método que inserta elementos nuevos a las tablas de la base de datos según
    el tipo de inserción.*/

    public function insertar( $nombre_tabla, $datos ) {
      $consulta = $this->obtener_consulta_insercion( $nombre_tabla, $datos );
        echo $consulta;
        $this->conexion->query( $consulta );
    }

    //Método que modifica información de las tablas de la base de datos.

    public function modificar( $nombre_tabla, $datos ) {
      $atrib_modificar = $datos['atrib_modificar'];
      $consulta = "UPDATE $nombre_tabla SET $atrib_modificar = :dato_nuevo WHERE
        id = :id";
      $datos_elemento = array(
        ':dato_nuevo' => $datos[ 'dato_nuevo' ],
        ':id' => $datos[ 'id' ] );

      //Se ejecuta la modificación.

      $resultado = $this->conexion->prepare( $consulta );
      $resultado->execute( $datos_elemento );
    }

    //Método que elimina elementos de las tablas de la base de datos.

    public function eliminar( $nombre_tabla, $id ) {
      $consulta = "DELETE FROM $nombre_tabla WHERE id = :id";
      $datos_elemento = array( 'id' => $id );

      $resultado = $this->conexion->prepare( $consulta );
      $resultado->execute( $datos_elemento );
    }

    //Método que consulta información de las tablas de la base de datos.

    public function realizar_consulta( $nombre_tabla, $datos ) {
      switch( $datos[ 'tipo_consulta' ] ) {
        case 'lista':
          $consulta = "SELECT * FROM $nombre_tabla";
          break;

        case 'especifico':
          $id = $datos[ 'id' ];
          $consulta = "SELECT * FROM $nombre_tabla WHERE id = '$id'";
          break;
      }

      //Se realiza la consulta y se guarda el resultado.

      $resultado = $this->conexion->query( $consulta );
      $datos_obtenidos = $resultado->fetch( PDO::FETCH_ASSOC );
      return $datos_obtenidos;
    }

    private function obtener_columnas( $nombre_tabla ) {
      $consulta_atributos = "DESCRIBE $nombre_tabla;";
      $columnas = $this->conexion->query( $consulta_atributos );
      return $columnas;
    }

    private function obtener_consulta_insercion( $nombre_tabla, $datos ) {
      $cadena = '';
      $cadena_atributos = '';
      $cadena_valores = '';

      $columnas = $this->obtener_columnas($nombre_tabla);
      $indice = 0;
      while( $columnas_provisional = $columnas->fetch( PDO::FETCH_ASSOC ) ) {
        $nombre_columnas[$indice] = $columnas_provisional[ 'Field' ];
        $indice++;
      } //while
      $columnas->closeCursor();

      foreach( $nombre_columnas as $key=>$atributo ) {
        if( $key == 0 ) {
          $cadena_atributos = '( ' . $atributo;
          $cadena_valores = '( ' . '"' . $datos[$atributo] . '"';
        } else {
          $cadena_atributos = $cadena_atributos . ', ' . $atributo;
          $cadena_valores = $cadena_valores . ', ' . '"' . $datos[$atributo] . '"';
        }
      } //foreach
      $cadena_atributos = $cadena_atributos . ' )';
      $cadena_valores = $cadena_valores . ' )';

      $consulta = "INSERT INTO $nombre_tabla $cadena_atributos VALUES $cadena_valores";

      return $consulta;
    }

  }

?>
