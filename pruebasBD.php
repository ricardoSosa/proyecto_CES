<?php

require "Manejador_bd.php";

$base_datos = new Manejador_base_datos();

$datos_prueba = array( 'tipo_insercion' => 'Componente' ,
                        'id' => 'comp01' ,
                        'nombre' => 'componente1' ,
                        'descripcion' => 'Descripcion del componente de prueba 01' ,
                        'tiempo_vida_max' => '50hrs' );

$base_datos->insertar( 'componentes', $datos_prueba );

$datos = array( 'elemento_consulta' => 'lista' );

$consulta = $base_datos->realizar_consulta( 'componentes', $datos );

echo $consulta;

 ?>
