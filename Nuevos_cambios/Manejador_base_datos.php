<?php

  include_once "Generador_consultas.php";

  class Conector_base_datos {
    const BASE_DATOS = 'mysql:host=localhost; dbname=proyecto_ces';
    const USUARIO = 'root';
    const CONTRASEÑA = '';
    private $conexion;
    private $generador_consultas;

    //Método constructor.
    function __construct() {
      $this->realizar_conexion();

      $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $this->generador_consultas = new Generador_consultas();
    }

    //Método que realiza la conexión con la base de datos.
    private function realizar_conexion() {
      //Datos requeridos para la conexión.

      //Conexión con la base de datos.
      $this->conexion = new PDO( self::BASE_DATOS, self::USUARIO, self::CONTRASEÑA );
      //Consulta de manejo del utf8, para admitir símbolos extraños.
      $consulta_utf8 = "SET CHARACTER SET utf8";
      $this->conexion->exec( $consulta_utf8 );
    }

    /*Método que inserta elementos nuevos a las tablas de la base de datos según
    el tipo de inserción.*/
    public function insertar( $nombre_tabla, $datos ) {
      $columnas = $this->obtener_columnas( $nombre_tabla );
      $consulta = $this->generador_consultas->obtener_consulta_insercion( $nombre_tabla, $datos, $columnas );
      echo $consulta;
      $this->conexion->query( $consulta );
    }

    private function obtener_columnas( $nombre_tabla ) { //PROVICIONAL
      $consulta_atributos = "DESCRIBE $nombre_tabla;";
      $columnas = $this->conexion->query( $consulta_atributos );

      return $columnas;
    }

    //Método que modifica información de las tablas de la base de datos.
    public function modificar( $nombre_tabla, $datos ) {
      $columnas = $this->obtener_columnas( $nombre_tabla );
      $consulta = $this->generador_consultas->obtener_consulta_modificacion( $nombre_tabla, $datos, $columnas );

      $resultado = $this->conexion->prepare( $consulta );
      $resultado->execute();
    }

    //Método que elimina elementos de las tablas de la base de datos.
    public function eliminar( $nombre_tabla, $nombre_id, $valor_id ) {
      $consulta = $this->generador_consultas->obtener_consulta_eliminacion( $nombre_tabla, $nombre_id, $valor_id );
      $resultado = $this->conexion->prepare( $consulta );
      $resultado->execute ();
    }

    //Método que consulta información de las tablas de la base de datos.
    public function obtener_informacion( $nombre_tabla, $datos ) {
      $consulta = $this->generador_consultas->obtener_consulta_informacion( $nombre_tabla, $datos );
      //Se realiza la consulta y se guarda el resultado.
      $resultado = $this->conexion->prepare( $consulta );
      $resultado->execute();
      $datos_obtenidos = $resultado->fetchAll();
      print_r (json_encode($datos_obtenidos)); //BORRAR DESPUES
      //return $datos_obtenidos;
    }

  }
?>
