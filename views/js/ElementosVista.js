/**
 * Created by shado on 08/11/2016.
 */
( function () {
  var app = angular.module( 'elementos-vista', [] );


  app.directive( 'procesosLista', function () {
    return{
      restrict : "A",
      templateUrl : "../procesos/procesos-lista.html"
    }
  } );

  app.directive( 'listaComponentes', function () {
    return{
      restrict : "A",
      templateUrl : "../componentes/lista-componentes.html"
    }
  } );


 app.directive( 'listaEquipo', function () {
   return{
     restrict : "A",
     templateUrl : "../equipos/lista-equipo.html"
   }
 } );

  app.directive( 'formEquipos', function () {
    return{
      restict : "A",
      templateUrl : "../equipos/form-equipos.html"
    };
  } );

  app.directive( 'formProcesos', function () {
    return{
      restrict : "A",
      templateUrl : "../procesos/form-procesos.html"
    };
  } );

  app.directive( 'eliminacionProcesos', function () {
    return{
      restrict : "A",
      templateUrl : "../procesos/eliminacion-procesos.html"
    };
  } );

  app.directive( 'eliminacionEquipos', function () {
    return{
      restrict : "A",
      templateUrl : "../equipos/eliminacion-equipos.html"
    };
  } );

  app.directive( 'modificacionProcesos', function () {
    return{
      restrict : "A",
      templateUrl : "../procesos/modificacion-procesos.html"
    };
  } );

  app.directive( 'modificacionEquipos', function () {
    return{
      restrict : "A",
      templateUrl : "../equipos/modificacion-equipos.html"
    }
  } );

  app.directive( 'formComponentes', function () {
    return{
      restrict : "A",
      templateUrl : "../componentes/form-componentes.html"
    }
  } );

  app.directive( 'modificacionComponentes', function () {
    return{
      restrict : "A",
      templateUrl : "../componentes/modificacion-componentes.html"
    }
  } );

  app.directive( 'eliminacionComponentes', function () {
    return{
      restrict : "A",
      templateUrl : "../componentes/eliminacion-componentes.html"
    }
  } );

  app.directive( 'equiposDisponibles', function () {
    return{
      restrict : "A",
      templateUrl : "../equipos/equipos-disponibles.html"
    }
  } );

  app.directive( 'procesosDisponibles', function () {
    return{
      restrict : "A",
      templateUrl : "../procesos/procesos-disponibles.html"
    }
  } );

  app.directive( 'componentesDisponibles', function () {
    return{
      restrict: "A",
      templateUrl : "../componentes/componentes-disponibles.html"
    }
  } );

  app.directive( 'activacionProcesos', function () {
    return{
      restrict : "A",
      templateUrl : "../procesos/activacion-procesos.html"
    }
  } );

  app.directive( 'procesosActivos', function () {
    return{
      restrict : "A",
      templateUrl : "../procesos/procesos-activos.html"
    }
  } );
} )();
