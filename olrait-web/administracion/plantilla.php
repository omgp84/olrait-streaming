<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("../modelos/conexion.php");
include_once("../lib/functions.php");

/*
Título de la ventana ()<title></title>).
Si se deja vacio se utilizará el valor predeterminado de master.php
*/
$tituloHTML = "";

/*
Clase para el body. Opcional, dejar vacio si no se necesita.
*/
$claseBody = "pag-administracion";

/* AQUÍ VA EL MODELO */



/* AQUÍ VA LA LÓGICA PHP */
function obtenerTodosLosUsuarios() {
  return hacerListado("SELECT * FROM usuarios");
}

$usuarios = obtenerTodosLosUsuarios();


ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */

</style>

<!-- AQUÍ VA EL CONTENIDO -->

<div class="container contenido-main">
  <div class="row">
    <div class="col-md-12 text-center">
      <h1>Lista de usuarios</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Nombre Usuario</th>
            <th>Nombre</th>
            <th>Nombre del canal</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($usuarios as $usuario): ?>
            <tr>
              <td><?= $usuario['nombre_usuario'] ?></td>
              <td><?= $usuario['nombre'] ?></td>
              <td><?= $usuario['titulo_canal'] ?></td>
              <td>
                <a href="" class="btn btn-info btn-xs">
                  <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Ver
                </a>
                <a href="" class="btn btn-success btn-xs">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar
                </a>
                <a href="eliminar_usuario.php?id=<?= $usuario['id'] ?>" class="btn btn-danger btn-xs">
                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Eliminar
                </a>
              </td>
            </tr>
          <?php endforeach; ?>

        </tbody>
      </table>
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
