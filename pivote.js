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
        console.log(procesos);
        angular.forEach( procesos, function ( procesoSim, key ) {
          // console.log("id_proceso:-> "+procesoSim.id_proceso);
          console.log(procesoSim);
          procesosSimulados.push( procesoSim );
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
      var nombreProceso = datosProceso.nombre;
      var descripcionProceso = datosProceso.descripcion;
      var idProceso = "id_proceso_" + (this.listaProcesos.length+1);

      var proceso = { "id" : idProceso,
                      "nombre": nombreProceso,
                      "descripcion" : descripcionProceso};

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