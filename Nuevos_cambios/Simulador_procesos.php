<?php

	include "Componente.php";
	include "Equipo.php";
	include "Proceso.php";

	include "Mecanico.php";

	include_once "Administrador_proceso.php";
	// include "Administrador_equipo.php";

	class Simulador_procesos{

		// private $id_procesos;
		// private $procesos;

		private $administrador_proceso;

// $id_procesos
		function __construct(){
			// $this->id_procesos = $id_procesos;
			// $this->creaar_procesos();
		}

		public function pedir_procesos( $id_procesos_simular ){

			$this->administrador_proceso = new Administrador_proceso();

			foreach ($id_procesos_simular as $id_proceso) {

				$datos = array(
					'tipo_consulta' => 'elemento',
					'id' => $id_proceso
					 );

				$proceso = $this->administrador_proceso->leer_datos($datos);

				//ncontrar los componentes qu ele pertenecen 
				//a los equipos que participan en el proceso
				//a simular

				// $procesos[] = //añadir aqui los proceso que el aministrador va a crear

			}

			$this->iniciar_simulacion($procesos);

		}

		private function iniciar_simulacion($procesos){

			foreach ($procesos as $proceso) {// por cada proceso

				$this->obtener_equipos_proceso($proceso);

				$id_proceso = $proceso->obtener_id();

			}

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
