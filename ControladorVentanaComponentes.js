/**
 * Created by shado on 17/11/2016.
 */
( function () {
  var app = angular.module( 'Componentes', [ 'elementos-vista' ] );

 app.service('Pra', function () {
   this.res = function (a) {
     console.log(a);
   };
 });

  app.factory( 'Secretaria', ['$http', function ($http) {
    function Secretaria() {
      console.log("Holi");
    };

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
  
  app.factory( 'Jefe_Planta', ['Secretaria', '$http' , function ( Secretaria, $http ) {
    var componentes_disponibles = [];
    function Jefe_Planta() {

      this.lista_componentes = componentes_disponibles;
      this.secretaria = new Secretaria();
    }

    Jefe_Planta.prototype.solicitar_creacion_componente = function ( datos_componente ) {
      var datos_validos = this.secretaria.verificar_datos_componente( datos_componente );

      if( datos_validos ) {
        var nombreComponente = datos_componente.nombre;
        var tiempoVidaMax = datos_componente.tiempo_vida_max;
        var descripcionComponente = datos_componente.descripcion;

        var componente = {"id" : "id_componente_" + (Math.floor((Math.random() * 1000) + 1)),
                          "nombre" : nombreComponente,
                          "tiempo_vida_max" : tiempoVidaMax,
                           "descripcion" : descripcionComponente};

        var datos_solicitud = {tarea : "agregar",
                               elemento: "componentes",
                               datos : componente};

        var solicitud = this.secretaria.generar_solicitud( datos_solicitud );
        this.secretaria.enviar_solicitud( solicitud );

        return componente;
      }
    }

    Jefe_Planta.prototype.solicitar_modificacion_componente = function ( nuevos_datos_componente ) {
      var datos_validos = this.secretaria.verificar_datos_componente( nuevos_datos_componente );

      if( datos_validos ) {
        var id_componente = nuevos_datos_componente.id;
        var nombre_componente = nuevos_datos_componente.nombre;
        var tiempo_vida = nuevos_datos_componente.tiempo_vida_max;
        var descripcion = nuevos_datos_componente.descripcion;

        var datos_modificacion = { id : id_componente,
                                   nombre : nombre_componente,
                                   tiempo_vida_max : tiempo_vida,
                                   descripcion : descripcion};

        var datos_solicitud = {tarea : "modificar",
                               elemento : "componentes",
                               datos : datos_modificacion};

        var solicitud = this.secretaria.generar_solicitud( datos_solicitud );

        this.secretaria.enviar_solicitud( solicitud );
      }
    }

    Jefe_Planta.prototype.solicitar_eliminacion_componente = function( id_componente ) {
      var componente = {id : {id : id_componente},
                        nombre_id : "id" //PENDIENTE
                       };

      var datos_solicitud = {tarea : "eliminar",
                             elemento : "componentes",
                             datos : componente};

      var solicitud = this.secretaria.generar_solicitud( datos_solicitud );


      this.secretaria.enviar_solicitud( solicitud );
    }

    Jefe_Planta.prototype.solicitar_lista_componentes = function () {
      var datos_solicitud = {tarea : "consultar lista",
        elemento : "componentes",
        datos : "consulta"};

      var solicitud = this.secretaria.generar_solicitud( datos_solicitud );

      var direccionDestino = 'Nuevos_cambios/Asignador_tareas.php';
      $http( {
        url : direccionDestino,
        method : "POST",
        data : solicitud,

      } ).success( function ( componentes ) {

        angular.forEach( componentes, function ( componente, key ) {
          componentes_disponibles.push( componente );
        } );
        console.log(componentes_disponibles);

      }  );
    }

    return Jefe_Planta;
  } ]);


  app.controller( 'ControladorVentanaComponentes', [  'Secretaria','Jefe_Planta','Pra', '$http' ,function (  Secretaria, Jefe_Planta, Pra, $http ) {
    //$http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    var secretaria = new Secretaria();
    var jefe_planta = new Jefe_Planta();

    /*this.obtener_secretaria = function (  ) {
      return secretaria;
    };*/

    this.obtener_jefe = function () {
      return jefe_planta;
    }




    var componentesSolicitud = [];
    this.listaComponentes = componentesSolicitud;
    this.componenteSeleccionado = {};

    //--------------------------------------
    var panel_componentes = "panel_lista_componentes";
    this.panel_actual = panel_componentes;


    this.click_agregar_componente = function( datosComponente ) {


      var nuevo_componente = jefe_planta.solicitar_creacion_componente( datosComponente );
      this.listaComponentes.push( nuevo_componente ); //DEBE IR UN NIVEL MAS ARRIBA


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

    this.click_eliminar_componente = function ( id_componente ) {

      var posicion_componente = this.buscar_posicion_componente( id_componente );

      this.listaComponentes.splice(posicion_componente, 1);

      jefe_planta.solicitar_eliminacion_componente( id_componente );


    };


    this.seleccionarComponente = function( componente ) {
      this.componenteSeleccionado = componente;
    };

    this.click_modificar_componente = function( componente ) { //REFACTORIZAR DESPUES
      jefe_planta.solicitar_modificacion_componente( componente );
    }





    //this.solicitarListaComponentes();
    jefe_planta.solicitar_lista_componentes();

    this.cambiar_panel = function ( nuevo_panel ) {
      this.panel_actual = nuevo_panel;
    };

    this.panel_seleccionado = function ( panel ) {
      var panel_activo = this.panel_actual == panel;
      return panel_activo;
    };


    
  } ] );
} )();