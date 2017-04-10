<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("../modelos/conexion.php");
include_once("../lib/functions.php");
include_once("./registro/registro.php");

accesoSoloAdmins("../index.php");

/*
Título de la ventana (<title></title>).
Si se deja vacio se utilizará el valor predeterminado de master.php
*/
$tituloHTML = "";

/*
Clase para el body. Opcional, dejar vacio si no se necesita.
*/
$claseBody = "";

/* AQUÍ VA EL MODELO */



/* AQUÍ VA LA LÓGICA PHP */



ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */
#img-registrar-usuario, #img-canal-registrar-usuario {
  width: 100px;
  height: 100px;
}

#formulario-registro-admin {
  background-color: #f5f5f5;
  color: rgb(10,52,66);
  padding: 20px;
}
</style>

<div class="container-fluid contenido-main">
  <!-- AQUÍ VA EL CONTENIDO -->
  <form class="modal-registro" method="POST" id="formulario-registro-admin">
    <div class="row">
      <div class="form-group col-md-6 text-center">
        <h1>Imagen de perfil</h1>
        <label for="input-img-registrar-usuario">
          <div><img src="../img/usuarios/default.png" id="img-registrar-usuario"></div>
          <div>Click para cambiar</div>
          <input type="file" name="imagen_perfil" id="input-img-registrar-usuario" class="hidden">
        </label>
      </div>
      <div class="form-group col-md-6 text-center">
        <h1>Imagen de canal</h1>
        <label for="input-img-canal-registrar-usuario">
          <div><img src="../img/usuarios/default.png" id="img-canal-registrar-usuario"></div>
          <div>Click para cambiar</div>
          <input type="file" name="imagen_canal" id="input-img-canal-registrar-usuario" class="hidden">
        </label>
      </div>
    </div>
    <div class="form-group">
      <label for="nombre-usuario">Nombre de usuario</label>
      <input type="text" class="form-control" id="nombre-usuario" name="nombre_usuario" placeholder="Nombre de usuario">
    </div>
    <div class="form-group">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre-registro" name="nombre" placeholder="Nombre">
    </div>
    <div class="form-group">
      <label for="correo">Correo electrónico</label>
      <input type="email" class="form-control" id="correo-registro" name="correo" placeholder="Correo electrónico">
    </div>
    <div class="form-group">
      <label for="contrasena">Contraseña</label>
      <input type="password" class="form-control" id="contrasena-registro" name="contrasena" placeholder="Contraseña">
    </div>
    <div class="form-group">
      <label for="verifica-contrasena-registro">Verifica la contraseña</label>
      <input type="password" class="form-control" id="verifica-contrasena-registro" name="verifica_contrasena" placeholder="Contraseña">
    </div>
    <div class="form-group col-md-12">
      <label for="descripcion">Descripción</label>
      <div>
        <textarea name="descripcion" placeholder="Descripción del usuario" rows="7" class="form-control" id="descripcion-registro">
        </textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="titulo_canal">Titulo canal</label>
      <input type="text" class="form-control" id="titulo-canal-registro" name="titulo_canal" placeholder="Título del canal">
    </div>
    <div class="form-group col-md-12">
      <label for="descripcion_canal">Descripción canal:</label>
      <div>
        <textarea name="descripcion_canal" placeholder="Descripción del canal" rows="7" class="form-control" id="descripcion-canal">
        </textarea>
      </div>
    </div>
    <div class="form-group">
      <label for="tipo-usuario">Tipo de usuario</label>
      <select name="grupo" class="form-control" id="tipo-usuario">
        <option value="1">Administrador</option>
        <option value="2">Editor</option>
        <option value="3">Streamer</option>
        <option value="4">Espectador</option>
      </select>
    </div>
    <button type="submit" class="btn btn-default" id="registro-btn">Aceptar</button>
  </form>
</div>


<script type="text/javascript">

$('#registro-btn').click(function(evento) {
  var f = $(this);
  var datosFormulario= new FormData(document.getElementById('formulario-registro-admin'));

  $.ajax({
    url : "registro/registro.php",
    type: "POST",
    data : datosFormulario,
    cache: false,
    contentType: false,
    processData: false
  })
  .done(function(data) {
    if(data.error != false) {
      //window.location="../canales.php";
    } else {
      alert("Error al registrar al nuevo usuario");
    }
  })
  .fail(function(data) {
    alert( "Error al registrar al nuevo usuario" );
  });
});


$('#input-img-canal-registrar-usuario').change(function(e) {
  var preview = document.getElementById('img-canal-registrar-usuario');
  var file    = document.getElementById('input-img-canal-registrar-usuario').files[0];
  var reader  = new FileReader();
  reader.onloadend = function () {
    preview.src = reader.result;
  }
  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
});

$('#input-img-registrar-usuario').change(function(e) {
  var preview = document.getElementById('img-registrar-usuario');
  var file    = document.getElementById('input-img-registrar-usuario').files[0];
  var reader  = new FileReader();
  reader.onloadend = function () {
    preview.src = reader.result;
  }
  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
});
</script>

<?php
/* NO TOCAR ESTO */
$contenidoPagina = ob_get_clean();
include_once("./master.php");
?>
