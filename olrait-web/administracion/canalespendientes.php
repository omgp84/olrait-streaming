<?php
session_start();

/* AQUÍ VAN LOS INCLUDES */
include_once("../modelos/conexion.php");
include_once("../lib/functions.php");
accesoSoloEditores('../portada.php');

/*
Título de la ventana (<title></title>).
Si se deja vacio se utilizará el valor predeterminado de master.php
*/
$tituloHTML = "";

/*
Clase para el body. Opcional, dejar vacio si no se necesita.
*/
$claseBody = "pag-administracion-canales";

/* AQUÍ VA EL MODELO */


/* AQUÍ VA LA LÓGICA PHP */
function obtenerTodosLosUsuarios() {
  return hacerListado("SELECT * FROM usuarios_pendientes");
}

$usuarios = obtenerTodosLosUsuarios();

ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */
.pag-administracion-canales {
  max-width: 100%;
}

.btn-registro {
  margin-top: 20px;
}

.cabecera-usuarios {
  color: #101010;
}

.datos-usuarios {
  color: rgb(10,52,66);
  background-color: #f5f5f5;
}
</style>

<!-- AQUÍ VA EL CONTENIDO -->

<div class="contenido-main">
  <div class="row">
    <div class="col-md-12">
      <h1 class="pull-left">Pendientes de aprobación</h1>
      <a href="registroadmin.php" class="btn btn-primary pull-right btn-registro">Nuevo usuario</a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table class="table table-bordered">
        <thead id="cabecera-usuarios">
          <tr>
            <th>Nombre Usuario</th>
            <th>Nombre</th>
            <th>Nombre del canal</th>
            <th>Grupo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($usuarios as $usuario): ?>
            <tr class="datos-usuarios">
              <td><?= $usuario['nombre_usuario'] ?></td>
              <td><?= $usuario['nombre'] ?></td>
              <td><?= $usuario['titulo_canal'] ?></td>
              <td><?= $usuario['grupo'] ?></td>
              <td>
                <a href="../verperfil.php?usuario=<?= $usuario['id'] ?>" class="btn btn-info btn-xs">
                  <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Ver
                </a>
                <a href="../editarusuario.php?usuario=<?= $usuario['id'] ?>" class="btn btn-warning btn-xs">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Editar
                </a>
                <a href="aprobarcanal.php?id=<?= $usuario['id'] ?>" class="btn btn-success btn-xs">
                  <span class="glyphicon glyghicon-thumbs-up"></span> Aprobar
                </a>
                <a href="rechazarpendiente.php?id=<?= $usuario['id'] ?>" class="btn btn-danger btn-xs">
                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Rechazar
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
