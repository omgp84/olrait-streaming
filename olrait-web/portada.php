<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("./modelos/conexion.php");
include_once("./lib/functions.php");

/* Restringir acceso a usuarios no registrados */
accesoSoloUsuariosRegistrados('./index.php');

/*
Título de la ventana (<title></title>).
Si se deja vacio se utilizará el valor predeterminado de master.php
*/
$tituloHTML = "Olrait! Streaming - Canales destacados";

/*
Clase para el body. Opcional, dejar vacio si no se necesita.
*/
$claseBody = "pag-portada";

/* AQUÍ VA EL MODELO */

/* Obtenemos los usuarios ordenados por visitas */
function obtenerUsuariosOrdenadosPorVisitas() {
  return hacerListado("SELECT * FROM usuarios WHERE emitiendo=1 AND grupo<='3' ORDER BY visitas DESC");
}

/* Obtenemos las imagenes del canal del usuario tanto de la base de datos como de la carpeta */
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

$usuarios = obtenerUsuariosOrdenadosPorVisitas();
$numeroCanalesPorFila = 5;

ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */

body {
  padding-bottom: 40px;
}

.pag-portada {
  padding-top: 50px;
}

.destacados-portada {
  min-height: 500px;
}

.imagen-tarjeta-portada {
  height: 155px !important;
  width: 100%;
}

.info-tarjeta-portada {
  display: block;
  position: relative;
  bottom: 0px;
  color: rgb(10,52,66);
}

.pag-portada-mano-thumbnail {
  color: rgb(10,52,66);
}

.pag-portada-titulo-thumbnail {
  color: rgb(10,52,66);
}

.pag-portada-slider .slide-image {
  min-width: 100%;
  min-height: 400px;
  max-width: inherit !important;
}

.portada-texto-cabecera {
  box-shadow: inset 0px 10px 20px #000;
  background-color: #f5f5f5;
  text-align: center;
  color: #FFF;
  padding: 0 20px 20px 20px;
  background-image: url(./img/fondos/cuadrados.png);
  text-shadow: 2px 2px 3px #000;
}

#portada {
  position:relative;
  box-shadow: 0px -10px 20px #000;
  padding-top: 30px;
}

.portada-final {
  box-shadow: inset 0px 10px 20px #000;
  background-color: #f5f5f5;
  text-align: center;
  color: #FFF;
  padding: 0 20px 20px 20px;
  background-image: url(./img/fondos/cuadrados.png);
  text-shadow: 2px 2px 3px #000;
}

.boton-portada {
  margin-bottom: 30px;
  margin-top: 30px;
}

.letra-portada-final{
  font-weight: bolder;
  font-family: 'titulo';
}
@font-face {
  font-family: titulo;
  src: url(./css/fonts/Pacifico/Pacifico-Regular.ttf);
}

.pag-portada-slider .carousel-inner {
  height: 400px;
}

</style>

<!-- SLIDER -->
<div class="row carousel-holder pag-portada-slider hidden-xs">
  <div class="col-sm-12 col-lg-12 col-md-12">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <img class="slide-image" src="./img/slider/slider1.jpg" alt="">
        </div>
        <div class="item">
          <img class="slide-image" src="./img/slider/slider2.jpg" alt="">
        </div>
        <div class="item">
          <img class="slide-image" src="./img/slider/slider3.jpg" alt="">
        </div>
      </div>
      <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
      </a>
      <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
      </a>
    </div>
  </div>
</div>
<!-- /SLIDER -->

<div class="row">
  <div class="col-md-12 col-xs-12 portada-texto-cabecera">
    <h1>Usuarios destacados</h1>
  </div>
</div>


<div class="container-fluid contenido-main pag-portada-main" id="portada">
  <!-- AQUÍ VA EL CONTENIDO -->

  <div class="contenido">
    <div class="row destacados-portada">
      <div class="container">

        <?php
        foreach ($usuarios as $indice => $usuario):
          $imagen = obtenerImagenCanalUsuario($usuario["id"]);
          if ($indice % $numeroCanalesPorFila == 0) {
            echo "<div class='row'>";
          }
          ?>

          <div class="col-xs-6 col-sm-4 col-lg-2 col-md-2">
            <div class="thumbnail tarjeta-usuario-portada">
              <a href="reproductor.php?canal=<?= $usuario["nombre_usuario"] ?>">
                <img class="imagen-tarjeta-portada" src="<?= $imagen ?>" alt="<?= $usuario["nombre_usuario"] ?>">
              </a>
              <div class="caption">
                <h4>
                  <a href="reproductor.php?canal=<?= $usuario["nombre_usuario"] ?>" class="pag-portada-titulo-thumbnail">
                    <?= $usuario["titulo_canal"] ?>
                  </a>
                </h4>
              </div>
              <div class="info-tarjeta-portada">
                <div class="pull-left">
                  <span class="glyphicon glyphicon-thumbs-up"></span> <?= $usuario["votos"] ?>
                </div>
                <div class="pull-right">
                  <span class="glyphicon glyphicon-eye-open"></span> <?= $usuario["visitas"] ?>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>

          <?php
          if ($indice % $numeroCanalesPorFila== 4 && $indice < count($usuarios) - 1) {
            echo "</div>";
          }
        endforeach;
        ?>

      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-md-12 col-xs-12 portada-final">
    <h1 class="letra-portada-final">¡¡Anímate!!</h1>
    <h2>Si te apasiona la programación, contacta con nosotros.</h2>
    <button type="button" class="btn btn-default btn-lg active boton-portada">Trabaja con nosotros</button>
  </div>
</div>

</div>

<script type="text/javascript">
/* AQUÍ VA EL JAVASCRIPT */

</script>

<?php
/* NO TOCAR ESTO */
$contenidoPagina = ob_get_clean();
include_once("./master.php");
?>
