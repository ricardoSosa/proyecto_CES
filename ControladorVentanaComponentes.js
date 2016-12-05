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

    //--------------------------------------
    var panel_componentes = "panel_lista_componentes";
    this.panel_actual = panel_componentes;



    this.validarDatos = function ( datos_componente ) {
      var datos_componente_correctos = false;
      var datos_existen = !( datos_componente === undefined );

      if( datos_existen ) {
        var nombre_componente = datos_componente.nombre;
        var tiempo_vida_componente = datos_componente.tiempo_vida_max;
        var descripcion_componente = datos_componente.descripcion;

        var nombre_componente_correcto = nombre_componente.length != 0;
        var tiempo_vida_componente_correcto = ( tiempo_vida_componente.length != 0 ) && ( parseInt( tiempo_vida_componente ) > 0 );
        var descripcion_componente_correcto = descripcion_componente.length != 0;

        var datos_correctos = nombre_componente_correcto && tiempo_vida_componente_correcto && descripcion_componente_correcto;

        if( datos_correctos ) {
          datos_componente_correctos = true;
        } else {
          datos_componente_correctos = false;
        }
      } else {
        datos_componente_correctos = false;
      }

      return datos_componente_correctos;
    };

    this.enviarDatos = function( datosComponente ) {
      var nombreComponente = datosComponente.nombre;
      var tiempoVidaMax = datosComponente.tiempo_vida_max;
      var descripcionComponente = datosComponente.descripcion;

      var componente = {"id" : "id_componente_" + (this.listaComponentes.length+1),
                        "nombre" : nombreComponente,
                        "tiempo_vida_max" : tiempoVidaMax,
                        "descripcion" : descripcionComponente};

      var datos_solicitud = {tarea : "agregar",
                             elemento: "componentes",
                             datos : componente};

      var solicitud = generar_solicitud( datos_solicitud );


      this.listaComponentes.push( componente ); //DEBE IR UN NIVEL MAS ARRIBA

      enviar_solicitud( solicitud );
    };

    this.buscar_posicion_componente = function ( componente ) {
      var posicion_componente = -1;

      for (i=0; i<this.listaComponentes.length; i++) {
        if(componente == this.listaComponentes[i].id) {
          posicion_componente = i;
        }

      }

      return posicion_componente;
    };

    this.eliminarComponente = function ( componente ) {

      var posicion_componente = this.buscar_posicion_componente( componente );

      this.listaComponentes.splice(posicion_componente, 1);


      var componente = {id : {id : componente},
                        nombre_id : "id" //PENDIENTE
                       };

      var datos_solicitud = {tarea : "eliminar",
                             elemento : "componentes",
                             datos : componente};

      var solicitud = generar_solicitud( datos_solicitud );


      enviar_solicitud( solicitud );

    };


    this.seleccionarComponente = function( componente ) {
      this.componenteSeleccionado = componente;
    };

    this.mandarSolicitudCambio = function( componente ) { //REFACTORIZAR DESPUES
      this.datosCorrectos = this.validarDatos( componente );

      if( this.datosCorrectos ) {
        var id_componente = componente.id;
        var nombre_componente = componente.nombre;
        var tiempo_vida = componente.tiempo_vida_max;
        var descripcion = componente.descripcion;

        var datos_modificacion = { "id" : id_componente,
                                   "nombre" : nombre_componente,
                                   "tiempo_vida_max" : tiempo_vida,
                                   "descripcion" : descripcion};

        var solicitud = {"tarea" : {nombre_tarea : "modificar", tipo_elemento : "componentes"},
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

    var generar_solicitud = function ( datos_consulta ) {
      var tarea = datos_consulta.tarea;
      var tipo_elemento = datos_consulta.elemento;
      var datos = datos_consulta.datos;

      var solicitud = {tarea : {nombre_tarea : tarea, tipo_elemento: tipo_elemento},
                       datos : datos};

      return solicitud;
    };


    this.solicitarListaComponentes = function() {

      var datos_solicitud = {tarea : "consultar lista",
                             elemento : "componentes",
                             datos : "consulta"};

      var solicitud = generar_solicitud( datos_solicitud );

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url : direccionDestino,
        method : "POST",
        data : solicitud,

      } ).success( function ( componentes ) {
        acomodar_componentes_solicitados( componentes );
      }  );
    };

    var acomodar_componentes_solicitados = function ( componentes ) {
      angular.forEach( componentes, function ( componente, key ) {
        componentesSolicitud.push( componente );
      } );
    };

    var enviar_solicitud = function ( solicitud ) {
      console.log(solicitud); // BORAR DESPUES
      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url : direccionDestino,
        method : "POST",
        data : solicitud,

      } ).success( function ( componentes ) {
          console.log(componentes); //BORAR DESPUES
      }  );
    };

    this.solicitarListaComponentes();

    this.cambiar_panel = function ( nuevo_panel ) {
      this.panel_actual = nuevo_panel;
    };

    this.panel_seleccionado = function ( panel ) {
      var panel_activo = this.panel_actual == panel;
      return panel_activo;
    };

    
  } ] );
} )();