<?php

	class Mecanico{

		function __construct(){

		}

		public function calcular_desgaste($componente, $tiempo_uso_equipo){

			//echo "calcular_desgaste() en Mecanico<br>";

			$porcentaje_uso_componente = $componente->obtener_porcentaje_uso();

			//print('procentaje uso componente: '.$porcentaje_uso_componente.'<br>');

			$tiempo_usado = $porcentaje_uso_componente * $tiempo_uso_equipo;

			// $id_componente = $componente->obtener_id();

			// $nombre_componente = $componente->obtener_nombre();

			// $descripcion_componente = $componente->obtener_descripcion();

			// $tiempo_vida_max = $componente->obtener_tiempo_vida_max();

			$tiempo_vida_actual = $componente->obtener_tiempo_vida_actual();

			$tiempo_vida_actual = $tiempo_vida_actual + $tiempo_usado;

			// print('id: '.$componente->obtener_id().' -> '.$componente->obtener_tiempo_vida_actual().'<br>');

			$componente->modificar_tiempo_vida_actual($tiempo_vida_actual);

			// print('id: '.$componente->obtener_id().' -> '.$componente->obtener_tiempo_vida_actual().'<br>');

			// $datos_componente = array('id' => $id_componente ,
			//                         'nombre' => $nombre_componente,
			//                         'descripcion' => $descripcion_componente,
			//                         'tiempo_vida_max' => $tiempo_vida_max,
			//                         'tiempo_vida_actual' => $tiempo_vida_actual,
			//                         'porcentaje_uso' => $porcentaje_uso_componente);

			// $componente_usado = new Componente($datos_componente);

			// $componentes_despues_proceso[] = $componente_usado;

		}


	}



?>
