<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("./modelos/conexion.php");
include_once("./lib/functions.php");

accesoSoloUsuariosRegistrados("./index.php");

/*
Título de la ventana ()<title></title>).
Si se deja vacio se utilizará el valor predeterminado de master.php
*/
$tituloHTML = "Olrait! Streaming - Reproductor";

/*
Clase para el body. Opcional, dejar vacio si no se necesita.
*/
$claseBody = "pag-reproductor";

/* AQUÍ VA EL MODELO */


/* AQUÍ VA LA LÓGICA PHP */

/* ESTA FUNCIÓN OBTIENE TODOS A LOS USUARIOS EN BASE A SU ID */
function obtenerUsuarioPorNombreUsuario($canal) {
  $usuarios = hacerListado("SELECT * FROM usuarios WHERE nombre_usuario='$canal'");
  return (count($usuarios) <= 0) ? false : $usuarios[0];
}

function obtenerCategorias(){
  $categorias = hacerListado("SELECT * FROM categorias");
  return (count($categorias) <= 0) ? false : $categorias;
}

/* PARA PODER MOSTRAR LOS USUARIOS SEGÚN LA CATEGORÍA DE CADA UNO DE ELLOS */
function mostrarUsuarioPorCategoriaId($canal){
  return hacerListado("SELECT * FROM usuarios where id_categoria = '$canal'");
}

function obtenerImagenCanalUsuarioPorId($canal){
  $usuario = hacerListado("SELECT id,imagen_canal FROM usuarios WHERE nombre_usuario='$canal'")[0];
  if (!empty($usuario["imagen_canal"])) {
    return "./img/usuarios/" . $usuario["id"] . "/img_canal/" . $usuario["imagen_canal"];
  } else {
    return "./img/usuarios/default_canal.jpg";
  }
}

$canal = (!empty($_GET["canal"])) ? $_GET["canal"] : false;
$grupo = (!empty($_SESSION["usuario"]["grupo"])) ? $_SESSION["usuario"]["grupo"] : 9000;
$categorias = obtenerCategorias();
$usuario = obtenerUsuarioPorNombreUsuario($canal);
$imagenCanalUsuario = obtenerImagenCanalUsuarioPorId($canal);
$usuarios = mostrarUsuarioPorCategoriaId($canal);

ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */
.imagen-canal-reproductor {
  max-width: 100%;
  max-height: 100%;
}

.btn-emision {
  background-color: #3AD3CD;
  width: 70%;
}

.btn-emision:hover {
  background-color: #7FFFD6;
}

#caja-video video, #caja-video audio {
  width: 100%;
  height: 480px;
  background-color: #000;
}

.salida-chat {
  background-color: #FFFFFF;
  max-height: 100%;
  max-width: 100%;
  height: 445px;
  color: black;
  overflow-y: auto;
  overflow-x: hidden;
  padding: 10px;
}

#form-actualizar-canal {
  margin-bottom:  20px;
  padding-bottom: 20px;
  color: rgb(10,52,66);
  background-color:   #f5f5f5;
  border-radius: 12px 12px 0px 0px;
}

#img-canal-preview {
  height: 154px;
  margin-bottom: 0;
}

#me-gusta {
  margin-top: 20px;
  margin-bottom: 10px;
}

.grupo-reproduccion button {
  width:205px;
}

.cabeza-edicion {
  padding-top: 10px;
  border-radius: 12px 12px 0px 0px;
  color: rgb(10,52,66);
  background-color:   #f5f5f5;
}

#reproductor-info-canal {
  margin-top: 15px;
  color: #000;
}

#reproductor-info-canal h1, #reproductor-info-canal #me-gusta {
  margin-top: 0;
}

</style>

<script defer src="./js/socket.io.js" type="text/javascript"></script>
<script defer src="./js/RTCMultiConnection.js" type="text/javascript"></script>
<script defer src="./js/reproductor.js" type="text/javascript"></script>
<script src="./js/FileBufferReader.js"></script>

<?php if ($grupo <= 3 && $_SESSION["usuario"]["nombre_usuario"] == $_GET["canal"]): ?>

  <!--EN ESTE COL SE INTRODUCEN LOS DATOS DEL CANAL, ASÍ COMO EL FORMULARIO (OCULTO) DE EDICIÓN DEL MISMO.-->
  <div id="formulario-editar-canal" class="collapse in container">
    <form method="post" enctype="multipart/form-data" id="form-actualizar-canal">
      <input type="hidden" id="id" name="id" value="<?= $usuario["id"] ?>">
      <input type="hidden" name="emitiendo" value="0" id="emitiendo">

      <h1 class="text-center cabeza-edicion">Edita tu canal</h1>

      <div class="col-md-12">
        <p class="alert alert-danger hidden" id="reproductor-error-emision"></p>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label for="titulo">Título</label>
          <input type="text" id="titulo-canal" name="titulo_canal" class="form-control" placeholder="<?= $usuario["titulo_canal"] ?>" value="<?= $usuario["titulo_canal"] ?>">
        </div>

        <div class="form-group">
          <label for="categorias">Categoría</label>
          <select name="id_categoria" class="form-control" id="categoria-canal">

            <?php
            foreach ($categorias as $categoria) {
              echo '<option value="' . $categoria['id'] . '">' . $categoria["nombre"] . '</option>';
            }
            ?>

          </select>
        </div>

        <div class="form-group">
          <label for="tipo-streaming">Tipo de emisión</label>
          <select id="tipo-streaming" class="form-control">
            <option value="1">Audio</option>
            <option value="2">Video</option>
            <option value="3">Audio y video</option>
            <option value="4">Pantallaudio</option>
            <option value="5">Emitir archivo</option>
          </select>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="descripcion">Descripción</label>
          <textarea rows="8" name="descripcion_canal" class="form-control" id="descripcion-canal" placeholder="<?= $usuario["descripcion_canal"] ?>"><?= $usuario["descripcion_canal"] ?></textarea>
        </div>
      </div>

      <div class="col-md-2 text-center">
        <label for="input-img-canal-preview">
          <div class="text-left">
            <label for="">Imagen</label>
          </div>
          <div>
            <img src="<?= $imagenCanalUsuario ?>" class="img-responsive thumbnail" id="img-canal-preview" onchange="previewFile()">
          </div>
          <div class="text-center">Click para cambiar</div>
          <input type="file" name="imagen" id="input-img-canal-preview" class="hidden">
        </label>
      </div>

      <div class="row">
        <div class="col-md-12 col-lg-12 text-center">
          <button type="button" class="btn btn-default btn-emision" id="boton-emision">Emitir</button>
          <div class="clearfix"></div>
        </div>
      </div>
    </form>
  </div>

<?php endif; ?>

<div class="container">
  <div class="row">
    <!-- REPRODUCTOR -->
    <div class="col-md-8">
      <div id="caja-video">
        <video poster="./img/logos/pulpo1.png" controls="controls" id="reproductor-video-placeholder"></video>
        <div id="videos-container" class="videos-container img-responsive hidden"></div>
      </div>
    </div>
    <!-- CAJA DE CHAT -->
    <div class=" col-md-4">
      <div id="salida-chat" class="salida-chat"></div>
      <input type="text" id="entrada-chat" class="form-control" placeholder="Introduce aquí tu mensaje">
    </div>
  </div>
  <!-- CAJA DE DESCRIPCIÓN -->
  <?php if ($_SESSION['usuario']['nombre_usuario'] == $canal): ?>
  <div class="row">
    <div class="col-md-12">
      <div class="btn-group btn-group-justified grupo-reproduccion" role="group">
        <div class="btn-group" role="group">
          <button id="stop" class="btn btn-danger hidden">Stop</button>
        </div>
        <div class="btn-group" role="group">
          <button id="mute" class="btn btn-warning hidden">Mute</button>
        </div>
        <div class="btn-group" role="group">
          <button id="unmute" class="btn btn-success hidden">Unmute</button>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <div class="well" id="reproductor-info-canal">
    <div class="row">
      <div class="col-md-2">
        <img src="<?= $imagenCanalUsuario ?>" alt="" class="img-responsive thumbnail">
        <a href="./verperfil.php?usuario=<?= $usuario["id"] ?>" class="btn btn-info btn-block">Ver perfil</a>
      </div>
      <div class="col-md-10">
        <div class="row">
          <div class="col-md-12">
            <div class="pull-left">
              <h1 class="titulo-perfil-ver" id="titulo-perfil-ver">Estas viendo a <?= $usuario["titulo_canal"]; ?> </h1>
            </div>
            <div class="pull-right">
              <button class="btn btn-info" id="btn-gusta"><span id="numero-votos">
                <?=$usuario["votos"]; ?></span> Me gusta <span class="glyphicon glyphicon-thumbs-up"></span>
              </button>
              <button type="button" class="btn btn-success" id="reproductor-compartir-btn">Compartir <span class="glyphicon glyphicon-share-alt"></span></button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group" id="reproductor-compartir-canal">
              <input type="text" value="" class="form-control hidden" id="reproductor-compartir-url">
            </div>
            <p id="reproductor-descripcion-canal"><?= $usuario["descripcion_canal"] ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- LISTA DE LOS USUARIOS QUE APARECEN SEGÚN LA CATEGORIA -->
    <!-- ESTA LISTA ES TOTALMENTE INCREMENTAL, ES DECIR, AUMENTA CON NUEVOS USUARIOS -->
    <div class="col-md-2 usuarios-misma-categoria">

      <?php foreach ($usuarios as $usuario):
        if ($usuario["id"] == $usuario["id"]):
          continue;
        else:
          ?>
          <div>
            <img src="./img/usuarios/<?= $usuario["id"] ?>/<?= $usuario["imagen_canal"] ?>" class="imagen-canal.reproductor img-responsive">
            <h3><a href="./perfilver.php?id=<?=$_GET["usuario"] ?>"><?= $usuario["titulo_canal"] ?></a></h3>
          </div>
        <?php endif; endforeach;?>

      </div>
    </div>
  </div>

  <script defer type="text/javascript">
  /*AQUÍ VA EL JAVASCRIPT */

  $(function(){
    /* LA SIGUIENTE FUNCIÓN JQUERY DESABILITA EL BOTÓN DE EDICIÓN DE LOS CANALES DE STREAMING MIENTRAS EL BOTÓN
    DE EMISIÓN ESTÉ ACTIVO. EN CASO DE QUE SE VUELVA A PULSAR EL BOTÓN DE EMISIÓN (CERRANDO LA EMISIÓN) EL
    BOTÓN QUE ABRE EL FORMULARIO DE EDICIÓN SE HABILITA*/

    $('#input-img-canal-preview').change(function(e) {
      var preview = document.getElementById('img-canal-preview');
      var file    = document.getElementById('input-img-canal-preview').files[0];
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

    $('#boton-emision, #stop').click(function(evento) {
      $('#emitiendo').val() == 0 ? $('#emitiendo').val('1') : $('#emitiendo').val('0');
      var f = $(this);
      var datosFormulario = new FormData(document.getElementById('form-actualizar-canal'));
      $.ajax(
        {
          url : "./ajax/editarcanal.php",
          type: "POST",
          dataType: "html",
          data : datosFormulario,
          cache: false,
          contentType: false,
          processData: false
        })
        .done(function(data) {
          if(data != false) {
            $('#canal').html($("#titulo-canal").val());
            $('#descripcion').html($("#descripcion-canal").val());
            $('#titulo-perfil-ver').html("Estas viendo a " + $("#titulo-canal").val());
            $('#reproductor-descripcion-canal').html($("#descripcion-canal").val());
            console.info("Información del canal actualizada");
          }
        })
        .fail(function(data) {
          console.error("Error al actualizar la información del canal");
        });
      });

      $('#btn-gusta').click(function(evento){
        $(this).prop( "disabled", true );
        var votos = parseInt($('#numero-votos').html(), 10);
        votos = votos + 1;
        var id = $('#id').val();

        $.ajax({
          url : "./ajax/editarcanal.php",
          type: "POST",
          data : { votos: votos, id: id }
        })
        .done(function(data) {
          if(data != false) {
            $('#numero-votos').html(votos);
            console.info("Voto añadido correctamente");
          }
        })
        .fail(function(data) {
          console.error("Error al añadir el voto");
        });
      });
    });

    $('#reproductor-compartir-btn').click(function(e) {
      $('#reproductor-compartir-url').removeClass('hidden').select();
    });

    </script>

    <?php
    /* NO TOCAR ESTO */
    $contenidoPagina = ob_get_clean();
    include_once("./master.php");
    ?>
