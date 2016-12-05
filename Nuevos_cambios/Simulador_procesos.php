<?php

	include_once "Componente.php";
	include_once "Equipo.php";
	include_once "Proceso.php";

	include_once "Calculador_desgaste.php";

	class Simulador_procesos{

		/*
	     *Construct
	     */
		function __construct(){
		}

		/*Método que iniica da inicio a la simulacion */
		public function iniciar_simulacion($procesos){

			$this->separar_por_procesos($procesos);

		}

		/* Método que separa los process que le pidieron simular */
		private function separar_por_procesos($procesos){

			foreach ($procesos as $proceso) {

				$this->obtener_equipos_proceso($proceso);

			}

			$this->preparar_resultado( $procesos );

		}

		/* Método que obtiene los equipos de cada proceso */
		private function obtener_equipos_proceso( $proceso ) {

			$duracion_proceso = $proceso->obtener_duracion_estimada();

			$equipos = $proceso->obtener_equipos();

			foreach ($equipos as $equipo) {

				$this->obtener_componentes_equipo( $equipo, $duracion_proceso );

				$id_equipo = $equipo->obtener_id();

			}

		}

		/* Método que obtiene los componentes de cada proceso */
		private function obtener_componentes_equipo( $equipo, $duracion_proceso ) {

			$porcentaje_uso_equipo = $equipo->obtener_porcentaje_uso();

			$tiempo_uso_equipo = $porcentaje_uso_equipo * $duracion_proceso;

			$componentes = $equipo->obtener_componentes();

			foreach ($componentes as $componente) {

				$mecanico = new Calculador_desgaste();

				$mecanico->calcular_desgaste( $componente , $tiempo_uso_equipo );

			}

		}
		
		/* Método que prepara la informacion para ser enviada a la vista */
		private function preparar_resultado($procesos){

			$componentes_equipo = [];

			$equipos_proceso = [];

			$procesos_simulados = [];

			foreach ($procesos as $proceso) {

				$this->obtener_equipos_proceso($proceso);

				$equipos_proceso_simular = $proceso->obtener_equipos();

				foreach ($equipos_proceso_simular as $equipo) {

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

			$this->enviar_resultado($procesos_simulados);

		}

		private function enviar_resultado($procesos_simulados){

			print_r(json_encode($procesos_simulados));

		}

	}


?>
