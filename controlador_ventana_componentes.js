$( document ).ready( function() {


var ventana = new Ventana_Componentes();
var controlador_ventana = new Controlador_Ventana_Componentes( ventana );


ventana.boton_enviar.on( "click", function() {
  var datos_correctos = controlador_ventana.validar_campos_ventana();

  if ( datos_correctos ) {
    controlador_ventana.enviar_datos_componente().
  } else {
    controlador_ventana.notificar_mensaje_error();
  }
} );


} );

function Ventana_Componentes() {
  this.campo_nombre_comp = $( '#nombre-componente' );
  this.campo_tiempo_vida_comp = $( '#vida-max-componente' );
  this.campo_info_comp = $( '#info-componete' );
  this.boton_enviar = $( '#btn-enviar' );
  this.mensaje_error = $( '.error' );
}

function Controlador_Ventana_Componentes( ventana ) {
  this.ventana = ventana;

  this.validar_campos_ventana = function() {
    var datos_correctos = false;

    if ( ( ventana.campo_nombre_comp.val() != '' ) &&
         ( ventana.campo_tiempo_vida_comp.val() != '' ) &&
         ( ventana.campo_info_comp.val() != '' ) ) {
           datos_correctos = true;
    } else {
      datos_correctos = false;
    }

    return datos_correctos;
  }

  this.notificar_mensaje_error = function() {
    ventana.mensaje_error.text( 'Datos incorrectos.' );
  }

  this.enviar_datos_componente = function() {
    
  }
}
