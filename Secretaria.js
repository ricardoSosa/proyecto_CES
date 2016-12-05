/**
 * Created by shado on 04/12/2016.
 */
( function () {
  var app = angular.module( 'Secretaria');

  app.factory('Secretaria', ['$http', function ($http) {
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

} )();
