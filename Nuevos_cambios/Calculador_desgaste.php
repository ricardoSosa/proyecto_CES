<?php

	class Calculador_desgaste{

		/*
	     *Construct
	     */
		function __construct(){

		}

		/* Método que calcula es descaste de cada componente */
		public function calcular_desgaste($componente, $tiempo_uso_equipo){

			$porcentaje_uso_componente = $componente->obtener_porcentaje_uso();

			$tiempo_usado = $porcentaje_uso_componente * $tiempo_uso_equipo;

			$tiempo_vida_actual = $componente->obtener_tiempo_vida_actual();

			$nuevo_tiempo_vida_actual = $tiempo_vida_actual + $tiempo_usado;

			$componente->modificar_tiempo_vida_actual($nuevo_tiempo_vida_actual);

		}

	}

?>
