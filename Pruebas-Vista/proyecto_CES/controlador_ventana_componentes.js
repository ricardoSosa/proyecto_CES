$( document ).ready( function() {


var ventana = new Ventana_Componentes();
var controlador_ventana = new Controlador_Ventana_Componentes( ventana );


ventana.boton_enviar.on( "click", function() {

  var datos_correctos = controlador_ventana.validar_campos_ventana();

  if ( datos_correctos ) {
    var datos_componente = controlador_ventana.obtener_datos_componente();
    controlador_ventana.enviar_datos_componente( datos_componente );

  } else {
    controlador_ventana.notificar_mensaje_error();
  }
} );


} );

function Ventana_Componentes() {
  this.campo_nombre_comp = $( '#nombre-componente' );
  this.campo_tiempo_vida_comp = $( '#vida-max-componente' );
  this.campo_info_comp = $( '#info-componente' );
  this.boton_enviar = $( '#btn-enviar' );
  this.mensaje_error = $( '.error' );
}

//------------------------------------------------------------------------------
// CLASE CONTROLADOR VENTANA COMPONENTES
//
// Esta clase contiene todo lo relacionado al manejo de la ventana componentes
//------------------------------------------------------------------------------

function Controlador_Ventana_Componentes( ventana ) {
  this.ventana = ventana;

  this.validar_campos_ventana = function() {
    var datos_correctos = false;

    if ( ( ventana.campo_nombre_comp.val() != '' ) &&
         ( ventana.campo_tiempo_vida_comp.val() != '' ) &&
         ( ventana.campo_info_comp.select() != '' ) ) {
           datos_correctos = true;
    } else {
      datos_correctos = false;
    }

    return datos_correctos;
  }

  this.notificar_mensaje_error = function() {
    ventana.mensaje_error.text( 'Datos incorrectos.' );
  }

  this.obtener_datos_componente = function() {
    var nombre_componente = ventana.campo_nombre_comp.val();
    var tiempo_vida_max = ventana.campo_tiempo_vida_comp.val();
    var info_componente = ventana.campo_info_comp.val();

    var datos_componente ={'id' : "id generico 12",
                           'nombre' : nombre_componente,
                           'descripcion' : info_componente,
                           'tiempo_vida_max' : tiempo_vida_max,
                           'tipo_elemento' : 'componentes'};

    return datos_componente;
  }

  this.enviar_datos_componente = function( datos_componente ) {
    $.ajax( {
      type : "POST",
      url : "Asignador_tareas.php",
      data : {tarea : "agregar",
              datos : datos_componente},
      success: function( data ) {
        console.log(data);
      },
      error: function() {
        console.log( 'No se ha podido completar la comunicación con el servidor.' );
      }
    } );
  }
}
