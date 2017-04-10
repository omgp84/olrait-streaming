<!--
/**********************************************
¡NO TOCAR! Si necesitáis añadir algo decidmelo
**********************************************/
-->
<?php
include_once("../lib/functions.php");

function obtenerTotales() {
  $totales["totalCanales"] = hacerListado("SELECT COUNT(*) AS total FROM usuarios")[0]["total"];
  $totales["totalEmitiendo"] = hacerListado("SELECT COUNT(*) AS total FROM usuarios WHERE emitiendo='1'")[0]["total"];
  $totales["totalCategorias"] = hacerListado("SELECT COUNT(*) AS total FROM categorias")[0]["total"];
  return $totales;
}

$totales = obtenerTotales();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= (!empty($tituloHTML)) ? $tituloHTML : "Streaming" ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="Description" content="Descripción para buscadores" />
  <link rel="icon" type="image/png" href="./favicon.ico">
  <link rel="stylesheet" href="../lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
  <script src="../lib/jquery-3.1.1.min.js"></script>
  <script src="../lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="../js/scripts.js"></script>
</head>
<body class="<?= $claseBody ?>">

  <!-- NAVBAR -->
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-administracion" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Olrait! Streaming</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-administracion">
        <ul class="nav navbar-nav">
          <li><a href="../portada.php" id="navbar-link-inicio"><span class="glyphicon glyphicon-home" id="navbar-icono-inicio"></span></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="navbar-link-usuario">
              <span class="glyphicon glyphicon-user" id="navbar-icono-usuario"></span>
              <span id="nombre-usuario-navbar" style="position:relative; top: -7px;"> <?= (!empty($_SESSION["usuario"])) ? $_SESSION["usuario"]["nombre_usuario"] : "" ?></span>
            </a>
            <ul class="dropdown-menu" id="dropdown-login-navbar">
              <li><a href="../reproductor.php?accion=emitir&canal=<?= $_SESSION['usuario']['nombre_usuario'] ?>"><span class="glyphicon glyphicon-upload"></span> Emitir</a></li>
              <li><a href="../verperfil.php?usuario=<?= $_SESSION['usuario']['nombre_usuario'] ?>"><span class="glyphicon glyphicon-user"></span> Ver perfil</a></li>
              <li><a href="../editarusuario.php?usuario=<?= $_SESSION['usuario']['id'] ?>"><span class="glyphicon glyphicon-pencil"></span> Editar perfil</a></li>
              <li class="divider"></li>
              <li><a href="../portada.php"><span class="glyphicon glyphicon-menu-left"></span> Volver a la página</a></li>
              <li class="divider"></li>
              <li><a href="../salir.php" id="salir-navbar" data-location="administracion"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
            </ul>
          </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>

  <!-- /NAVBAR -->

  <div class="main">

    <div class="container-fluid contenido-main">
      <!-- AQUÍ VA EL CONTENIDO -->
      <div class="row">
        <div class="col-sm-4 hidden-xs">
          <div class="alert alert-success text-center">
            <div class="col-lg-4 col-md-12">
              <span class="glyphicon glyphicon-user" style="line-height: 95px; font-size: 80px"></span>
            </div>
            <div class="col-lg-8 col-md-12">
              <h2 style="margin-top: 5px"><?= $totales["totalCanales"] ?></h2>
              <h3>Canales</h3>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="col-sm-4 hidden-xs">
          <div class="alert alert-info text-center">
            <div class="col-lg-4 col-md-12">
              <span class="glyphicon glyphicon-bullhorn" style="line-height: 95px; font-size: 80px"></span>
            </div>
            <div class="col-lg-8 col-md-12">
              <h2 style="margin-top: 5px"><?= $totales["totalEmitiendo"] ?></h2>
              <h3>Emitiendo</h3>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
        <div class="col-sm-4 hidden-xs">
          <div class="alert alert-warning text-center">
            <div class="col-lg-4 col-md-12">
              <span class="glyphicon glyphicon-th-list" style="line-height: 95px; font-size: 80px"></span>
            </div>
            <div class="col-lg-8 col-md-12">
              <h2 style="margin-top: 5px"><?= $totales["totalCategorias"] ?></h2>
              <h3>Categorías</h3>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-2">
          <div class="list-group">
            <a href="./canales.php" class="list-group-item">Canales</a>
            <a href="./canalespendientes.php" class="list-group-item">Canales pendientes</a>
            <a href="./configuracion.php" class="list-group-item">Configuración</a>
          </div>
        </div>
        <div class="col-md-10">

          <?= $contenidoPagina ?>

        </div>
      </div>
    </div>
  </div>

  <div class="modal fade olrait-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"></h4>
        </div>
        <div class="modal-body"></div>
      </div>
    </div>
  </div>

  <div class="modal fade olrait-modal-info" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" id="olrait-modal-info-dialog">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <span class="modal-body"></span>
    </div>
  </div>
</body>
</html>
