<?php

  class Manejador_base_datos {

    private $conexion;


    function __construct() {

      $this->realizar_conexion();
      $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }


    private function realizar_conexion() {

      //Datos requeridos para la conexión.

      $base_datos = 'mysql:host=localhost; dbname=proyecto_ces';
      $usuario = 'root';
      $contraseña = '';

      //Conexión con la base de datos.

      $this->conexion = new PDO( $base_datos, $usuario, $contraseña );

      //Consulta de manejo del utf8, para admitir símbolos extraños.

      $consulta_utf8 = "SET CHARACTER SET utf8";
      $this->conexion->exec( $consulta_utf8 );

    }


    public function insertar( $nombre_tabla, $datos ) {

      $consulta = null;
      $datos_elemento = null;

      //Se evalúa qué tipo de elemento se quiere insertar.

        switch( $datos[ 'tipo_insercion' ] ) {

          case 'proceso':
            $consulta = "INSERT INTO
              procesos ( id, nombre, descripcion ) VALUES
              ( :id, :nombre, :descripcion )";
            $datos_elemento = array(
              ':id' => $datos[ 'id' ],
              ':nombre' => $datos[ 'nombre' ],
              ':descripcion' => $datos[ 'descripcion' ] );
            break;

          case 'equipo':
            $consulta = "INSERT INTO
              equipos ( id, nombre, descripcion, ubicacion ) VALUES
              ( :id, :nombre, :descripcion, :ubicacion )";
            $datos_elemento = array(
              ':id' => $datos[ 'id' ],
              ':nombre' => $datos[ 'nombre' ],
              ':descripcion' => $datos[ 'descripcion' ],
              ':ubicacion' => $datos[ 'ubicacion' ] );
            break;

          case 'componente':
            $consulta = "INSERT INTO
              componentes ( id, nombre, descripcion, tiempo_vida_max ) VALUES
              ( :id, :nombre, :descripcion, :tiempo_vida_max )";
            $datos_elemento = array(
              ':id' => $datos[ 'id' ],
              ':nombre' => $datos[ 'nombre' ],
              ':descripcion' => $datos[ 'descripcion' ],
              ':tiempo_vida_max' => $datos[ 'tiempo_vida_max' ] );
            break;

          case 'porcentaje_equipo':
            $consulta = "INSERT INTO
              porcentajes_equipos ( id_proceso, id_equipo, porcentaje_uso) VALUES
              ( :id_proceso, :id_equipo, :porcentaje_uso )";
            $datos_elemento = array(
              ':id_proceso' => $datos[ 'id_proceso' ],
              ':id_equipo' => $datos[ 'id_equipo' ],
              ':porcentaje_uso' => $datos[ 'porcentaje_uso' ] );
            break;

          case 'porcentaje_componente':
            $consulta = "INSERT INTO
              porcentajes_componentes ( id_equipo, id_comp, porcentaje_uso ) VALUES
              ( :id_equipo, :id_comp, :porcentaje_uso )";
            $datos_elemento = array(
              ':id_equipo' => $datos[ 'id_equipo' ],
              ':id_comp' => $datos[ 'id_comp' ],
              ':porcentaje_uso' => $datos[ 'porcentaje_uso' ] );
            break;

        }

      //Se prepara la consulta y se realiza la inserción.

      $resultado = $this->conexion->prepare( $consulta );
      $resultado->execute( $datos_elemento );

    }


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


    public function eliminar( $nombre_tabla, $id ) {

      $consulta = "DELETE FROM $nombre_tabla WHERE id = :id";
      $datos_elemento = array( 'id' => $id );

      $resultado = $this->conexion->prepare( $consulta );
      $resultado->execute( $datos_elemento );

    }


    public function realizar_consulta( $nombre_tabla, $datos ) {

      if( $datos[ 'elemento_consulta' ] == 'lista' ) {

        $consulta = "SELECT * FROM $nombre_tabla";

      } else if ( $datos[ 'elemento_consulta' ] == 'especifico' ) {

        $id = $datos[ 'id' ];
        $consulta = "SELECT * FROM $nombre_tabla WHERE id = '$id'";

      }

      //Se realiza la consulta y se guarda el resultado.
      $resultado = $this->conexion->query( $consulta );
      return $resultado;

    }

  }

?>
