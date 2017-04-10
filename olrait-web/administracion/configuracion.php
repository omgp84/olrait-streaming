<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("../modelos/conexion.php");
include_once("../lib/functions.php");
accesoSoloAdmins('../portada.phps');

/*
Título de la ventana (<title></title>).
Si se deja vacio se utilizará el valor predeterminado de master.php
*/
$tituloHTML = "";

/*
Clase para el body. Opcional, dejar vacio si no se necesita.
*/
$claseBody = "pag-administracion";

/* AQUÍ VA EL MODELO */
function recuperarCfg($nombre) {
  return hacerListado("SELECT valor FROM config WHERE nombre='$nombre'")[0]['valor'];
}

/* AQUÍ VA LA LÓGICA PHP */
$facebook = recuperarCfg('facebook');

ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */
#admin-cfg-rrss, #admin-cfg-canales, #admin-cfg-slides {
  color: #000;
}

#admin-cfg-rrss h3, #admin-cfg-canales h3, #admin-cfg-slides h3 {
  margin-top: 0;
}
</style>

<!-- AQUÍ VA EL CONTENIDO, ESTÁ DENTRO DE UN COL-MD-10 -->
<div class="row">
  <div class="col-md-6">
    <div class="well" id="admin-cfg-rrss">
      <h3>Redes sociales <small>(footer)</small></h3>
      <form>
        <div class="form-group">
          <label for="" class="control-label">Facebook</label>
          <input type="text" class="form-control" placeholder="<?= (!empty($facebook)) ? $facebook : 'https://www.facebook.com/ejemplo' ?>" id="cfg-facebook-url">
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-primary btn-block guardar-cfg" id="cfg-facebook-btn">Guardar</button>
        </div>

        <div class="form-group">
          <label for="" class="control-label">Twitter</label>
          <input type="text" class="form-control" placeholder="http://www.twitter.com/ejemplo" id="cfg-twitter-url">
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-primary btn-block guardar-cfg" id="cfg-twitter-btn">Guardar</button>
        </div>

        <div class="form-group">
          <label for="" class="control-label">LinkedIn</label>
          <input type="text" class="form-control" placeholder="http://www.linkedin.com/ejemplo" id="cfg-linkedin-url">
        </div>
        <div class="form-group">
          <button type="button" class="btn btn-primary btn-block guardar-cfg" id="cfg-linkedin-btn">Guardar</button>
        </div>
        <div class="clearfix"></div>
      </form>
    </div>
  </div>

  <div class="col-md-6">
    <div class="well" id="admin-cfg-canales">
      <h3>Configuración subidas</h3>
      <form>

        <div class="form-group">
          <label for="" class="control-label">Emisión</label>
          <select class="form-control" id="cfg-emision-valor">
            <option value="0">Desactivada</option>
            <option value="1">Activada</option>
          </select>
        </div>
        <div class="form-group">
          <button type="button" name="button" class="btn btn-primary btn-block guardar-cfg" id="cfg-emision-btn">Guardar</button>
        </div>

        <div class="form-group">
          <label for="" class="control-label">Tamaño máximo</label>
          <div class="input-group">
            <input type="number" name="" value="" class="form-control" placeholder="Tamaño" min="1">
            <div class="input-group-addon">MB</div>
          </div>
        </div>
        <div class="form-group">
          <button type="button" name="button" class="btn btn-primary btn-block guardar-cfg">Guardar</button>
        </div>

        <div class="form-group">
          <label for="" class="control-label">Grupo mínimo</label>
          <select class="form-control" id="cfg-emision-grupo-valor">
            <option value="1">Administradores</option>
            <option value="2">Editores</option>
            <option value="3">Usuarios</option>
          </select>
        </div>
        <div class="form-group">
          <button type="button" name="button" class="btn btn-primary btn-block guardar-cfg" id="cfg-grupo-emision-btn">Guardar</button>
        </div>
        <div class="clearfix">
        </div>
      </form>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="well" id="admin-cfg-slides">
      <h3>Slides</h3>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>#</th>
            <th>Imagen</th>
            <th>Título</th>
            <th>Enlace</th>
            <th>Texto</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th class="text-center">1</th>
            <td class="text-center"><img src="../img/fondos/cuadrados.png" alt="" class="img-responsive" style="max-width: 200px;"></td>
            <td class="text-center"><input type="text" name="" value="Título 1" class="form-control"></td>
            <td class="text-center"><input type="text" name="" value="http://www.ejemplo.com" class="form-control"></td>
            <td class="text-center"><textarea name="name" rows="4" cols="40" class="form-control">Texto de ejemplo</textarea></td>
            <td class="text-center">
              <a href="#" class="btn btn-success btn-block">Actualizar</a>
              <a href="#" class="btn btn-danger btn-block">Borrar</a>
            </td>
          </tr>
          <tr>
            <th class="text-center">2</th>
            <td class="text-center"><input type="file" name="" value=""></td>
            <td class="text-center"><input type="text" name="" value="" placeholder="Título" class="form-control"></td>
            <td class="text-center"><input type="text" name="" value="" placeholder="http://www.ejemplo.com" class="form-control"></td>
            <td class="text-center"><textarea name="name" rows="4" cols="40" placeholder="Texto" class="form-control"></textarea></td>
            <td><a href="#" class="btn btn-success btn-block">Añadir</a></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript">
/* AQUÍ VA EL JAVASCRIPT */
$('#admin-cfg-rrss button').click(function(e) {
  e.preventDefault();
  var valor = "";
  var accion = "";
  switch (this.id) {
    case 'cfg-facebook-btn':
    valor = $('#cfg-facebook-url').val();
    accion = 'facebook';
    break;
    case 'cfg-twitter-btn':
    valor = $('#cfg-twitter-url').val();
    accion = 'twitter';
    break;
    case 'cfg-linkedin-btn':
    valor = $('#cfg-linkedin-url').val();
    accion = 'linkedin';
    break;
    case 'cfg-emision-btn':
    valor = $('#cfg-emision-valor').val();
    accion = 'emision';
    break;
    case 'cfg-emision-grupo-btn':
    valor = $('#cfg-emision-grupo-valor').val();
    accion = 'grupo_emision';
    break;
  }
  
  $.ajax({
    url: '../ajax/guardarconfig.php',
    type: 'POST',
    data: { accion: accion, valor: valor }
  })
  .done(function(data) {
    if (data != false) {
      mostrarModalInfo('cfg-msg-info', 'alert-success', 'La configuración se ha guardado correctamente.');
    } else {
      mostrarModalInfo('cfg-msg-info', 'alert-danger', 'Algo no salió bien.');
    }
  })
  .fail(function(data) {
    mostrarModalInfo('cfg-msg-info', 'alert-danger', 'Algo no salió bien.');
  })
});

</script>

<?php
/* NO TOCAR ESTO */
$contenidoPagina = ob_get_clean();
include_once("./master.php");
?>
