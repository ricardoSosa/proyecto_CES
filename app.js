/**
 * Created by shado on 08/11/2016.
 */
( function () {
  var app = angular.module( 'Equipos', [ 'elementos-vista' ] );

  app.factory( 'Secretaria', ['$http', function ( $http ) {
    function Secretaria() {
      console.log("Holi");
    };

    Secretaria.prototype.verificar_datos_equipo = function ( datos_equipo ) {
      var datos_equipo_correctos = false;
      var datos_existen = !( datos_equipo === undefined );

      if( datos_existen ) {
        var nombre_equipo_correcto = datos_equipo.nombre.length != 0;
        var ubicacion_equipo_correcto = datos_equipo.ubicacion.length != 0;
        var descripcion_equipo_correcto = datos_equipo.descripcion.length != 0;

        var datos_correctos = nombre_equipo_correcto && ubicacion_equipo_correcto && descripcion_equipo_correcto;

        if( datos_correctos ) {
          datos_equipo_correctos = true;
        } else {
          datos_equipo_correctos = false;
        }

      } else {
        datos_equipo_correctos = false;
      }

      return datos_equipo_correctos;

    }


    Secretaria.prototype.verificar_datos_componente = function ( datos_componente ) {
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
    }

    Secretaria.prototype.generar_solicitud = function ( datos_solicitud ) {
      var tarea = datos_solicitud.tarea;
      var tipo_elemento = datos_solicitud.elemento;
      var datos = datos_solicitud.datos;

      var solicitud = {tarea : {nombre_tarea : tarea, tipo_elemento: tipo_elemento},
                       datos : datos};

      return solicitud;
    }

    Secretaria.prototype.enviar_solicitud = function ( solicitud ) {
      console.log(solicitud); // BORAR DESPUES
      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url : direccionDestino,
        method : "POST",
        data : solicitud,

      } ).success( function ( componentes ) {
        console.log(componentes); //BORAR DESPUES
      }  );
    }

    return Secretaria;
  }]);

  app.factory( 'Responsable_Equipos', [ 'Secretaria', '$http', function ( Secretaria, $http ) {
    var equipos_disponibles = [];

    function Responsable_Equipos() {
      this.lista_componentes = [];
      this.lista_equipos = equipos_disponibles;
      this.secretaria = new Secretaria();
    }

    Responsable_Equipos.prototype.asignar_componentes_a_equipo = function ( id_equipo ) {
      for(i=0; i<this.lista_componentes.length; i++) {
        var componente = this.lista_componentes[ i ];
        var componente_seleccionado = {id_equipo : id_equipo,
                                       id_comp : componente.id,
                                       porcentaje_uso : componente.porcentaje_usado};

        var datos_solicitud = {tarea : "agregar componente a equipo",
                               elemento : "equipos",
                               datos : componente_seleccionado}

        var solicitud_asignacion = this.secretaria.generar_solicitud( datos_solicitud );
        this.secretaria.enviar_solicitud( solicitud_asignacion );

        var datos_solicitud_bloquear_comp = {tarea : "modificar",
                                             elemento : "componente",
                                             datos : {id : componente.id, enUso : true}};

        var solicitud_bloquear_comp = this.secretaria.generar_solicitud( datos_solicitud_bloquear_comp );
        this.secretaria.enviar_solicitud( solicitud_bloquear_comp );
        }
    }


    Responsable_Equipos.prototype.solicitar_nuevo_equipo = function ( datos_equipo ) {
      var datos_validos = this.secretaria.verificar_datos_equipo( datos_equipo );

      if( datos_validos ) {
        var nombre_equipo = datos_equipo.nombre;
        var ubicacion_equipo = datos_equipo.ubicacion;
        var descripcion_equipo = datos_equipo.descripcion;
        var idEquipo = "id_equipos_" + (Math.floor((Math.random() * 1000) + 1));

        var equipo = { "id" : idEquipo,
                       "nombre" : nombre_equipo,
                       "descripcion" : descripcion_equipo,
                       "ubicacion" : ubicacion_equipo};

        var datos_solicitud = {tarea : "agregar",
                               elemento : "equipos",
                               datos : equipo};

        var solicitud = this.secretaria.generar_solicitud( datos_solicitud );
        this.secretaria.enviar_solicitud( solicitud );

        return equipo;

      }

    }

    Responsable_Equipos.prototype.solicitar_modificacion_equipo = function ( nuevos_datos_equipo ) {
      var datos_validos = this.secretaria.verificar_datos_equipo( nuevos_datos_equipo );

      if( datos_validos ) {
        var id_equipo = nuevos_datos_equipo.id;
        var nombre_equipo = nuevos_datos_equipo.nombre;
        var ubicacion_equipo = nuevos_datos_equipo.ubicacion;
        var descripcion = nuevos_datos_equipo.descripcion;

        var datos_modificacion = {"id" : id_equipo,
                                  "nombre" : nombre_equipo,
                                  "ubicacion" : ubicacion_equipo,
                                  "descripcion" : descripcion};

        var datos_solicitud = {tarea : "modificar",
                               elemento : "equipos",
                               datos : datos_modificacion};

        var solicitud = this.secretaria.generar_solicitud( datos_solicitud );
        this.secretaria.enviar_solicitud( solicitud );

      }
    }

    Responsable_Equipos.prototype.solicitar_eliminacion_equipo = function ( id_equipo ) {
      var datos_equipo = {"id" : {id : equipo},
                          "nombre_id" : "id"};

      var datos_solicitud = {tarea : "eliminar",
                             elemento : "equipos",
                             datos : datos_equipo}

      var solictud = this.secretaria.generar_solicitud( solictud );
      this.secretaria.enviar_solicitud( solictud );

    }

    Responsable_Equipos.prototype.solicitar_lista_equipos = function () {
      var datos_solicitud = {tarea : "consultar lista",
                             elemento : "equipos",
                             datos : "consulta"};

      var solicitud = this.secretaria.generar_solicitud( datos_solicitud );

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url : direccionDestino,
        method : "POST",
        data : solicitud,

      } ).success( function ( equipos ) {

        angular.forEach( equipos, function ( equipo, key ) {
          equipos_disponibles.push( equipo );
        } );

      }  );
    }

    return Responsable_Equipos;
  } ] );

  app.controller( 'ControladorTablaComponentes', [ 'Secretaria','Responsable_Equipos' , '$http', function ( Secretaria, Responsable_Equipos,  $http ) {

    var responsable_equipos = new Responsable_Equipos();



    var equiposSolicitud = [];
    var tabla = this;
    tabla.componentes = [];
    this.listaComponentes =[];
    this.listaEquipos = equiposSolicitud;
    this.equipoSeleccionado = {};

    //----------------------------------------
    var panel_equipos = "panel_lista_equipos";
    this.panel_actual = panel_equipos;

    this.agregarComponente = function ( idComponente ) {
      var componenteNoRepetido = this.verificarComponenteNoRepetido( idComponente );

      if( componenteNoRepetido ) {
        this.listaComponentes.push( idComponente );
      }

    };


    this.click_agregar_equipo = function ( datos_equipo ) {
      var nuevo_equipo = responsable_equipos.solicitar_nuevo_equipo( datos_equipo );
      this.listaEquipos.push( nuevo_equipo );
    };

    this.eliminarComponente = function( componente ) {
      var indiceComponente = this.listaComponentes.indexOf( componente );
      this.listaComponentes.splice( indiceComponente, 1 );
    }

    this.buscar_posicion_equipo= function ( equipo ) {
      var posicion_equipo = -1;

      for (i=0; i<this.listaEquipos.length; i++) {
        if(componente == this.lista_equipos[i].id) {
          posicion_equipo = i;
        }

      }

      return posicion_equipo;
    };

    this.click_eliminar_equipo = function ( id_equipo ) {

      var posicion_equipo = this.buscar_posicion_equipo( id_equipo );
      this.listaEquipos.splice(indiceEquipo, 1);
      responsable_equipos.solicitar_eliminacion_equipo( id_equipo );

    };

    this.seleccionarEquipo = function ( equipo ) {
      this.equipoSeleccionado = equipo;
    };

    this.click_modificar_equipo = function( equipo ) {
      responsable_equipos.solicitar_modificacion_equipo( equipo );
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

    this.obtener_encargado = function () {
      return responsable_equipos;
    }


  } ] );



} )();
