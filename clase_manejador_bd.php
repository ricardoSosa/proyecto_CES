<?php

  class Manejador_base_datos{

    private $conexion;


    public function Manejador_base_datos(){

      $this->realizar_conexion();

    }


    public function realizar_conexion(){

      //Datos requeridos para la conexión.

      $base_datos = 'mysql:host = localhost; dbname = ';
      $usuario = 'root';
      $contraseña = '';

      //Conexión con la base de datos.

      $this->conexion = new PDO($base_datos, $usuario, $contraseña);

      //Consulta de manejo del utf8, para admitir símbolos extraños.

      $consulta_utf8 = "SET CHARACTER SET utf8";
      $this->conexion->exec($consulta_utf8);

    }


    public function insertar($datos){

      $consulta = null;
      $datos_elemento = null;

      //Se evalúa si la inserción es de un proceso, equipo o componente.

      switch($datos['tipo_elemento']){

        case 'Proceso':
          $consulta = "INSERT INTO procesos (id, nombre, descripcion)
            VALUES (:id, :nombre, :descripcion)";
          $datos_elemento = array(
            ':id' => $datos['id'],
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'] );
          break;

        case 'Equipo':
          $consulta = "INSERT INTO equipos (id, nombre, descripcion, ubicacion)
            VALUES (:id, :nombre, :descripcion, :ubicacion)";
          $datos_elemento = array(
            ':id' => $datos['id'],
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'],
            ':ubicacion' => $datos['ubicacion'] );
          break;

        case 'Componente':
          $consulta = "INSERT INTO componentes (id, nombre, descripcion, tiempo_vida_max)
            VALUES (:id, :nombre, :descripcion, :tiempo_vida_max)";
          $datos_elemento = array(
            ':id' => $datos['id'],
            ':nombre' => $datos['nombre'],
            ':descripcion' => $datos['descripcion'],
            ':tiempo_vida_max' => $datos['tiempo_vida_max'] );
          break;

      }

      //Se prepara la consulta y se realiza la inserción.

      $resultado = $this->conexion->prepare($consulta);
      $resultado->execute($datos_elemento);

    }


    public function eliminar($datos){

    }


    public function modificar($datos){

    }


    public function realizar_consulta($datos){

      $consulta = null;

      //Se selecciona la consulta de acuerdo a lo que requiera el usuario.

      switch($datos['tipo_consulta']){

        case 'lista_procesos':
          $consulta = "SELECT * FROM procesos";
          break;

        case 'lista_equipos':
          $consulta = "SELECT * FROM equipos";
          break;

        case 'lista_componentes':
          $consulta = "SELECT * FROM componentes";
          break;

        case 'proceso_especifico':
          $consulta = "SELECT descripcion, duracion FROM procesos WHERE
            id = " . $datos['id'] . ")";
          break;

        case 'equipo_especifico':
          $consulta = "SELECT descripcion, ubicacion FROM equipos WHERE
            id = " . $datos['id'] . ")";
          break;

        case 'componente_especifico':
          $consulta = "SELECT descripcion, tiempo_vida_max FROM componentes WHERE
           id = " . $datos['id'] . ")";
          break;

      }

      //Se realiza la consulta y se guarda el resultado.

      $resultado = $this->conexion->query($consulta);

      return $resultado;

    }

  }

?>
