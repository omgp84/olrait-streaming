<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("./modelos/conexion.php");
include_once("./lib/functions.php");


/*
Título de la ventana (<title></title>).
Si se deja vacio se utilizará el valor predeterminado de master.php
*/
$tituloHTML = "Olrait! Streaming";

/*
Clase para el body. Opcional, dejar vacio si no se necesita.
*/
$claseBody = "pag-landing";

/* AQUÍ VA EL MODELO */



/* AQUÍ VA LA LÓGICA PHP */



ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */

.pag-landing {
  background: url(./img/landing/landing_bg.jpg);
}

.landing-jumbotron {
  margin-top: 30px;
  margin-left: 50px;
  color: #000;
  background-color: rgba(238, 238, 238, 0.7);
}

</style>

<div class="container-fluid contenido-main">
  <!-- AQUÍ VA EL CONTENIDO -->
  <div class="jumbotron landing-jumbotron pull-left">
    <h1>Streaming, Olrait!</h1>
    <p>Si quieres estar a la última en videos y audio</p>
    <p>
      <a class="btn btn-primary btn-lg landing-registro-btn" role="button">¡Regístrate!</a>
      <a href="ayuda.php" class="btn btn-danger btn-lg" role="button">Ayuda</a>
    </p>
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
