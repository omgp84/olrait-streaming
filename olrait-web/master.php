<!--
/**********************************************
¡NO TOCAR! Si necesitáis añadir algo decidmelo
**********************************************/
-->
<?php
include_once("./lib/functions.php");
include_once('./modelos/conexion.php');

$redesSociales = hacerListado("SELECT valor FROM config WHERE nombre='facebook' OR nombre='twitter' OR nombre='linkedin'");

if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['grupo'] <= 3) {
  $enlaceEmitir = '<li><a href="reproductor.php?accion=emitir&canal=' . $_SESSION['usuario']['nombre_usuario'] . '"><span class="glyphicon glyphicon-upload"></span> Emitir</a></li>';
} else {
  $enlaceEmitir = '';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title><?= (!empty($tituloHTML)) ? $tituloHTML : "Olrait! Streaming" ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="Description" content="Streaming de audio, vídeo y pantalla en tiempo real" />
  <link rel="shortcut icon" type="image/png" href="./favicon.ico">
  <link rel="stylesheet" href="./lib/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/styles.css">
  <script src="./lib/jquery-3.1.1.min.js"></script>
  <script src="./lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="./js/scripts.js"></script>
</head>
<body class="<?= $claseBody ?>">

  <!-- NAVBAR -->
  <?php if (!empty($_SESSION["usuario"])): ?>
    <nav class="navbar navbar-inverse navbar-fixed-top navbar-olrait">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-principal" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-principal">
          <ul class="nav navbar-nav text-center">
            <li><a class="enlace-logo-navbar" href="portada.php"><img src="img/logos/pulpo2.png" class="logo-navbar" href="index.php"> <strong>Olrait!</strong></a></li>
            <li><a href="portada.php" id="navbar-link-inicio"><span class="glyphicon glyphicon-home" id="navbar-icono-inicio"></span></a></li>
          </ul>
          <form class="navbar-form navbar-left text-center" action="buscar.php" method="GET">
            <div class="form-group">
              <input type="text" name="busqueda" class="form-control" placeholder="Buscar">
            </div>
            <button type="submit" class="btn btn-default">Buscar</button>
          </form>
          <ul class="nav navbar-nav navbar-right text-center">
            <li class="hidden-sm"><a href="quienessomos.php">¿Quienes somos?</a></li>
            <li><a href="canales.php">Lista de canales</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="navbar-link-usuario">
                <span class="glyphicon glyphicon-user" id="navbar-icono-usuario"></span>
                <span id="nombre-usuario-navbar" style="position:relative; top: -7px;"> <?= (!empty($_SESSION["usuario"])) ? $_SESSION["usuario"]["nombre_usuario"] : "" ?></span>
              </a>
              <ul class="dropdown-menu" id="dropdown-login-navbar">
                  <?= $enlaceEmitir ?>
                  <li><a href="verperfil.php?usuario=<?= $_SESSION['usuario']['id'] ?>"><span class="glyphicon glyphicon-user"></span> Ver perfil</a></li>
                  <li><a href="editarusuario.php?usuario=<?= $_SESSION['usuario']['id'] ?>"><span class="glyphicon glyphicon-pencil"></span> Editar perfil</a></li>

                  <?php
                  if (esEditor()) {
                    echo '<li class="divider"></li>';
                    echo "<li><a href='./administracion/canales.php'><span class='glyphicon glyphicon-list-alt'></span> Administración</a></li>";
                  }
                  ?>

                  <li class='divider'></li>
                  <li><a href="#" id="salir-navbar"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

  <?php else: ?>

    <nav class="navbar navbar-inverse navbar-fixed-top navbar-olrait">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-principal" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-principal">
          <ul class="nav navbar-nav">
            <li><a class="enlace-logo-navbar" href="index.php"><img src="img/logos/pulpo2.png" class="logo-navbar" href="index.php"> <strong>Olrait!</strong></a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="quienessomos.php">¿Quienes somos?</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="navbar-link-usuario">
                <span class="glyphicon glyphicon-user" id="navbar-icono-usuario"></span>
                <span id="nombre-usuario-navbar" style="position:relative; top: -7px;"> <?= (!empty($_SESSION["usuario"])) ? $_SESSION["usuario"]["nombre_usuario"] : "" ?></span>
              </a>
              <ul class="dropdown-menu" id="dropdown-login-navbar">
                <li>
                  <form class="" method="post" id="formulario-login-navbar">
                    <p class="alert alert-danger hidden" id="error-login-navbar">Usuario o contraseña incorrecto</p>
                    <div class="form-group">
                      <label for="usuario-login-navbar">Usuario:</label>
                      <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" class="form-control" id="usuario-login-navbar">
                    </div>
                    <div class="form-group">
                      <label for="contrasena">Contraseña:</label>
                      <input type="password" name="contrasena" placeholder="Contraseña" class="form-control" id="contrasena-login-navbar">
                    </div>
                    <input type="submit" value="Enviar" class="btn btn-primary btn-block">
                  </form>
                  <a href="#" class="registro-btn-navbar pull-right"><small>¿No tienes cuenta? Regístrate</small></a>
                </li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

  <?php endif; ?>
  <!-- /NAVBAR -->

  <div class="main">

    <?= $contenidoPagina ?>

  </div>

  <footer class="footer hidden-xs">
    <div class="container-fluid">
      <div class="hidden-xs col-sm-4 col-md-4" id="copyright-footer">
        <a href="#">Copyright Curso PHP 2017</a>
      </div>
      <div class="col-sm-4 col-md-4 hidden-xs text-center" id="ayuda-footer">
        <a href="ayuda.php"><span class="glyphicon glyphicon-question-sign"></span> Ayuda</a>
      </div>
      <div class="col-xs-12 col-sm-4 col-md-4 text-right" id="redes-sociales-footer">
        <a href="<?= $redesSociales[0]['valor'] ?>" class="footer-link-social"><img src="./img/iconos/social/facebook.png" alt="Facebook" class="footer-icono-social"></a>
        <a href="<?= $redesSociales[1]['valor'] ?>" class="footer-link-social"><img src="./img/iconos/social/twitter.png" alt="Twitter" class="footer-icono-social"></a>
        <a href="<?= $redesSociales[2]['valor'] ?>" class="footer-link-social"><img src="./img/iconos/social/linkedin.png" alt="LinkedIn" class="footer-icono-social"></a>
      </div>
    </div>
  </footer>

  <!-- Modal de contenido dinámico para usos varios-->
  <div class="modal fade olrait-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"></h4>
        </div>
        <div class="modal-body">

        </div>
      </div>
    </div>
  </div>


  <script type="text/javascript">
  // Identificar usuario
  $('#formulario-login-navbar').submit(function(e) {
    e.preventDefault();
    var data = {
      nombre_usuario: $('#usuario-login-navbar').val(),
      contrasena: $('#contrasena-login-navbar').val()
    };
    $.ajax({
      url: './ajax/login.php',
      type: 'POST',
      data: data
    }).done(function(data) {
      (data == true) ? window.location = 'portada.php' : $('#error-login-navbar').removeClass('hidden');
    });
  });
  </script>
</body>
</html>
