<form class="modal-registro" method="POST">
  <p class="alert alert-danger hidden" id="error-registro"></p>
  <div class="row">
    <div class="form-group col-md-6">
      <label for="nombre-usuario">Nombre de usuario</label>
      <input type="text" class="form-control" id="nombre-usuario" placeholder="Nombre de usuario" name="nombre_usuario">
    </div>
    <div class="form-group col-md-6">
      <label for="grupo-registro">Grupo:</label>
      <select class="form-control" name="grupo" id="grupo-registro">
        <option value="3">Streamer</option>
        <option value="4">Espectador</option>
      </select>
    </div>
  </div>
  <div class="row">
    <div class="form-group col-md-6">
      <label for="nombre">Nombre</label>
      <input type="text" class="form-control" id="nombre-registro" placeholder="Nombre">
    </div>
    <div class="form-group col-md-6">
      <label for="correo">Correo electrónico</label>
      <input type="email" class="form-control" id="correo-registro" placeholder="Correo electrónico">
    </div>
  </div>
  <div class="row">
    <div class="form-group col-md-6">
      <label for="contrasena">Contraseña</label>
      <input type="password" class="form-control" id="contrasena-registro" placeholder="Contraseña">
    </div>
    <div class="form-group col-md-6">
      <label for="verifica_contrasena-registro">Verifica la contraseña</label>
      <input type="password" class="form-control" id="verifica-contrasena-registro" placeholder="Contraseña">
    </div>
  </div>
  <div class="form-group">
    <label for="titulo-canal-registro">Título del canal:</label>
    <input type="text" name="titulo_canal" placeholder="Título del canal" class="form-control" id="titulo-canal-registro">
  </div>
  <div class="form-group">
    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" placeholder="Descripción del usuario" rows="3" id="descripcion-registro" class="form-control"></textarea>
  </div>
  <div class="pull-right">
    <button class="btn btn-default" id="registro-btn">Aceptar</button>
    <button type="submit" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
  </div>
  <div class="clearfix"></div>
</form>


<script type="text/javascript">

$('#registro-btn').click(function(evento) {
  evento.preventDefault();
  var nombre_usuario = $('#nombre-usuario').val();
  var nombre = $('#nombre-registro').val();
  var correo = $('#correo-registro').val();
  var contrasena = $('#contrasena-registro').val();
  var verifica_contrasena = $('#verifica-contrasena-registro').val();
  var descripcion_registro = $('#descripcion-registro').val();
  var titulo_canal = $('#titulo-canal-registro').val();
  var grupo = $('#grupo-registro').val();

  $.ajax(
    {
      url : "./modals/registro/registro.php",
      type: "POST",
      data : {
        nombre: nombre,
        nombre_usuario: nombre_usuario,
        correo: correo,
        contrasena: contrasena,
        verifica_contrasena: verifica_contrasena,
        descripcion: descripcion_registro,
        titulo_canal: titulo_canal,
        grupo: grupo
      }
    })
    .done(function(data) {
      data = JSON.parse(data);
      if (data.error == false) {
        $('#modal-registro').modal('hide');
        window.location = "registrocompletado.php";
      } else {
        $('#error-registro').html(data.error).removeClass('hidden');
        console.log(data.error);
      }
    })
    .fail(function(data) {
      alert("Algo salió mal al registrar al usuario");
    });
  });

  </script>
