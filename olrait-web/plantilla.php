<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("./lib/functions.php");
include_once("./modelos/conexion.php");


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

</style>

<div class="container-fluid contenido-main">
  <!-- AQUÍ VA EL CONTENIDO -->

</div>

<script type="text/javascript">
/* AQUÍ VA EL JAVASCRIPT */

</script>

<?php
/* NO TOCAR ESTO */
$contenidoPagina = ob_get_clean();
include_once("./master.php");
?>
