<?php

	include "Componente.php";
	include "Equipo.php";
	include "Proceso.php";

	include "Mecanico.php";

	// include "Administrador_proceso.php";
	// include "Administrador_equipo.php";

	class Simulador_procesos{

		private $procesos;

		private $procesos_simulados;

		private $administrador_proceso;
		
		private $administrador_equipo;

		function __construct(){
			echo "Simulador_procesos<br>";
			$this->creaar_procesos();
			//$this->procesos = $procesos;
			// $this->administrador_proceso = new Administrador_proceso();
			// $this->administrador_equipo = new Administrador_equipo();
		}

		private function creaar_procesos(){
			echo "creaar_procesos()<br>";

			for ($i=1; $i <= 3; $i++) { 

				$datos_componente = array(
				'id' => $i,
				'nombre' => 'compo'.$i,
				'descripcion' => 'compo'.$i.'d',
				'tiempo_vida_max' => '130',
				'tiempo_vida_actual' => '0',
				'porcentaje_uso' => '10' );

				$componente = new Componente($datos_componente);
					
				$componentes[] = $componente; // aqui ya tenemos los componentes creados

			}

			$datos_equipo = array(
				'id' => '1',
				'nombre' => 'equipo1',
				'descripcion' => 'equipo1d',
				'ubicacion' => 'en la bodega',
				'componentes' => $componentes,
				'porcentaje_uso' => '7' 
				);

			$equipo = new Equipo($datos_equipo);

			$equipos[] = $equipo;

			$datos_equipo = array(
				'id' => '2',
				'nombre' => 'equipo2',
				'descripcion' => 'equipo2d',
				'ubicacion' => 'en la bodega2',
				'componentes' => $componentes,
				'porcentaje_uso' => '72' );

			$equipo = new Equipo($datos_equipo);

			$equipos[] = $equipo;

			$datos_proceso = array(
				'id' => '1',
				'nombre' => 'proceso1',
				'descripcion' => 'proceso1d',
				'equipos' => $equipos,
				'duracion_estimada' => '120' );

			$proceso = new Proceso($datos_proceso);

			$procesos[] = $proceso;

			$this->iniciar_simulacion($procesos);

		}

		public function iniciar_simulacion($procesos){

			echo "iniciar_simulacion()<br>";

			foreach ($procesos as $proceso) {// por cada proceso

				$this->simular_proceso($proceso);

				$id_proceso = $proceso->obtener_id();

				// $procesos_simulados[] = array('id_proceso' => $id_proceso, 'equipos_despues_proceso' => $equipos_despues_proceso);
			}

		}

		private function simular_proceso($proceso){

			echo "simular_proceso()<br>";

			$duracion_proceso = $proceso->obtener_duracion_estimada();

			$equipos = $proceso->obtener_equipos();

			foreach ($equipos as $equipo) {

				$this->activar_equipo( $equipo, $duracion_proceso );

				//reiniciar el array de componentes_despues_proceso

				$id_equipo = $equipo->obtener_id();

				// $equipos_despues_proceso[] = array('id_equipo' => $id_equipo, 'componentes_usados'  => $componentes_despues_proceso);

			}

		}

		private function activar_equipo($equipo, $duracion_proceso){

			echo "activar_equipo()<br>";

			$porcentaje_uso_equipo = $equipo->obtener_porcentaje_uso();

			print('porcentaje del equipo: '.$porcentaje_uso_equipo.'<br>');

			$tiempo_uso_equipo = $porcentaje_uso_equipo * $duracion_proceso;

			print('tiempo uso equipo: '.$tiempo_uso_equipo.'<br>');

			$componentes = $equipo->obtener_componentes();

			$componentes_despues_proceso;

			foreach ($componentes as $componente) {

				print('componente antes de entrar al mecánico: '.$componente->obtener_tiempo_vida_actual().'<br>');

				$mecanico = new Mecanico();

				$mecanico->calcular_desgaste($componente , $tiempo_uso_equipo);

				// $this->calcular_desgaste($componente, $tiempo_uso_equipo);

				print('componente despues de entrar al mecánico'.$componente->obtener_tiempo_vida_actual().'<br>');
					
			}

		}

		// private function calcular_desgaste($componente, $tiempo_uso_equipo){

		// 	echo "calcular_desgaste()<br>";

		// 	$porcentaje_uso_componente = $componente->obtener_porcentaje_uso();

		// 	print('procentaje uso componente: '.$porcentaje_uso_componente.'<br>');

		// 	$tiempo_usado = $porcentaje_uso_componente * $tiempo_uso_equipo;

		// 	// $id_componente = $componente->obtener_id();

		// 	// $nombre_componente = $componente->obtener_nombre();

		// 	// $descripcion_componente = $componente->obtener_descripcion();

		// 	// $tiempo_vida_max = $componente->obtener_tiempo_vida_max();

		// 	$tiempo_vida_actual = $componente->obtener_tiempo_vida_actual();
 
		// 	$tiempo_vida_actual = $tiempo_vida_actual + $tiempo_usado;

		// 	print('id: '.$componente->obtener_id().' -> '.$componente->obtener_tiempo_vida_actual().'<br>');

		// 	$componente->modificar_tiempo_vida_actual($tiempo_vida_actual);

		// 	print('id: '.$componente->obtener_id().' -> '.$componente->obtener_tiempo_vida_actual().'<br>');

		// 	// $datos_componente = array('id' => $id_componente ,
		// 	//                         'nombre' => $nombre_componente,
		// 	//                         'descripcion' => $descripcion_componente,
		// 	//                         'tiempo_vida_max' => $tiempo_vida_max,
		// 	//                         'tiempo_vida_actual' => $tiempo_vida_actual,
		// 	//                         'porcentaje_uso' => $porcentaje_uso_componente);

		// 	// $componente_usado = new Componente($datos_componente);

		// 	// $componentes_despues_proceso[] = $componente_usado;

		// }

	}

	$obj = new Simulador_procesos();

?>
