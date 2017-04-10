<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("./lib/functions.php");
include_once("./modelos/conexion.php");

accesoSoloUsuariosRegistrados('./index.php');

/*
Título de la ventana ()<title></title>).
Si se deja vacio se utilizará el valor predeterminado de master.php
*/
$tituloHTML = "Olrait Streaming - Buscador";

/*
Clase para el body. Opcional, dejar vacio si no se necesita.
*/
$claseBody = "pag-buscar";

/* AQUÍ VA EL MODELO */
function recuperarCanalesPorBusqueda($criterio) {
  return hacerListado("SELECT * FROM usuarios WHERE grupo<='3' AND (titulo_canal LIKE '%$criterio%' OR nombre_usuario LIKE '%$criterio%')");
}

function obtenerImagenCanalUsuario($id) {
  $imagen = hacerListado("SELECT imagen_canal FROM usuarios WHERE id='$id'");
  $fichero = "./img/usuarios/" . $id . "/" . "img_canal/" . $imagen[0]["imagen_canal"];
  if (!empty($imagen[0]["imagen_canal"]) && file_exists($fichero)) {
    return $fichero;
  } else {
    return "./img/usuarios/default_canal.jpg";
  }
}


/* AQUÍ VA LA LÓGICA PHP */

$criterio = (!empty($_GET['busqueda'])) ? $_GET['busqueda'] : false;
$numeroCanalesPorFila = 4;
$canales = [];
$msgInfo = '<p class="alert alert-danger">Debe introducir un criterio de búsqueda</p>';

if ($criterio) {
  $canales = recuperarCanalesPorBusqueda($criterio);
  $msgInfo = (count($canales) > 0) ? '' : '<p class="alert alert-danger">No se ha encontrado ningún canal con ese criterio de búsqueda</p>';
}

ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */

</style>

<div class="container contenido-main">
  <!-- AQUÍ VA EL CONTENIDO -->

  <?= $msgInfo ?>

  <?php
  /* Recorremos el array $usuariosPorCategoria y metemos cada objeto en $usuario */
  foreach ($canales as $indice => $canal) :
    /* Metemos en la variable $imagen la imagen de cada usuario según su id */
    $imagen = obtenerImagenCanalUsuario($canal["id"]);
    if ($indice % $numeroCanalesPorFila == 0) {
      echo "<div class='row'>";
    }
    ?>

    <div class="col-xs-6 col-sm-6 col-lg-3 col-md-3 tarjeta-usuario-directo">
      <div class="thumbnail imagen-usuario-directo">
        <a href="reproductor.php?canal=<?= $canal["nombre_usuario"]?>">
          <img class="img-responsive" src="<?= $imagen ?>" alt="<?= $canal["nombre_usuario"] ?>">
        </a>
        <div class="caption">
          <h4>
            <a href="reproductor.php?canal=<?=$canal["nombre_usuario"]?>" class="pag-portada-titulo-thumbnail">
              <?= $canal["titulo_canal"] ?>
            </a>
          </h4>
        </div>
      </div>
    </div>

    <?php
    if ($indice % $numeroCanalesPorFila== 3 && $indice < count($canal) - 1) {
      echo "</div>";
    }
  endforeach;
  ?>

</div>

<script type="text/javascript">
/* AQUÍ VA EL JAVASCRIPT */

</script>

<?php
/* NO TOCAR ESTO */
$contenidoPagina = ob_get_clean();
include_once("./master.php");
?>
