<?php

  class Manejador_base_datos{

    private $conexion;

    public function Manejador_base_datos(){

      $this->realizar_conexion();

    }

    public function realizar_conexion(){

      $base_datos = 'mysql:host=localhost; dbname=proyecto_ces';
      $usuario = 'root';
      $contraseña = '';
      $this->conexion = new PDO($base_datos, $usuario, $contraseña);
      $consulta_utf8 = "SET CHARACTER SET utf8";
      $this->conexion->exec($consulta_utf8);

    }

    public function insertar($datos){

      //Se evalúa si la inserción es de un proceso, equipo o componente.

      /*switch($datos['tipo_insercion']){

        case 'Proceso':
          $consulta = "INSERT INTO TABLA_PROCESO (id, nombre, descripcion)
            VALUES (
              $datos['id'],
              $datos['nombre'],
              $datos['descripcion'] )";
          break;

        case 'Equipo':
          $consulta = "INSERT INTO TABLA_EQUIPO (id, nombre, descripcion, ubicacion)
            VALUES (
              $datos['id'],
              $datos['nombre'],
              $datos['descripcion'],
              $datos['ubicacion'] )";
          break;

        case 'Componente':
          $consulta = "INSERT INTO TABLA_COMPONENTE (id, nombre, descripcion, tiempo_vida_max)
            VALUES (
              $datos['id'],
              $datos['nombre'],
              $datos['descripcion']
              $datos['tiempo_vida_max'] )";
          break;

      }*/

    }

    public function eliminar($datos){

    }

    public function modificar($datos){

    }

    public function realizar_consulta($datos){

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
            id = $datos[id]";
          break;

        case 'equipo_especifico':
          $consulta = "SELECT descripcion, ubicacion FROM equipos WHERE
            id = $datos[id]";
          break;

        case 'componente_especifico':
          $consulta = "SELECT descripcion, tiempo_vida_max FROM componentes WHERE
           id = $datos[id]";
          break;

      }

      //Se realiza la consulta y se guarda el resultado.

      $resultado = $this->conexion->query($consulta);

      return $resultado;

    }

  }

?>
