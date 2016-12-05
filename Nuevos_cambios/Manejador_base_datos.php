<?php

  include_once "Generador_consultas.php";

  class Conector_base_datos {
    const HOST_BD = 'mysql:host=localhost; dbname=proyecto_ces';
    const NOMBRE_BD = 'proyecto_ces';
    const USUARIO = 'root';
    const CONTRASEÑA = '';
    private $conexion;
    private $generador_consultas;

    //Método constructor.
    function __construct() {
      $this->realizar_conexion();
      $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //Consulta de manejo del utf8, para admitir símbolos extraños.
      $consulta_utf8 = "SET CHARACTER SET utf8";
      $this->conexion->exec( $consulta_utf8 );

      $this->generador_consultas = new Generador_consultas();
    }

    //Método que realiza la conexión con la base de datos.
    private function realizar_conexion() {
      $this->conexion = new PDO( self::HOST_BD, self::USUARIO, self::CONTRASEÑA );
    }

    /*Método que inserta elementos nuevos a las tablas de la base de datos según
    el tipo de inserción.*/
    public function insertar( $nombre_tabla, $datos ) {
      $consulta = $this->generador_consultas->obtener_consulta_insercion( $nombre_tabla, $datos );
      $this->conexion->query( $consulta );
    }

    //Método que modifica información de las tablas de la base de datos.
    public function modificar( $nombre_tabla, $datos, $num_ids ) {
      $consulta = $this->generador_consultas->obtener_consulta_modificacion( $nombre_tabla, $datos, $num_ids );
      $resultado = $this->conexion->query( $consulta );
    }

    //Método que elimina elementos de las tablas de la base de datos.
    public function eliminar( $nombre_tabla, $ids ) {
      $consulta = $this->generador_consultas->obtener_consulta_eliminacion( $nombre_tabla, $ids );
      $resultado = $this->conexion->query( $consulta );
    }

    //Método que consulta información de las tablas de la base de datos.
    public function obtener_informacion( $nombre_tabla, $ids, $x ) {
      if( $ids == null ) {
        $consulta = $this->generador_consultas->obtener_consulta_lista( $nombre_tabla );
      } else {
        $consulta = $this->generador_consultas->obtener_consulta_especifica( $nombre_tabla, $ids );
      }

      $resultado = $this->conexion->query( $consulta );
      $datos_obtenidos = $resultado->fetchAll();

      if( $x == false ){
        print_r (json_encode($datos_obtenidos)); //BORRAR DESPUES
      }

      return $datos_obtenidos;
    }

  }
?>
