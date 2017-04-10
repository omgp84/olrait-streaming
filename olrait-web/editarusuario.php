<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("./modelos/conexion.php");
include_once("./lib/functions.php");
accesoSoloUsuariosRegistrados('./index.php');
/*
Título de la ventana ()<title></title>).
Si se deja vacio se utilizará el valor predeterminado de master.php
*/
$tituloHTML = "";

/*
Clase para el body. Opcional, dejar vacio si no se necesita.
*/
$claseBody = "";

/* AQUÍ VA EL MODELO */


/* Obtenemos las imagenes del usuario tanto de la base de datos como de la carpeta */
function obtenerImagenPerfilPorIdUsuario($id) {
  $imagenes = hacerListado("SELECT imagen_perfil FROM usuarios WHERE id='$id'");
  $fichero = "./img/usuarios/" . $id . "/" . "img_perfil/";
  if (!empty($imagenes[0]["imagen_perfil"]) && file_exists($fichero . $imagenes[0]["imagen_perfil"])) {
    return $fichero . $imagenes[0]["imagen_perfil"];
  } else {
    return "./img/usuarios/default.png";
  }
}

function obtenerImagenCanalPorIdUsuario($id) {
  $imagenes = hacerListado("SELECT imagen_canal FROM usuarios WHERE id='$id'");
  $fichero = "./img/usuarios/" . $id . "/" . "img_canal/";
  if (!empty($imagenes[0]["imagen_canal"]) && file_exists($fichero . $imagenes[0]["imagen_canal"])) {
    return $fichero . $imagenes[0]["imagen_canal"];
  } else {
    return "./img/usuarios/default_canal.jpg";
  }
}

function guardarImagenPerfil($archivos, $idUsuario) {
  $path = "./img/usuarios/" . $idUsuario . "/img_perfil/";
  if (!is_dir($path)) mkdir($path, 0777, true);
  if (!empty(glob($path . "*"))) array_map('unlink', glob($path . "*"));
  $filePath = $path . basename($_FILES["imagen_perfil"]['name']);
  if (move_uploaded_file($archivos["imagen_perfil"]["tmp_name"], $filePath)) {
    $consulta = "UPDATE usuarios SET imagen_perfil='" .  $archivos["imagen_perfil"]["name"] . "' WHERE id='$idUsuario'";
    $imagenes = ejecutarConsulta($consulta);
  }
}

function guardarImagenCanal($archivos, $idUsuario) {
  $path = "./img/usuarios/" . $idUsuario . "/img_canal/";
  if (!is_dir($path)) mkdir($path, 0777, true);
  if (!empty(glob($path . "*"))) array_map('unlink', glob($path . "*"));
  $filePath = $path . basename($_FILES["imagen_canal"]['name']);
  if (move_uploaded_file($archivos["imagen_canal"]["tmp_name"], $filePath)) {
    $consulta = "UPDATE usuarios SET imagen_canal='" .  $archivos["imagen_canal"]["name"] . "' WHERE id='$idUsuario'";
    $imagenes = ejecutarConsulta($consulta);
  }
}

$idUsuario = (!empty($_GET["usuario"])) ? $_GET["usuario"] : false;

if ($idUsuario != $_SESSION['usuario']['id'] && $_SESSION['usuario']['grupo'] != 1) header('Location: portada.php');

function obtenerCategorias() {
  return hacerListado("SELECT * FROM categorias");
}

function obtenerUsuarioPorId($id) {
  $usuarios = hacerListado("SELECT * FROM usuarios WHERE id='$id'");
  return (count($usuarios) <= 0) ? false : $usuarios[0];
}

function consultaUpdate($datos, $tabla, $id) {
  // Quitar el campo verificar contraseña
  unset($datos["verificar_contrasena"]);
  foreach ($datos as $clave => $valor) {
    if ($clave == "contrasena") {
      $arr[] = "$clave='" . sha1($valor) . "'";
    } else {
      $arr[] = "$clave='$valor'";
    }
  }
  return "UPDATE $tabla SET " . implode(",", $arr) . " WHERE id=" . $id;
}

function editarUsuario($datos, $id) {
  $consulta = consultaUpdate($datos, "usuarios", $id);
  return ejecutarConsulta($consulta);
}

function comprobarNombreUsuario($nombre_usuario) {
  $consulta = "SELECT * FROM usuarios WHERE nombre_usuario='$nombre_usuario'";
  $listado = hacerListado($consulta);
  if (count($listado) == 0) {
    if (count(hacerListado("SELECT * FROM usuarios_pendientes WHERE nombre_usuario='$nombre_usuario'")) == 0) {
      return false;
    }
  }
  return true;
}

function comprobarCorreoUsuario($correo) {
  $consulta = "SELECT * FROM usuarios WHERE correo='$correo'";
  $listado = hacerListado($consulta);
  if (count($listado) == 0) {
    if (count(hacerListado("SELECT * FROM usuarios_pendientes WHERE correo='$correo'")) == 0) {
      return false;
    }
  }
  return true;
}

function comprobarErroresCliente($datos) {
  if (empty($datos["nombre_usuario"])) {
    return "Debe completar el nombre de usuario";
  }
  if ((comprobarNombreUsuario($datos["nombre_usuario"]) != false) && (($datos["nombre_usuario"] != $_SESSION["usuario"]["nombre_usuario"]) && ($_SESSION["usuario"]["grupo"] != 1))) {
    return "Ese nombre de usuario ya está registrado";
  }
  if (empty($datos["contrasena"])) {
    return "Debe completar la contraseña";
  }
  if ($datos["contrasena"] != $datos["verificar_contrasena"]) {
    return "Las contraseñas no coinciden";
  }
  if (empty($datos["nombre"])) {
    return "Debe completar el nombre";
  }
  if (empty($datos["correo"])) {
    return "Debe completar el correo electrónico";
  }
  if ((comprobarNombreUsuario($datos["correo"]) != false) && (($datos["correo"] != $_SESSION["usuario"]["correo"]) && ($_SESSION["usuario"]["grupo"] != 1))) {
    return "Ese correo electrónico ya está registrado";
  }
  if (empty($datos["titulo_canal"])) {
    return "Debe completar el titulo del canal";
  }
  return false;
}

/* AQUÍ VA LA LÓGICA PHP */

if (!empty($_FILES["imagen_perfil"]["name"]) && $idUsuario) {
  guardarImagenPerfil($_FILES, $idUsuario);
}

if (!empty($_FILES["imagen_canal"]["name"]) && $idUsuario) {
  guardarImagenCanal($_FILES, $idUsuario);
}

$mensajeValidacion = "";

// Comprobamos si hay datos por POST
if (!empty($_POST)) {
  $validacion = comprobarErroresCliente($_POST);
  if ($validacion !== false) {
    // Creamos un mensaje de error informando de que la validación ha fallado.
    $mensajeValidacion = "<p class='alert alert-danger'>" . $validacion . "</p>";
    $nombre_usuario = (!empty($_POST["nombre_usuario"])) ? $_POST["nombre_usuario"] : "";
    $contrasena = (!empty($_POST["contrasena"])) ? $_POST["contrasena"] : "";
    $nombre = (!empty($_POST["nombre"])) ? $_POST["nombre"] : "";
    $correo = (!empty($_POST["correo"])) ? $_POST["correo"] : "";
  } else {
    if (editarUsuario($_POST,  $_GET["usuario"])) {
      header ("Location: editarusuario.php?usuario=" . $_SESSION['usuario']['id']);
    } else {
      echo "Ha ocurrido un fallo al guardar el usuario.";
    }
  }
}

$imagenPerfil = obtenerImagenPerfilPorIdUsuario($_GET["usuario"]);
$imagenCanal = obtenerImagenCanalPorIdUsuario($_GET["usuario"]);
$usuario = obtenerUsuarioPorId($_GET["usuario"]);
$categorias = obtenerCategorias();

if (empty($usuario)) header('Location: portada.php');

ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */
#img-editar-usuario, #img-canal-editar-usuario {
  width: 100px;
  height: 100px;
}
</style>

<div class="container contenido-main">
  <!-- AQUÍ VA EL CONTENIDO -->
  <div class="row">
    <form enctype="multipart/form-data" method="POST" style="background-color: #f5f5f5; color: rgb(10,52,66); padding: 20px;">

      <?= $mensajeValidacion ?>

      <div class="form-group">
        <div class="row">
          <div class="form-group col-md-6 text-center">
            <h1>Imagen de perfil</h1>
            <label for="input-img-editar-usuario">
              <div><img src="<?=$imagenPerfil?>" id="img-editar-usuario"></div>
              <div>Click para cambiar</div>
              <input type="file" name="imagen_perfil" id="input-img-editar-usuario" class="hidden">
            </label>
          </div>
          <div class="form-group col-md-6 text-center">
            <h1>Imagen de canal</h1>
            <label for="input-img-canal-editar-usuario">
              <div><img src="<?=$imagenCanal?>" id="img-canal-editar-usuario"></div>
              <div>Click para cambiar</div>
              <input type="file" name="imagen_canal" id="input-img-canal-editar-usuario" class="hidden">
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="nombre_usuario">Nombre de usuario</label>
          <input type="text" name="nombre_usuario" class="form-control" id="nombre_usuario" placeholder="Nombre de usuario" value="<?=$usuario["nombre_usuario"]?>">
        </div>
        <div class="form-group">
          <label for="nombre-registro">Nombre</label>
          <input type="text" name="nombre" class="form-control" id="nombre-registro" placeholder="Nombre" value="<?=$usuario["nombre"]?>">
        </div>
        <div class="form-group">
          <label for="correo">Correo electrónico</label>
          <input type="email" name="correo" class="form-control" id="correo-registro" placeholder="Correo electrónico" value="<?=$usuario["correo"]?>">
        </div>
        <div class="row">
          <div class="form-group col-md-6">
            <label for="contrasena">Contraseña</label>
            <input type="password" name="contrasena" class="form-control" id="contrasena-registro" placeholder="Contraseña">
          </div>
          <div class="form-group col-md-6">
            <label for="verifica_contrasena-registro">Verifica la contraseña</label>
            <input type="password" name="verificar_contrasena" class="form-control" id="verifica-contrasena-registro" placeholder="Verficar contraseña">
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 form-group">
            <label for="titulo-canal">Título canal:</label>
            <input type="text" name="titulo_canal" value="<?= $usuario["titulo_canal"] ?>" class="form-control">
          </div>
          <div class="col-md-6 form-group">
            <label for="categoria-canal">Categoría del canal:</label>
            <select class="form-control" name="id_categoria">

              <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria["id"] ?>" <?= ($categoria["id"] == $usuario["id_categoria"]) ? "selected='selected'" : ""?>><?= $categoria["nombre"] ?></option>
              <?php endforeach; ?>

            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="descripcion-canal">Descripción del canal:</label>
          <textarea name="descripcion_canal" rows="8" class="form-control"><?= $usuario["descripcion_canal"] ?></textarea>
        </div>
        <div class="pull-right">
          <button type="submit" class="btn btn-primary btn-lg" id="registro-btn">Guardar</button>
          <a href="verperfil.php?usuario=<?= $usuario["id"] ?>" class="btn btn-danger btn-lg">Cancelar</a>
        </div>
        <div class="clearfix"></div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
/* AQUÍ VA EL JAVASCRIPT */
$('#input-img-editar-usuario').change(function(e) {
  var preview = document.getElementById('img-editar-usuario');
  var file    = document.getElementById('input-img-editar-usuario').files[0];
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

$('#input-img-canal-editar-usuario').change(function(e) {
  var preview = document.getElementById('img-canal-editar-usuario');
  var file    = document.getElementById('input-img-canal-editar-usuario').files[0];
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
