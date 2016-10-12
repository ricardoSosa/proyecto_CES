<?php

  public class Manejador_base_datos{

    private $conexion;

    public function Manejador_base_datos(){

      realizar_conexion();

    }

    public function realizar_conexion(){

      $base_datos = 'mysql:host = localhost; dbname = ';
      $usuario = 'root';
      $contraseña = '';
      $this->conexion = new PDO($base_datos, $usuario, $contraseña);
      $consulta_utf8 = "SET CHARACTER SET utf8";
      $this->conexion->exec($consulta_utf8);

    }

    public function insertar($datos){

      $consulta = "INSERT INTO :TABLA ()"

    }

    public function eliminar($datos){

    }

    public function modificar($datos){

    }

    public function realizar_consulta($datos){

      //Se prepara la consulta en la conexión.

      $consulta = "SELECT :ATRIBS FROM :TABLA WHERE :ATRIB_EVALUAR = :DATO_EVALUAR";
      $resultado = $this->conexion->prepare($consulta);

      //Se ejecuta la consulta.

      $arreglo_ejecucion = array(
        ":ATRIBS"=>$datos[atributos],
        ":TABLA"=>$datos[tabla],
        ":ATRIB_EVALUAR"=>$datos[atrib_evaluar],
        ":DATO_EVALUAR"=>$datos[dato_evaluar] );
      $resultado->execute($arreglo_ejecucion);

      return $resultado;

    }

  }

?>
