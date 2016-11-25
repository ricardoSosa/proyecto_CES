/**
 * Created by shado on 08/11/2016.
 */
( function () {
  var app = angular.module( 'Equipos', [ 'elementos-vista' ] );

  app.controller( 'ControladorTablaComponentes', [ '$http', function ( $http, $scope ) {
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

    var equiposSolicitud = [];
    var tabla = this;
    tabla.componentes = [];
    this.listaComponentes =[];
    this.listaEquipos = equiposSolicitud;
    this.equipoSeleccionado = {};

    this.agregarComponente = function ( idComponente ) {
      var componenteNoRepetido = this.verificarComponenteNoRepetido( idComponente );

      if( componenteNoRepetido ) {
        this.listaComponentes.push( idComponente );
        console.log( this.listaComponentes + this.listaComponentes.indexOf( idComponente ) ); //BORAR DESPUES,SOLO PARA PRUEBAS
      }

    };

    this.validarDatos = function ( datosEquipo ) {
      var datosExisten = false;
      var datosEquipoCorrectos = false;
      console.log(datosEquipo);

      datosExisten = !( datosEquipo === undefined );
      if( datosExisten ) {
        var nombreEquipoCorrecto = datosEquipo.nombre.length != 0;
        var ubicionEquipoCorrecta = datosEquipo.ubicacion.length != 0;
        var descripcionEquipoCorrecto = datosEquipo.descripcion.length != 0;


        if( nombreEquipoCorrecto && ubicionEquipoCorrecta && descripcionEquipoCorrecto ) {
          datosEquipoCorrectos = true;
        } else {
          datosEquipoCorrectos = false;
        }

      } else {
        datosEquipoCorrectos = false;
      }



      console.log(datosEquipoCorrectos); //BORRAR DESPUES
      return datosEquipoCorrectos;


    };

    this.enviarDatos = function ( datosEquipo ) {
      console.log( datosEquipo );
      var nombreEquipo = datosEquipo.nombre;
      var ubicacionEquipo = datosEquipo.ubicacion;
      var descripcionEquipo = datosEquipo.descripcion;

      var equipo = { "id" : "id_equipos_" + (this.listaEquipos.length+1),
                     "nombre" : nombreEquipo,
                     "descripcion" : descripcionEquipo,
                     "ubicacion" : ubicacionEquipo,
                     "tipo_elemento" : 'equipos'
                   };

      var datos_equipo = { tarea : 'agregar',
                           datos : equipo
                         };

     this.listaEquipos.push( equipo );

      var direccionDestino = 'proyecto_CES/Asignador_tareas.php';
      $http( {
        url: direccionDestino,
        method: "POST",
        data: datos_equipo
      } ).then( function (response) {
        console.log(response);
      }, function (response) {
        
      } );
    };

    this.eliminarComponente = function( componente ) {
      var indiceComponente = this.listaComponentes.indexOf( componente );
      this.listaComponentes.splice( indiceComponente, 1 );
      console.log( this.listaComponentes ); // BORAR DESPUES,SOLO PARA PRUEBAS
    }

    this.eliminarEquipo = function ( equipo ) {

      var indiceEquipo = -1;
      for( i=0; i<this.listaEquipos.length; i++ ) {
        if(equipo == this.listaEquipos[i].id){
          indiceEquipo = i;
        }
      }

      this.listaEquipos.splice(indiceEquipo, 1);

      var datos_equipo = {"id" : equipo,
                          "tipo_elemento" : "equipos"
                         };

      var datos_eliminacion = {tarea : "eliminar",
                               datos : datos_equipo
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

    this.seleccionarEquipo = function ( equipo ) {
      this.equipoSeleccionado = equipo;
    };

    this.mandarSolicitudCambio = function( equipo ) {
      this.datosCorrectos = this.validarDatos( equipo );

      if( this.datosCorrectos ) {
        var camposEquipo = [ 'nombre', 'ubicacion', 'descripcion' ];
        var atributosEquipo = [ equipo.nombre, equipo.ubicacion, equipo.descripcion ];

        for( i=0;i<camposEquipo.length; i++ ) {
          var modificacion = { "tipo_elemento" : "equipos",
                               "atrib_modificar" : camposEquipo[ i ],
                               "dato_nuevo" : atributosEquipo[ i ],
                               "id" : equipo.id};

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

    this.verificarComponenteNoRepetido = function ( componente ) {
      var componenteNoRepetido = false;
      var existeIndiceComponente = this.listaComponentes.indexOf( componente );

      if( existeIndiceComponente != -1){
        componenteNoRepetido = false;
      } else {
        componenteNoRepetido = true;
      }

      return componenteNoRepetido;
    };

    this.solicitarListaEquipos = function () {
      var datos_solicitud = {"tipo_elemento" : "equipos",
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
      } ).success( function ( equipos ) {
        angular.forEach( equipos, function ( equipo, key ) {
          equiposSolicitud.push( equipo );
        } );
        console.log( equiposSolicitud );
      } );
    };

    this.solicitarListaComponenesDisponibles = function () {
      var datos_solicitud = {"tipo_elemento" : "componentes",
                             "tipo_consulta" : "lista" };

      var solicitud = {"tarea" : "consultar",
                       "datos" : datos_solicitud};

      var direccionDestino = 'proyecto_CES/Asignador_tareas.php';
      $http( {
        url : direccionDestino,
        method : "POST",
        data : solicitud,
      } ).success( function ( componentes ) {
        console.log( componentes );
        tabla.componentes = componentes;
        console.log(tabla.componentes);
      } );
    };


    this.solicitarListaEquipos();
    this.solicitarListaComponenesDisponibles();


    /*$http.get( '/curso_php/angularjs/Vista-Proyecto/componentes.json' ).success( function ( data ) {
      tabla.componentes = data;
    } );*/

  } ] );



} )();
