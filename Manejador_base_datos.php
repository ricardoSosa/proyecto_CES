<?php

  include_once( "Generado_consultas.php" );

  class Conector_base_datos {
    const BASE_DATOS = 'mysql:host=localhost; dbname=proyecto_ces';
    const USUARIO = 'root';
    const CONTRASEÑA = '';
    private $conexion;
    private $generador_consultas;

    //Método constructor.
    function __construct() {
      $this->realizar_conexion();

      //Consulta de manejo del utf8, para admitir símbolos extraños.
      $consulta_utf8 = "SET CHARACTER SET utf8";
      $this->conexion->exec( $consulta_utf8 );

      $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $generador_consultas = new Generador_consultas();
    }

    //Método que realiza la conexión con la base de datos.
    private function realizar_conexion() {
      try {
        $this->conexion = new PDO( self::BASE_DATOS, self::USUARIO, self::CONTRASEÑA );
        echo 'Conectado a la base de datos.';
      } catch ( Exception $e) {
        //die( 'Error: ' . $e->getMessage());
      }
    }

    /*Método que inserta elementos nuevos a las tablas de la base de datos según
    el tipo de inserción.*/
    public function insertar( $nombre_tabla, $datos ) {
      $consulta = $this->generador_consultas->obtener_consulta_insercion( $nombre_tabla, $datos );
      echo $consulta;
      $this->conexion->query( $consulta );
    }

    //Método que modifica información de las tablas de la base de datos.
    public function modificar( $nombre_tabla, $datos ) {
      $consulta = $this->generador_consultas->obtener_consulta_modificacion( $nombre_tabla, $datos );
      $this->conexion->query( $consulta );
    }

    //Método que elimina elementos de las tablas de la base de datos.
    public function eliminar( $nombre_tabla, $nombre_id, $valor_id ) {
      $consulta = $this->generador_consultas->obtener_consulta_eliminacion( $nombre_tabla, $nombre_id, $valor_id )
      $this->conexion->query( $consulta );
    }

    //Método que consulta información de las tablas de la base de datos.
    public function obtener_informacion( $nombre_tabla, $datos ) {
      $consulta = $this->generador_consultas->obtener_consulta_informacion( $nombre_tabla, $datos );
      //Se realiza la consulta y se guarda el resultado.
      $resultado = $this->conexion->query( $consulta );
      $datos_obtenidos = $resultado->fetchAll();
      print_r ($datos_obtenidos); //BORRAR DESPUES
      //return $datos_obtenidos;
    }

  }
?>
