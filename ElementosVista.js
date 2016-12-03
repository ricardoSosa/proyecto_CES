/**
 * Created by shado on 08/11/2016.
 */
( function () {
  var app = angular.module( 'elementos-vista', [] );


  app.directive( 'procesosLista', function () {
    return{
      restrict : "A",
      templateUrl : "procesos-lista.html"
    }
  } );

  app.directive( 'listaComponentes', function () {
    return{
      restrict : "A",
      templateUrl : "lista-componentes.html"
    }
  } );


 app.directive( 'listaEquipo', function () {
   return{
     restrict : "A",
     templateUrl : "lista-equipo.html"
   }
 } );

  app.directive( 'formEquipos', function () {
    return{
      restict : "A",
      templateUrl : "form-equipos.html"
    };
  } );

  app.directive( 'formProcesos', function () {
    return{
      restrict : "A",
      templateUrl : "form-procesos.html"
    };
  } );

  app.directive( 'eliminacionProcesos', function () {
    return{
      restrict : "A",
      templateUrl : "eliminacion-procesos.html"
    };
  } );

  app.directive( 'eliminacionEquipos', function () {
    return{
      restrict : "A",
      templateUrl : "eliminacion-equipos.html"
    };
  } );

  app.directive( 'modificacionProcesos', function () {
    return{
      restrict : "A",
      templateUrl : "modificacion-procesos.html"
    };
  } );

  app.directive( 'modificacionEquipos', function () {
    return{
      restrict : "A",
      templateUrl : "modificacion-equipos.html"
    }
  } );

  app.directive( 'formComponentes', function () {
    return{
      restrict : "A",
      templateUrl : "form-componentes.html"
    }
  } );

  app.directive( 'modificacionComponentes', function () {
    return{
      restrict : "A",
      templateUrl : "modificacion-componentes.html"
    }
  } );

  app.directive( 'eliminacionComponentes', function () {
    return{
      restrict : "A",
      templateUrl : "eliminacion-componentes.html"
    }
  } );

  app.directive( 'equiposDisponibles', function () {
    return{
      restrict : "A",
      templateUrl : "equipos-disponibles.html"
    }
  } );

  app.directive( 'procesosDisponibles', function () {
    return{
      restrict : "A",
      templateUrl : "procesos-disponibles.html"
    }
  } );

  app.directive( 'componentesDisponibles', function () {
    return{
      restrict: "A",
      templateUrl : "componentes-disponibles.html"
    }
  } );
} )();
