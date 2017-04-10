<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("./lib/functions.php");
include_once("./modelos/conexion.php");


/*
Título de la ventana ()<title></title>).
Si se deja vacio se utilizará el valor predeterminado de master.php
*/
$tituloHTML = "Olrait! Streaming - Registro completado";

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
#completado-mensaje {
  color: rgb(16,68,85);
}

#completado-logo {
  max-width: 100%;
}
</style>

<div class="container contenido-main">
  <!-- AQUÍ VA EL CONTENIDO -->

<div class="panel panel-success">
  <div class="panel-heading text-center">
    <h1>¡Enhorabuena!</h1>
  </div>
  <div class="panel-body text-center" id="completado-mensaje">
    <h3>Su registro se ha completado correctamente, su solicitud será revisada en la mayor brevedad posible.</h3>
    <div>
      <img src="./img/logos/pulpo2.png" alt="" id="completado-logo">
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
include_once("./master.php");
?>
