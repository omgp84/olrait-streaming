function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function getUrlParameter(sParam) {
  var sPageURL = decodeURIComponent(window.location.search.substring(1));
  var sURLVariables = sPageURL.split('&');
  var sParameterName;
  var i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');
    if (sParameterName[0] === sParam) {
      return sParameterName[1] === undefined ? true : sParameterName[1];
    }
  }
};

function rainbow() {
    // This function generates vibrant, "evenly spaced" colours (i.e. no clustering). This is ideal for creating easily distinguishable vibrant markers in Google Maps and other apps.
    // Adam Cole, 2011-Sept-14
    // HSV to RBG adapted from: http://mjijackson.com/2008/02/rgb-to-hsl-and-rgb-to-hsv-color-model-conversion-algorithms-in-javascript
    var r, g, b;
    var h = Math.floor(Math.random() * 32) / 32;
    var i = ~~(h * 6);
    var f = h * 6 - i;
    var q = 1 - f;
    switch(i % 6){
        case 0: r = 1; g = f; b = 0; break;
        case 1: r = q; g = 1; b = 0; break;
        case 2: r = 0; g = 1; b = f; break;
        case 3: r = 0; g = q; b = 1; break;
        case 4: r = f; g = 0; b = 1; break;
        case 5: r = 1; g = 0; b = q; break;
    }
    var c = "#" + ("00" + (~ ~(r * 255)).toString(16)).slice(-2) + ("00" + (~ ~(g * 255)).toString(16)).slice(-2) + ("00" + (~ ~(b * 255)).toString(16)).slice(-2);
    return (c);
}

var connection = new RTCMultiConnection();
var usuario = getCookie('usuario');
var canal = getUrlParameter('canal');
var chatContainer = document.getElementById('salida-chat');
var streamid = '';

$('#reproductor-compartir-url').val(location.protocol + '//' + location.host + location.pathname + '?canal=' + canal);

connection.videosContainer = document.getElementById('videos-container');
connection.onmessage = appendDIV;
connection.socketURL = 'https://localhost:9001/';
connection.socketMessageEvent = 'olrait-msg';
connection.sessionid = usuario;
connection.usuario = usuario;
connection.token = getCookie('token');;
connection.canal = canal;
connection.color = rainbow(32, 8);
connection.autoCloseEntireSession = true;
connection.session = {
  screen: false,
  audio: true,
  video: true,
  data: true,
  oneway: true,
};

connection.onstream = function(event) {
  connection.videosContainer.appendChild(event.mediaElement);
  event.mediaElement.play();
  $('#mute, #stop, #unmute, #videos-container').removeClass('hidden');
  $('#caja-video #reproductor-video-placeholder').addClass('hidden');
  $('#formulario-editar-canal').removeClass('in');
  setTimeout(function() {
    event.mediaElement.play();
  }, 5000);
  if (event.type == 'local') {
    streamid = event.streamid;

    document.getElementById('mute').addEventListener('click', function(e) {
      connection.streamEvents[streamid].stream.mute('both');
    });
    document.getElementById('unmute').addEventListener('click', function(e) {
      connection.streamEvents[streamid].stream.unmute('both');
    });
    document.getElementById('stop').addEventListener('click', function(e) {
      connection.streamEvents[streamid].stream.stop();
      connection.videosContainer.innerHTML = '';
    });

    $.ajax({
      url : "./ajax/generartoken.php",
      type: "POST",
      data : {token: connection.token, usuario: usuario}
    })
    .done(function(data) {
      if(data != false) {
        console.info("Se ha regenerado el token");
        setCookie('token', data, 1);
      } else {
        console.error("Ocurrió un problema al regenerar el token");
      }
    })
    .fail(function(data) {
      console.error("Ocurrió un problema al regenerar el token");
    });
  }
};

connection.onleave = connection.onstreamended = function(e) {
  if (e.userid == canal) {
    $('#videos-container').addClass('hidden');
    $('#caja-video video').removeClass('hidden');
    $('#formulario-editar-canal').addClass('in');
  }
}

function setStreamerMediaConstraints() {
  connection.sdpConstraints.mandatory = {
    OfferToReceiveAudio: true,
    OfferToReceiveVideo: true
  };
  var tipoStreaming = document.getElementById('tipo-streaming').value;
  switch (tipoStreaming) {
    case '1':
      connection.session = { audio: true, video: false, data: true, screen: false, oneway: true };
      connection.mediaConstraints = { audio: true, video: false };
      break;
    case '2':
      connection.session = { audio: false, video: true, data: true, screen: false, oneway: true };
      connection.mediaConstraints = { audio: false, video: true };
      break;
    case '3':
      connection.session = { audio: true, video: true, data: true, screen: false, oneway: true };
      connection.mediaConstraints = { audio: true, video: true };
      break;
    case '4':
      connection.session = { audio: true, video: false, data: true, screen: true, oneway: true };
      break;
    case '5':
      emitirDesdeArchivo();
      break;
  }
}

function emitirDesdeArchivo() {
  alert('Emitir desde archivo es una tecnología experimental y puede que no funcione, recomendamos utilizar la última versión de Firefox');
  if (DetectRTC.isVideoSupportsStreamCapturing !== true) {
    oldBrowserDetected();
  }
  connection.dontCaptureUserMedia = true;
  connection.session = { audio: true, video: true, oneway: true };
  var selector = new FileSelector();
  selector.selectSingleFile(function(archivo) {
    if (archivo.name.search(/.webm|.mp3|.wav|.ogg/g) === -1) {
      $('#reproductor-error-emision').html('Por favor, seleccione un archivo compatible (webm, mp3, ogg o wav) o elija otro tipo de emisión').removeClass('hidden');
      return;
    }
    var video = document.createElement('video');
    video.src = URL.createObjectURL(archivo);
    setTimeout(function() {
      try {
        if ('captureStream' in video) {
          connection.preRecorededStream = video.captureStream();
        }
        else if ('mozCaptureStream' in video) {
          connection.preRecorededStream = video.mozCaptureStream();
        }
        else if ('webkitCaptureStream' in video) {
          connection.preRecorededStream = video.webkitCaptureStream();
        }
      }
      catch (e) {
        connection.preRecorededStream = null;
      }
      if (!connection.preRecorededStream) {
        oldBrowserDetected();
        return;
      }
      video.play();

      // attach pre-recorded steam
      connection.attachStreams.push(connection.preRecorededStream);
      connection.onstream({
        userid: connection.userid,
        extra: connection.extra,
        type: 'local',
        stream: connection.preRecorededStream,
        mediaElement: video
      });
      connection.openOrJoin(canal);
    }, 500);
  });
}

function oldBrowserDetected() {
  if(DetectRTC.browser.name == 'Chrome' && DetectRTC.browser.version >= 53) {
    $('#reproductor-error-emision').html('Por favor, la opción: <a href="chrome://flags/#enable-experimental-web-platform-features">chrome://flags/#enable-experimental-web-platform-features</a>').removeClass('hidden');
  } else {
    $('#reproductor-error-emision').html('Su navegador no soporta este tipo de streaming.').removeClass('hidden');
  }
}

if (getUrlParameter('accion') == 'emitir') {
  document.getElementById('boton-emision').addEventListener('click', function(e) {
    setStreamerMediaConstraints();
    connection.openOrJoin(connection.usuario);
  });
} else {
  connection.checkPresence(canal, function(isRoomExist, roomid) {
    if (isRoomExist) {
      connection.mediaConstraints = { audio: false, video: false };
      connection.openOrJoin(canal, function(isRoomExists, roomid) {
        $('#videos-container').removeClass('hidden');
        $('#caja-video video').addClass('hidden');
      });
    }
  });
}

/* Evento para manejar el input del chat */
document.getElementById('entrada-chat').onkeyup = function(e) {
  if (e.keyCode != 13) return;
  this.value = this.value.replace(/^\s+|\s+$/g, '');
  if (!this.value.length) return;
  connection.send('<strong style="color: ' + connection.color + '">' + usuario + '</strong>: ' + this.value);
  appendDIV('<strong style="color: ' + connection.color + '">' + usuario + '</strong>: ' + this.value);
  this.value = '';
};

/* Función que añade los mensajes a la caja del chat */
function appendDIV(event) {
  var div = document.createElement('div');
  div.innerHTML = event.data || event;
  chatContainer.appendChild(div);
  div.tabIndex = 0;
  div.focus();
  document.getElementById('entrada-chat').focus();
}

function showRoomURL(roomid) {
  var urlCanal = '?canal=' + roomid;
  var html = '<h2>Comparte tu canal:</h2><br>';
  html += 'Dirección de tu canal <a href="' + urlCanal + '" target="_blank">' + window.location + urlCanal + '</a>';
  var roomURLsDiv = document.getElementById('compartir-canal');
  roomURLsDiv.innerHTML = html;
  roomURLsDiv.style.display = 'block';
}

(function() {
  var params = {},
  r = /([^&=]+)=?([^&]*)/g;
  function d(s) {
    return decodeURIComponent(s.replace(/\+/g, ' '));
  }
  var match, search = window.location.search;
  while (match = r.exec(search.substring(1)))
  params[d(match[1])] = d(match[2]);
  window.params = params;
})();
