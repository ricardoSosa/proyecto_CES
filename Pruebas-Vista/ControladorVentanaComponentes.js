/**
 * Created by shado on 17/11/2016.
 */
( function () {
  var app = angular.module( 'Componentes', [ 'elementos-vista' ] );

  app.controller( 'ControladorVentanaComponentes', [ '$http', function ( $http, $scope ) {
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

    var componentesSolicitud = [];
    this.listaComponentes = componentesSolicitud;
    this.componenteSeleccionado = {};

    this.agregarComponente = function( idComponente ){
      var componenteNoRepetido = this.verificarComponenteNoRepetido( idComponente );

      if( componenteNoRepetido ) {
        this.listaComponentes.push( idComponente );
      }
    };

    this.validarDatos = function ( datosComponente ) {
      var datosExisten = false;
      var datosComponenteCorrectos = false;

      datosExisten = !( datosComponente === undefined );
      if( datosExisten ) {
        var nombreComponenteCorrecto = datosComponente.nombre.length != 0;
        var tiempoVidaComponenteCorrect = datosComponente.tiempoVida.length != 0;
        var descripcionComponenteCorrecto = datosComponente.descripcion.length != 0;

        if( nombreComponenteCorrecto && tiempoVidaComponenteCorrect && descripcionComponenteCorrecto ) {
          datosComponenteCorrectos = true;
        } else {
          datosComponenteCorrectos = false;
        }
      } else {
        datosComponenteCorrectos = false;
      }

      return datosComponenteCorrectos;
    };

    this.enviarDatos = function( datosComponente ) {
      var nombreComponente = datosComponente.nombre;
      var tiempoVidaMax = datosComponente.tiempoVida;
      var descripcionComponente = datosComponente.descripcion;

      var componente = {"id" : "id_componente_" + (this.listaComponentes.length+1),
                        "nombre" : nombreComponente,
                        "tiempo_vida_max" : tiempoVidaMax,
                        "descripcion" : descripcionComponente,
                        "tipo_elemento" : "componentes"};

      var datos_componente = {tarea : "agregar",
                              datos : componente};

      this.listaComponentes.push( componente ); //BORRAR DESPUES

      var direccionDestino = 'proyecto_CES/Asignador_tareas.php';
      $http( {
        url: direccionDestino,
        method: "POST",
        data: datos_componente
      } ).then( function ( response ) {
        console.log( response );
      }, function ( response ) {
        console.log( response )
      } );
    };

    this.eliminarComponente = function ( componente ) {

      var indiceComponente = -1;
      for (i=0; i<this.listaComponentes.length; i++) {
        if(componente == this.listaComponentes[i].id) {
          indiceComponente = i;
        }
      }

      this.listaComponentes.splice(indiceComponente, 1);

      console.log(indiceComponente);

      var datos_componente = {"id" : componente,
                              "tipo_elemento" : "componentes"
                             };

      var datos_eliminacion = {tarea : "eliminar",
                               datos : datos_componente
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


    };

    this.verificarComponenteNoRepetido = function ( componente ) {
      var componenteNoRepetido = false;
      var existeIndiceComponente = this.listaComponentes.indexOf( componente );

      if( existeIndiceComponente != 1 ) {
        componenteNoRepetido = false;
      } else {
        componenteNoRepetido = true;
      }

      return componenteNoRepetido;
    };

    this.seleccionarComponente = function( componente ) {
      this.componenteSeleccionado = componente;
    };

    this.mandarSolicitudCambio = function( componente ) { //REFACTORIZAR DESPUES
      this.datosCorrectos = this.validarDatos( componente );

      if( this.datosCorrectos ) {
        var camposComponente = [ 'nombre', 'tiempo_vida_max','descripcion' ];
        var atributosComponente = [componente.nombre, componente.tiempo_vida_max, componente.descripcion];

        for( i=0; i<camposComponente.length; i++ ) {
          var modificacion = { "tipo_elemento" : "componentes",
                               "atrib_modificar" : camposComponente[ i ],
                               "dato_nuevo" : atributosComponente[ i ],
                               "id" : componente.id};

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
      }
    }

    this.solicitarListaComponentes = function() {
      var datos_solicitud = {"tipo_elemento" : "componentes",
                             "tipo_consulta" : "lista"};

      var solicitud = {tarea : "consultar",
                       datos : datos_solicitud};

      var direccionDestino = 'proyecto_CES/Asignador_tareas.php';
      $http( {
        url : direccionDestino,
        method : "POST",
        data : solicitud,

      } ).success( function ( componentes ) {
        angular.forEach( componentes, function ( componente, key ) {
          componentesSolicitud.push( componente );
        } );
        console.log(componentesSolicitud);

      }  );
    };

    this.solicitarListaComponentes();
  } ] );
} )();