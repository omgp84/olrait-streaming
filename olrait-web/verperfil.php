<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("modelos/conexion.php");
include_once("lib/functions.php");
accesoSoloUsuariosRegistrados("index.php");

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

//ESTA FUNCIÓN EXTRAE TODOS LOS DATOS DEL USUARIO EN LA TABLA USUARIOS, TENIENDO COMO REFERENCIA EL CAMBPO nombre_usuario

function obtenerDatosUsuarioPorId($id){
  $listado = hacerListado("SELECT * FROM usuarios where id='$id'");
  return (count($listado) <= 0)? false: $listado[0];
}

//DE ESTA FUNCIÓN EXTRAEMOS LA IMAGEN DEL USUARIO, SUPLIENDO ESTA POR UNA IMAGEN POR DEFECTO EN CASO DE QUE ESTE NO LO TENGA

function obtenerImagenUsuarioPorId($id){
  $imagen = hacerListado("SELECT * FROM usuarios where id = '$id'");
  $rutaImagen = "./img/usuarios/" . $id . "/img_perfil/";
  $imagenPorDefecto = "./img/usuarios/default.png";
  return $imagen = (!empty($imagen[0]["imagen_perfil"]))? $rutaImagen . $imagen[0]["imagen_perfil"]: $imagenPorDefecto;
}

//ESTA FUNCIÓN SE UTILIZARÁ PARA DESHABILITAR O NO EL BOTON DE ACCESO Y EL AVISO EN CASO DE QUE EL USUARIO ESTE EMITIENDO O NO

function comprobarEstadoConexion($id){
  $conexion = hacerListado("SELECT * FROM usuarios where id = '$id'");
  return (count($conexion) <= 0)? false: $conexion[0]["emitiendo"];
}

//AL IGUAL QUE CON LA IMAGEN DEL USUARIO, ESTA FUNCIÓN SERVIRÁ PARA EXTRAER LA IMAGEN DEL CANAL QUE TENGA EL USUARIO, ESTABLECIENDO UNA IMAGEN POR DEFECTO EN CASO DE QUE ESTE NO LA TENGA PARA SUC ANAL

function obtenerImagenCanalPorid($id){
  $imagen = hacerListado("SELECT * FROM usuarios where id='$id'");
  $rutaImagen  = "./img/usuarios/" . $id . "/img_canal/";
  $imagenPorDefecto = "./img/usuarios/default_canal.jpg";
  return (!empty($imagen[0]["imagen_canal"]) && file_exists($rutaImagen . $imagen[0]["imagen_canal"])) ? $rutaImagen . $imagen[0]["imagen_canal"] : $imagenPorDefecto;
}

//ESTA FUNCIÓN SIRVE PARA SABER LA CATEGORÍA DE LA CUAL FORME PARTE EL USUARIO Y SU CANAL

function mostrarCategoriaUsuario($id){
  $id_categoria = hacerListado("SELECT nombre FROM categorias WHERE id = '$id'");
  return (empty($id_categoria))? "Sin Categoria": $id_categoria[0]["nombre"];
}


/* AQUÍ VA LA LÓGICA PHP */

//A CADA VARIABLE SE LE ASIGNA LA FUNCION CORRESPONDIENTE

$datosUsuarioPerfilVer = obtenerDatosUsuarioPorId($_GET["usuario"]);
$imagenUsuarioPerfilVer = obtenerImagenUsuarioPorId($datosUsuarioPerfilVer["id"]);
$imagenCanalPerfilVer = obtenerImagenCanalPorId($datosUsuarioPerfilVer["id"]);
$categoriaUsuario = mostrarCategoriaUsuario($datosUsuarioPerfilVer["id_categoria"]);

/*****DESACTIVAR O ACTIVAR EL BOTON DE ACCESO EN FUNCIÓN DE SI EL USUARIO ESTÁ EMITIENDO O NO. LO MISMO CON MOSTRAR EL ESTADO DE EMISIÓN DEL USUARIO************/

//SE EJECUTA LA FUNCION
$comprobarEstadoConexion = comprobarEstadoConexion($datosUsuarioPerfilVer["id"]);
//ESTRUCTURA IF PARA SABER QUE ICONO AÑADIR
$estadoConexion = $comprobarEstadoConexion ? "glyphicon glyphicon-play perfil-icono perfil-icono-emitiendo-activo" : "glyphicon glyphicon-stop perfil-icono perfil-icono-emitiendo-inactivo";
//ESTRUCTURA IF PARA SABER SI SE AÑADE ENLACE O NO
$botonHRef = ($comprobarEstadoConexion ? "reproductor.php?canal=" . $_GET["usuario"] : "#");
//ESTRUCTURA IF PARA SABER SI SE DESACTIVA O NO EL BOTÓN DE ENLACE
$botonDisabled = ($comprobarEstadoConexion ? "": "disabled = 'disabled'");



ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */

#perfil-boton-canal {
  margin-top: 25px;
}

.perfil-icono-emitiendo-activo{
  color: #0f0;
}

.perfil-icono-emitiendo-inactivo {
  color: #f00;
}

#perfil-info-usuario {
  border-radius: 5px 0 0 5px;
  padding-bottom: 20px;
}

#perfil-contenido {
  border-radius: 5px;
  background-color: #5bc0de;
  color: rgb(10,52,66);
}

#perfil-imagen-usuario {
  background-color: #FFF;
  display: block;
  margin: 0 auto;
}

#perfil-info-canal {
  background-color: #f5f5f5;
  min-height: 300px;
  padding-bottom: 20px;
}

#perfil-imagen-canal {
  padding-top: 20px;
}


</style>

<div class="container-fluid contenido-main">
  <!-- AQUÍ VA EL CONTENIDO -->

  <div class="perfil-ver container">
    <div class="row" id="perfil-contenido">
      <div class="col-md-2 text-center" id="perfil-info-usuario">
        <h3><?= $datosUsuarioPerfilVer["nombre_usuario"]; ?></h3>
        <img class="img-circle img-responsive" src = "<?=$imagenUsuarioPerfilVer; ?>" id="perfil-imagen-usuario">
        <!-- <p><?= $datosUsuarioPerfilVer["descripcion"]; ?></p> -->
      </div>
      <div class="col-md-10" id="perfil-info-canal">
        <div class="col-md-8">
          <h2 class="pull-left"><span class="<?=$estadoConexion; ?>"></span> <?=$datosUsuarioPerfilVer["titulo_canal"];?></h2>
          <a href="<?= $botonHRef; ?>" class="btn btn-info <?= $botonDisabled ?> pull-right" id="perfil-boton-canal">Ver canal</a>
          <div class="clearfix"></div>
          <h4 class="titulo-cabecera-perfil-ver"><?= $categoriaUsuario; ?></h4>
          <p>
            <span class="glyphicon glyphicon-eye-open"></span> <?=$datosUsuarioPerfilVer["visitas"]; ?>
            <span class="glyphicon glyphicon-thumbs-up perfil-icono perfil-icono-votos"></span> <span><?= $datosUsuarioPerfilVer["votos"]; ?></span>
          </p>
          <p><?=$datosUsuarioPerfilVer["descripcion_canal"]; ?></p>
        </div>
        <div class="col-md-4" id="perfil-imagen-canal">
          <img class="img-responsive img-circle" src="<?=$imagenCanalPerfilVer; ?>">
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
/* AQUÍ VA EL JAVASCRIPT */

</script>

<?php
/* NO TOCAR ESTO */
$contenidoPagina = ob_get_clean();
include_once("master.php");
?>
