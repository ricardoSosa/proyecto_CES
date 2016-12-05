<?php

  include_once "Generador_consultas.php";

  //Clase que maneja la conexión de información con la base de datos.
  class Conector_base_datos {
    const HOST_BD = 'mysql:host=localhost; dbname=proyecto_ces';
    const NOMBRE_BD = 'proyecto_ces';
    const USUARIO = 'root';
    const CONTRASEÑA = '';
    private $conexion;
    private $generador_consultas;

    /*
     *Construct
     */
    function __construct() {
      $this->realizar_conexion();
      $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      //Consulta de manejo del utf8, para admitir símbolos extraños.
      $consulta_utf8 = "SET CHARACTER SET utf8";
      $this->conexion->exec( $consulta_utf8 );

      $this->generador_consultas = new Generador_consultas();
    }

    /*Método que realiza la conexión con la base de datos.*/
    private function realizar_conexion() {
      $this->conexion = new PDO( self::HOST_BD, self::USUARIO, self::CONTRASEÑA );
    }

    /*Método que inserta elementos nuevos a las tablas de la base de datos según
     *el tipo de inserción.
     *@param String $nombre_tabla - Recibe el nombre de la tabla en la cual se
     *realizará la inserción
     *@param String[ASSOC] $datos - Recibe los datos de inserción con el
     *atributo como llave.
    */
    public function insertar( $nombre_tabla, $datos ) {
      $consulta = $this->generador_consultas->obtener_consulta_insercion( $nombre_tabla, $datos );
      $this->conexion->query( $consulta );
    }

    /*Método que modifica información de las tablas de la base de datos.
     *@param String $nombre_tabla - Recibe el nombre de la tabla en la cual se
     *realizará la inserción
     *@param String[ASSOC] $datos - Recibe los datos de modificación con el
     *atributo como llave.
     *@param Integer $num_ids - Recibe el número de identificadores que se
     *tomarán del arreglo de $datos.
    */
    public function modificar( $nombre_tabla, $datos, $num_ids ) {
      $consulta = $this->generador_consultas->obtener_consulta_modificacion( $nombre_tabla, $datos, $num_ids );
      $resultado = $this->conexion->query( $consulta );
    }

    /*Método que elimina elementos de las tablas de la base de datos.
     *@param String $nombre_tabla - Recibe el nombre de la tabla en la cual se
     *realizará la inserción
     *@param String[] $ids - Recibe los ids del elemento a eliminar.
    */
    public function eliminar( $nombre_tabla, $ids ) {
      $consulta = $this->generador_consultas->obtener_consulta_eliminacion( $nombre_tabla, $ids );
      $resultado = $this->conexion->query( $consulta );
    }

    /*Método que consulta información de las tablas de la base de datos.
     *@param String $nombre_tabla - Recibe el nombre de la tabla en la cual se
     *realizará la inserción.
     *@param String[] $ids - Recibe los ids del elemento a buscar. Si el valor
     *es null, se devuelve una lista de los datos del $nombre_tabla.
     *@param boolean $bandera_retorno_inmediato - Recibe una bandera que indica
     *si el resultado se mandará directo al cliente o se manejará dentro del
     *servidor.
    */
    public function obtener_informacion( $nombre_tabla, $ids, $bandera_retorno_inmediato ) {
      if( $ids == null ) {
        $consulta = $this->generador_consultas->obtener_consulta_lista( $nombre_tabla );
      } else {
        $consulta = $this->generador_consultas->obtener_consulta_especifica( $nombre_tabla, $ids );
      }

      $resultado = $this->conexion->query( $consulta );
      $datos_obtenidos = $resultado->fetchAll();

      if( $bandera_retorno_inmediato == true ){
        print_r (json_encode($datos_obtenidos));
      }

      return $datos_obtenidos;
    }

  }
?>
