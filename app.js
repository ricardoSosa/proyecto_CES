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

    //----------------------------------------
    var panel_equipos = "panel_lista_equipos";
    this.panel_actual = panel_equipos;
    console.log(this.panel_actual); //BORRAR DESPUES

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
      var idEquipo = "id_equipos_" + (this.listaEquipos.length+1);

      var equipo = { "id" : idEquipo,
                     "nombre" : nombreEquipo,
                     "descripcion" : descripcionEquipo,
                     "ubicacion" : ubicacionEquipo};

      var datos_equipo = { tarea : {nombre_tarea : "agregar", tipo_elemento : "equipos"},
                           datos : equipo};

     this.listaEquipos.push( equipo );

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url: direccionDestino,
        method: "POST",
        data: datos_equipo
      } ).then( function (response) {
        console.log(response);
      }, function (response) {
        
      } );

      //incerta los componentes al equipo uno por uno
      for(i=0; i<this.listaComponentes.length; i++) {
        var componente = this.listaComponentes[ i ];
        console.log(componente); //BORAR DESPUES
        var componente_seleccionado = {id_equipo : idEquipo,
                                       id_componente : componente.id,
                                       porcentaje_uso : componente.porcentaje_usado};

        var solicitud = {tarea : {nombre_tarea : "agregar componente a equipo", tipo_elemento : "equipos"},
                         datos : componente_seleccionado};

        $http( {
          url: direccionDestino,
          method: "POST",
          data: solicitud
        } ).then( function (response) {
          console.log(response);
        }, function (response) {

        } );

        var solicitudC = {tarea:{nombre_tarea : "modificar", tipo_elemento : "componentes"},
                         datos : {id :componente.id, enUso : true}};

        $http( {
          url: direccionDestino,
          method: "POST",
          data: solicitudC
        } ).then( function (response) {
          console.log(response);
        }, function (response) {

        } );
      }
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

      var datos_equipo = {"id" : {id : equipo},
                          "nombre_id" : "id"};

      var datos_eliminacion = {tarea : {nombre_tarea : "eliminar", tipo_elemento : "equipos"},
                               datos : datos_equipo};

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

    this.seleccionarEquipo = function ( equipo ) {
      this.equipoSeleccionado = equipo;
    };

    this.mandarSolicitudCambio = function( equipo ) {
      this.datosCorrectos = this.validarDatos( equipo );

      if( this.datosCorrectos ) {
        var id_equipo = equipo.id;
        var nombre_equipo = equipo.nombre;
        var ubicacion_equipo = equipo.ubicacion;
        var descripcion = equipo.descripcion;

        var datos_modificacion = {"id" : id_equipo,
                                  "nombre" : nombre_equipo,
                                  "ubicacion" : ubicacion_equipo,
                                  "descripcion" : descripcion};

        var solicitud = {"tarea" : {nombre_tarea : "modificar", tipo_elemento : "equipos"},
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

      var solicitud = {tarea : {nombre_tarea : "consultar lista", tipo_elemento : "equipos"},
                       datos : "consultar"};

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
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

      var solicitud = {"tarea" : {nombre_tarea : "consultar lista", tipo_elemento : "componentes"},
                       "datos" : "datos comoponentes"};

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
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

    this.cambiar_panel = function ( nuevo_panel ) {
      this.panel_actual = nuevo_panel;
    };

    this.panel_seleccionado = function ( panel ) {
      var panel_activo = this.panel_actual == panel;
      return panel_activo;
    };


    /*$http.get( '/curso_php/angularjs/Vista-Proyecto/componentes.json' ).success( function ( data ) {
      tabla.componentes = data;
    } );*/

  } ] );



} )();