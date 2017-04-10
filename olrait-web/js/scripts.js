/**********************************************
¡NO TOCAR! Si necesitáis añadir algo decidmelo
**********************************************/

// Mostrar modal compatible con formularios y otros elementos
function mostrarModal(id, titulo, contenido) {
  $('.olrait-modal').prop('id', id);
  $('.olrait-modal .modal-title').html(titulo);
  $('.olrait-modal .modal-body').load(contenido);
  $('#' + id).modal('toggle');
}

// Mostrar modal que solo contiene información en texto plano
function mostrarModalInfo(id, tipo, contenido) {
  $('.olrait-modal-info').prop('id', id);
  $('.olrait-modal-info .modal-body').html(contenido);
  document.getElementById('olrait-modal-info-dialog').className = 'modal-dialog alert ' + tipo;
  $('#' + id).modal('toggle');
}

function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

$(function() {
  // Mostrar modal de registro desde la navbar
  $('.registro-btn-navbar, .landing-registro-btn').click(function(e) {
    mostrarModal("modal-registro", "Registro", "modals/registro/index.php");
  });

  // Cerrar sesión de usuario desde la navbar
  $('#salir-navbar').click(function(e) {
    var url = 'salir.php';
    var destino = 'index.php';
    // Cambia las rutas si el evento procede del panel de administración
    if ($(this).data('location') == "administracion") {
      url = '../salir.php';
      destino = '../index.php';
    }
    $.ajax({
      url: url,
      type: 'POST'
    }).done(function() {
      window.location = destino;
    }).fail(function() {
      console.error('Error al cerrar la sesión de usuario');
    });
  });
});
