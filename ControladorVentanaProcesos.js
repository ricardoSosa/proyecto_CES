/**
 * Created by shado on 12/11/2016.
 */
( function () {
  var app = angular.module( 'Procesos', [ 'elementos-vista' ] );

  app.controller( 'ControladorVentanaProcesos', [ '$http', function ( $http, $scope ) {
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

    var procesosSolicitud = [];
    var tabla = this;
    tabla.equipos = [];
    this.listaEquipos = [];
    this.listaProcesos = procesosSolicitud;
    this.procesoSeleccionado = {};

    //-----------------------------------------------
    //cosas del panel despues de la simulacion

    this.simulado = false;

    this.simular = function(){
      this.simulado = true;
      console.log("simular");
    }

    //-----------------------------------------------
    //cosas de la simulacion
    this.procesosSeleccionados = [];
    this.listaProcesosSeleccionados = [];
    var procesosSimulados = [];
    var equiposProcesosSimulados = [];
    var componentesEquiposSimulados = [];
    var arrayInterno = [];


    this.anadirProcesoSelecionado = function( proceso ){
      console.log("añadirProcesoSelecionado()");
      console.log("----->" + proceso.descripcion);
      var isProcesoOnArray = this.procesosSeleccionados.indexOf( proceso.id );
      if(isProcesoOnArray < 0){
        this.procesosSeleccionados.push( proceso.id );
        this.listaProcesosSeleccionados.push(proceso);
        console.log(this.procesosSeleccionados);
      }else{
        console.log("proceso ya se encuentra en el array");
      }
    }

    this.procesosSim = procesosSimulados;//procesosSimulados;
    this.equiposSim = equiposProcesosSimulados;
    this.composSim = componentesEquiposSimulados;
    this.arrayExterno = arrayInterno;

    this.simularProcesos = function(){
      console.log("simularProcesos");
      var duracion_procesos = document.getElementsByTagName('input');
      console.log("value"+duracion_procesos[0].value);

      var id_procesos_duracion = {};

      for(var i = 0; i < this.procesosSeleccionados.length; i++){
        console.log(duracion_procesos[i].value);
        var duracion = parseInt(duracion_procesos[i].value);
        id_procesos_duracion [this.procesosSeleccionados[i]] = duracion;
      }
      console.log(id_procesos_duracion);

      var datos_solicitud = {"id_procesos_duracion" : id_procesos_duracion};

      var solicitud = { tarea : {nombre_tarea : "simular", tipo_elemento : "simulador"},
                            datos: datos_solicitud};

      console.log("mandando informacion");
      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url: direccionDestino,
        method: "POST",
        data: solicitud
      } ).success( function ( procesos ) {

        // var datos = {};
        // for (var i = 0; i < procesos.length; i++) {
        //   datos ['proceso'] = procesos[i];
        //   for (var j = 0; j < procesos.equipos_proceso[i].length; j++) {
        //     datos ['equipo'+j] = procesos.equipos_proceso[j];
        //     for(k = 0; k < procesos.equipos_proceso[j].componentes_equipo.length; k++){
        //       datos [componente+k] = procesos.equipos_proceso[j].componentes_equipo[k];
        //     };
        //     arrayInterno.push(datos);
        //     datos = {};
        //   };
        // };

          console.log("Veamos si chambea");
          console.log(arrayInterno);
          // console.log("gigantote:");
          // console.log(procesos);
        angular.forEach( procesos, function ( procesoSim, key ) {


          // console.log("los procesos son:")
          // console.log(procesoSim);
          procesosSimulados.push( procesoSim );

          angular.forEach( procesoSim.equipos_proceso, function( equiposSimulados, key ){
            // console.log("equipos procesos son:");
            // console.log(procesoSim.equipos_proceso);
            equiposProcesosSimulados.push(equiposSimulados);

            angular.forEach(equiposSimulados.componentes_equipo, function(componentesSimulados, key){
              componentesEquiposSimulados.push(componentesSimulados);
              console.log(componentesSimulados);
            });

          } );

        } );
          // console.log("fin simular procesos");
      }  );
      console.log("fin simular procesos");
    };

    this.quitarProcesoSimulacion = function( proceso ){
      console.log("quitarProcesoSimulacion");
      var indiceProceso = this.procesosSeleccionados.indexOf( proceso.id );
      this.procesosSeleccionados.splice(indiceProceso, 1);
      this.listaProcesosSeleccionados.splice(indiceProceso, 1);
      console.log(this.procesosSeleccionados);
    }

    //-----------------------------------------------

    //-----------------------------------------------
    var panel_procesos = "panel_lista_procesos";
    this.panel_actual = panel_procesos;
    console.log( this.panel_actual ); //BORRAR DESPUES


    this.agregarEquipo = function ( idEquipo ) {

      var equipoNoRepetido = this.verificarEquipoNoRepetido( idEquipo );
      console.log(equipoNoRepetido);

      if ( equipoNoRepetido ) {
        this.listaEquipos.push( idEquipo );
        console.log(this.listaEquipos); //BORRAR DESPUES
      }
    };

    this.validarDatos = function ( datosProceso ) {

      var datosExisten = false;
      var datosProcesoCorrectos = false;

      datosExisten = !( datosProceso === undefined );
      if( datosExisten ) {
        var nombreProcesoCorrecto = datosProceso.nombre.length != 0;
        var descripcionProcesoCorrecto = datosProceso.descripcion.length != 0;

        if( nombreProcesoCorrecto && descripcionProcesoCorrecto ) {
          datosProcesoCorrectos = true;
        } else {
          datosProcesoCorrectos = false;
        }
      } else {
        datosProcesoCorrectos = false;
      }

      return datosProcesoCorrectos;
    }

    this.enviarDatos = function ( datosProceso ) {
      //VALIDACION DE PORCENTAJES-------------------------------------------------------------
      var porcentaje_total = 0;

      for(j=0; j<this.listaEquipos.length; j++) {
        porcentaje_total = parseInt(this.listaEquipos[j].porcentaje_usado) + porcentaje_total;
      }

      console.log(porcentaje_total);

      if(porcentaje_total > 0 && porcentaje_total<100){
        console.log("correcto");
        var nombreProceso = datosProceso.nombre;
        var descripcionProceso = datosProceso.descripcion;
        var idProceso = "id_proceso_" + (this.listaProcesos.length+1);

        var proceso = { "id" : idProceso,
          "nombre": nombreProceso,
          "descripcion" : descripcionProceso,
          "activado" : false};

        var datos_proceso = { tarea : {nombre_tarea : "agregar", tipo_elemento : "procesos"},
          datos: proceso};

        this.listaProcesos.push( proceso ); //BORRAR DESPUES

        var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
        $http( {
          url: direccionDestino,
          method: "POST",
          data: datos_proceso
        } ).then( function ( response ) {
          console.log( response );
        }, function ( response ) {
          console.log( response )
        } );


        for(i=0; i<this.listaEquipos.length; i++) {
          var equipo = this.listaEquipos[ i ];
          console.log(equipo);
          var equipo = {id_proceso : idProceso,
            id_equipo : equipo.id,
            porcentaje_uso : equipo.porcentaje_usado};

          var solicitud = {tarea : {nombre_tarea : "agregar equipo a proceso", tipo_elemento : "procesos"},
            datos : equipo};

          $http( {
            url: direccionDestino,
            method: "POST",
            data: solicitud
          } ).then( function (response) {
            console.log(response);
          }, function (response) {

          } );
        }
      } else {
        console.log("incorrecto");
      }
      //---------------------------------------------------------------------------------------


    };

    this.eliminarEquipo = function ( equipo ) {
      var indiceEquipo = this.listaEquipos.indexOf( equipo );
      this.listaEquipos.splice( indiceEquipo, 1 );
    };

    this.eliminarProceso = function ( proceso ) {

      var indiceProceso = -1;
      for (i=0; i<this.listaProcesos.length; i++) {
        if(proceso == this.listaProcesos[i].id) {
          indiceProceso = i;
        }
      }

      this.listaProcesos.splice(indiceProceso, 1);

      console.log(indiceProceso);

      var datos_proceso = {"id" : {id : proceso},
                           "nombre_id" : "id" //PENDIENTE
                          };

      var datos_eliminacion = {tarea : {nombre_tarea : "eliminar", tipo_elemento : "procesos"},
                               datos : datos_proceso};

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url: direccionDestino,
        method: "POST",
        data: datos_eliminacion
      } ).then( function ( response ) {
        console.log( response ); //BORRAR DESPUESS
      }, function ( response ) {
        console.log( response ); //BORRAR DESPUES
      } );

    };

    this.verificarEquipoNoRepetido = function ( equipo ) {
      var equipoNoRepetido = false;
      var existeIndiceEquipo = this.listaEquipos.indexOf( equipo );

      if( existeIndiceEquipo != -1 ) {
        equipoNoRepetido = false;
      } else {
        equipoNoRepetido = true;
      }

      return equipoNoRepetido;
    };

    this.seleccionarProceso = function( proceso ) {
      this.procesoSeleccionado = proceso;


    };

    this.mandarSolicitudCambio = function( proceso ) { //REFACTORIZAR DESPUES
      this.datosCorrectos = this.validarDatos( proceso );
      console.log(this.datosCorrectos);

      if( this.datosCorrectos ) {
        var id_proceso = proceso.id;
        var nombre_proceso = proceso.nombre;
        var descripcion = proceso.descripcion;

        var datos_modificacion = {"id" : id_proceso,
                                  "nombre" : nombre_proceso,
                                  "descripcion" : descripcion};

        var solicitud = {"tarea" : {nombre_tarea : "modificar", tipo_elemento : "procesos"},
                         "datos" : datos_modificacion};

        var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
        $http( {
          url: direccionDestino,
          method: "POST",
          data: solicitud
        } ).then( function ( response ) {
          console.log( response );
        }, function ( response ) {
          console.log( response )
        } );

      }
    };

    this.solicitarListaProcesos = function() {

      var solicitud = {tarea : {nombre_tarea : "consultar lista", tipo_elemento : "procesos"},
                       datos : "datos"};

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url : direccionDestino,
        method : "POST",
        data : solicitud,

      } ).success( function ( procesos ) {
        angular.forEach( procesos, function ( proceso, key ) {
          console.log(proceso); //BORRAR DESPUES
          procesosSolicitud.push( proceso );
        } );
          console.log(procesosSolicitud);

      }  );
    };

    this.solicitarListaEquiposDisponibles = function () {

      var solicitud = {"tarea" : {nombre_tarea : "consultar lista", tipo_elemento : "equipos"},
                       "datos" : "datos"};

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url : direccionDestino,
        method : "POST",
        data : solicitud,
      } ).success( function ( equipos ) {
        console.log( equipos );
        tabla.equipos = equipos;
        console.log(tabla.equipos);
      } );
    };

    this.activar_proceso = function (  proceso  ) {
      proceso.activado = 1;
      var id_proceso = proceso.id;

      //MODIFICA EL ESTO DEL EQUIPO A ACTIVO
      var datos_activacion = {id : id_proceso,
                              activado : true};

      var solicitud = {"tarea" : {nombre_tarea : "modificar", tipo_elemento : "procesos"},
        "datos" : datos_activacion};

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url: direccionDestino,
        method: "POST",
        data: solicitud
      } ).then( function ( response ) {
        console.log( response );
      }, function ( response ) {
        console.log( response )
      } );

      //SE AGREGA AL HISTORIAL
      var fecha = new Date();
      var fecha_activacion = fecha.getDate() + "/" + fecha.getMonth() + "/" + fecha.getFullYear();
      var hora_activacion = "-" + fecha.getHours() + ":" + fecha.getMinutes();
      console.log(fecha_activacion + hora_activacion);

      var proceso_activo = {id_proceso : id_proceso,
                            fecha_ini : fecha_activacion + hora_activacion,
                            fecha_ter : ' '};

      var solicitud = {tarea : {nombre_tarea : "activar proceso", tipo_elemento : "procesos"},
                       datos : proceso_activo};

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url: direccionDestino,
        method: "POST",
        data: solicitud
      } ).then( function ( response ) {
        console.log( response );
      }, function ( response ) {
        console.log( response )
      } );

    };

    this.terminar_proceso = function ( proceso ) {
      var id_proceso = proceso.id;
      proceso.activado = 0;

      //MODIFICA EL ESTO DEL EQUIPO A ACTIVO
      var datos_terminacion = {id : id_proceso,
                              activado : false};

      var solicitud = {"tarea" : {nombre_tarea : "modificar", tipo_elemento : "procesos"},
                       "datos" : datos_terminacion};

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url: direccionDestino,
        method: "POST",
        data: solicitud
      } ).then( function ( response ) {
        console.log( response );
      }, function ( response ) {
        console.log( response )
      } );

      //SE AGREGA AL HISTORIAL
      var fecha = new Date();
      var fecha_activacion = fecha.getDate() + "/" + fecha.getMonth() + "/" + fecha.getFullYear();
      var hora_activacion = "-" + fecha.getHours() + ":" + fecha.getMinutes();
      console.log(fecha_activacion + hora_activacion);

      var proceso_terminado = {id_proceso : id_proceso,
                            fecha_ter : fecha_activacion + hora_activacion};

      var solicitud = {tarea : {nombre_tarea : "finalizar proceso", tipo_elemento : "procesos"},
                       datos : proceso_terminado};

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url: direccionDestino,
        method: "POST",
        data: solicitud
      } ).then( function ( response ) {
        console.log( response );
      }, function ( response ) {
        console.log( response )
      } );

    }

    this.solicitarListaProcesos();
    this.solicitarListaEquiposDisponibles();

    this.cambiar_panel = function ( nuevo_panel ) {
      this.panel_actual = nuevo_panel;
    };

    this.panel_seleccionado = function ( panel ) {
      var panel_activo = this.panel_actual == panel;
      return panel_activo;
    };

  } ] );

} )();