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

      var proceso = { "id" : "id_proceso_" + (this.listaProcesos.length+1),
                      "nombre": nombreProceso,
                      "descripcion" : descripcionProceso,
                      "tipo_elemento" : "procesos"};

      var datos_proceso = { tarea : "agregar",
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

      var datos_proceso = {"id" : proceso,
                           "tipo_elemento" : "procesos",
                           "nombre_id" : "id" //PENDIENTE
                          };

      var datos_eliminacion = {tarea : "eliminar",
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
                                  "descripcion" : descripcion,
                                  "tipo_elemento" : "procesos"};

        var solicitud = {"tarea" : "modificar", "datos" : datos_modificacion};

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
      var datos_solicitud = {"tipo_elemento" : "procesos",
                             "tipo_consulta" : "lista"
                            };

      var solicitud = {tarea : "consultar",
                       datos : datos_solicitud};

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
      var datos_solicitud = {"tipo_elemento" : "equipos",
                             "tipo_consulta" : "lista"};

      var solicitud = {"tarea" : "consultar",
                       "datos" : datos_solicitud};

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