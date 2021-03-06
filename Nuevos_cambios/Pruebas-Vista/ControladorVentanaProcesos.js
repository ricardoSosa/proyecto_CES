/**
 * Created by shado on 12/11/2016.
 */
( function () {
  var app = angular.module( 'Procesos', [ 'elementos-vista' ] );

  app.controller( 'ControladorVentanaProcesos', [ '$http', function ( $http, $scope ) {
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

    var procesosSolicitud = [];
    this.listaEquipos = [];
    this.listaProcesos = procesosSolicitud;
    this.procesoSeleccionado = {};


    this.agregarEquipo = function ( idEquipo ) {
      var equipoNoRepetido = this.verificarEquipoNoRepetido( idEquipo );

      if ( equipoNoRepetido ) {
        this.listaEquipos.push( idEquipo );
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
                      "tipo_elemento" : "procesos"
                    };

      var datos_proceso = { tarea : "agregar",
                            datos: proceso
                          };

      this.listaProcesos.push( proceso ); //BORRAR DESPUES

      var direccionDestino = 'proyecto_CES/Asignador_tareas.php';
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
                           "tipo_elemento" : "procesos"
                          };

      var datos_eliminacion = {tarea : "eliminar",
                               datos : datos_proceso
                              };

      var direccionDestino = 'proyecto_CES/Asignador_tareas.php';
      $http( {
        url: direccionDestino,
        method: "POST",
        data: datos_eliminacion
      } ).then( function ( response ) {
        console.log( response ); //BORRAR DESPUESS
      }, function ( response ) {
        console.log( response ); //BORRAR DESPUES
      } );

      this.actualizarListaProcesos();
    }

    this.verificarEquipoNoRepetido = function ( equipo ) {
      var equipoNoRepetido = false;
      var existeIndiceEquipo = this.listaEquipos.indexOf( equipo );

      if( existeIndiceEquipo != 1 ) {
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
      console.log(proceso);

      if( this.datosCorrectos ) {
        var camposProceso = [ 'nombre', 'descripcion' ];
        var atributosPrceso = [ proceso.nombre, proceso.descripcion ];

        for( i=0; i<camposProceso.length; i++ ) {

          var modificacion = { "tipo_elemento" : "procesos",
                               "atrib_modificar" : camposProceso[ i ],
                               "dato_nuevo" : atributosPrceso[ i ],
                               "id" : proceso.id };

        }

        var solicitud = { "tarea" : "modificar", "datos" : modificacion };

        var direccionDestino = 'proyecto_CES/Asignador_tareas.php';
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
                       datos : datos_solicitud
                      };

      var direccionDestino = 'proyecto_CES/Asignador_tareas.php';
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

    this.actualizarListaProcesos = function () {
      //this.listaProcesos = [];
      //  this.solicitarListaProcesos();
    };

    this.solicitarListaProcesos();

  } ] );

} )();