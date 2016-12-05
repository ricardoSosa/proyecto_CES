<?php

	include_once "Componente.php";
	include_once "Equipo.php";
	include_once "Proceso.php";

	include_once "Mecanico.php";

	//include_once "Administrador_proceso.php";
	// include "Administrador_equipo.php";

	class Simulador_procesos{

		// private $id_procesos;
		// private $procesos;

		//rivate $administrador_proceso;
//
// $id_procesos
		function __construct(){
			// $this->id_procesos = $id_procesos;
			// $this->crear_procesos();
		}



		public function iniciar_simulacion($procesos){

			$componentes_equipo = [];

			$equipos_proceso = [];

			$procesos_simulados = [];


			// print_r($procesos);

			foreach ($procesos as $proceso) {

				$this->obtener_equipos_proceso($proceso);

				//--------------------------<
				$equipos_proceso1 = $proceso->obtener_equipos();

				foreach ($equipos_proceso1 as $equipo) {

					$componentes = $equipo->obtener_componentes();

					foreach ($componentes as $componente) {
						
						$datos_componente = array(
							'id_compo' => $componente->obtener_id(),
							'nombre_compo' => $componente->obtener_nombre(),
							'descripcion_compo' => $componente->obtener_descripcion(),
							'tiempo_vida_max_compo' => $componente->obtener_tiempo_vida_max(),
							'tiempo_vida_actual_compo' => $componente->obtener_tiempo_vida_actual(),
							'porcentaje_uso_compo' => $componente->obtener_porcentaje_uso()
							 );

						$componentes_equipo[] = $datos_componente;
					}

					$datos_equipo = array(  
						'id_equipo' => $equipo->obtener_id(),
						'nombre_equipo' => $equipo->obtener_nombre(),
						'descripcion_equipo' => $equipo->obtener_descripcion(),
						'ubicacion_equipo' => $equipo->obtener_ubicacion(),
						'componentes_equipo' => $componentes_equipo
						 );

					$equipos_proceso[] = $datos_equipo;

				}

				$datos_proceso = array(
					'id_proceso' => $proceso->obtener_id(),
					'nombre_proceso' => $proceso->obtener_nombre(),
					'descripcion_proceso' => $proceso->obtener_descripcion(),
					'equipos_proceso' => $equipos_proceso,
					'duracion_proceso' => $proceso->obtener_duracion_estimada()
					 );

				$procesos_simulados[] = $datos_proceso;

				$componentes_equipo = null;

				$equipos_proceso = null;

			}

			print_r(json_encode($procesos_simulados));
			

		}

		private function obtener_equipos_proceso($proceso){

			$duracion_proceso = $proceso->obtener_duracion_estimada();

			$equipos = $proceso->obtener_equipos();

			foreach ($equipos as $equipo) {

				$this->activar_equipo( $equipo, $duracion_proceso );

				$id_equipo = $equipo->obtener_id();

			}

		}

		private function activar_equipo($equipo, $duracion_proceso){

			$porcentaje_uso_equipo = $equipo->obtener_porcentaje_uso();

			$tiempo_uso_equipo = $porcentaje_uso_equipo * $duracion_proceso;

			$componentes = $equipo->obtener_componentes();

			$componentes_despues_proceso;

			foreach ($componentes as $componente) {

				$mecanico = new Mecanico();

				$mecanico->calcular_desgaste($componente , $tiempo_uso_equipo);

			}

		}

	}

	// $obj = new Simulador_procesos();

?>
