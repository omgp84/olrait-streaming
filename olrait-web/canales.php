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


/* Obtenemos las imagenes del canal del usuario tanto de la base de datos como de la carpeta */

function obtenerImagenCanalUsuario($id) {
  $imagen = hacerListado("SELECT imagen_canal FROM usuarios WHERE id='$id'");//Consulta para obtener los datos de la imagene
  $rutaImagen  = "./img/usuarios/" . $id . "/" . "img_canal/";//Ruta donde se obtendrá la imagen
  $imagenPorDefecto = "./img/usuarios/default_canal.jpg";//Ruta donde se obtendrá la imagen por defecto
  return $imagen = (!empty($imagen[0]["imagen_canal"]) && file_exists($rutaImagen))? $rutaImagen . $imagen[0]["imagen_canal"]: $imagenPorDefecto;//estructura if con operador ternario en donde se seleccionara una ruta u otra en funcion de si el usuario ha descargado o no una imagen
}

/* Obtenemos las categorias y las metemos como array en la variable $categoriasAside*/
function obtenerCategorias($numeroCategorias = 10) {
  return hacerListado("SELECT * FROM categorias LIMIT $numeroCategorias");
}

/* AQUÍ VA LA LÓGICA PHP */

$categorias = obtenerCategorias();



ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */

.main {
  padding-left: 400px;
}

/*-----------------TITULO------------------*/
.destacados-canales {
  font-size: 30px;
  text-align: center;
  border: solid 10px rgb(10,52,66);
  border-radius: 12px;
  background-color: rgb(10,52,66);
  margin: 0 70px 40px 0;
}

/*-----------------FIN TITULO------------------*/


/*----------------------CONTENEDOR TARJETA USUARIO--------------*/
/*Separacion entre tarjetas*/
.tarjeta-usuario-canales {
  padding-bottom: 25px;
}
/*Tamaño de la imagen, la cual no varíará por muy grande que sea*/
.imagen-usuario-canales {
  height: 155px !important;
  width: 100%;
}
/*Color de la tarjeta*/
.contenido-tarjeta-usuario-canales{
  background-color: #e8e8e8;
}
/*Icono del pulgar arriba*/
.mano {
  color: rgb(10,52,66);
}
/*Titulo del canal*/
.titulo1 {
  color: rgb(10,52,66);
  font-weight: bolder;
  font-size: 15px;
}

/*Tamaño y color de los iconos de emitiendo o no (play, stop)*/
.icono-canales{
  font-size: 20px;
  text-align: center;
}
.icono-canales-stop{
  color: red;
}
.icono-canales-play{
  color: green;
}
/*Estructura de la página en caso de que la ventana se reduzca a un cierto tamaño, puede modificarse según los parámetros que se introduzcan en media screen*/
@media screen and (max-width:800px) {
  .contenido-pagina-canales {
    padding-left: 0;
  }

  .main {
    padding-left: 0;
  }

  .contenedor-categoria {
    padding: 0 20px;
  }

  .destacados-canales{
    margin-right: 0;
    border-radius: 0;
  }
}
/*----------------------FIN CONTENEDOR USUARIOS--------------*/

</style>

<div class="container-fluid contenido-main">
  <!-- AQUÍ VA EL CONTENIDO -->

<!--Sacamos el aside y de ahí extraemos las funciones que aparezcan en el aside-->
  <?php
  include_once("aside.php");
  ?>

  <div class="contenido-pagina-canales">
    <div class="row" id="contenido-tarjetas-canales">
      <?php
      /* Recorremos el array $categorias y metemos cada objeto en $categoria */
      foreach ($categorias as $categoria) :
        $numeroUsuarios = 5;
        $filtro = (!empty($_GET["tipo_emision"])) ? $_GET["tipo_emision"] : false;
        $filtrados = mostrarUsuariosPorFiltroYCategoria($filtro, $categoria["id"], $numeroUsuarios);
        //En caso de que no haya usuarios en una categoria se obvia introducir la estructura y se pasa a la siiguiente
        if (count($filtrados)<= 0) continue;
        ?>

        <div class="row">
          <h2 class="destacados-canales">Canales de <?= $categoria["nombre"] ?></h2>
          <div class="contenedor-categoria">
          <?php

          /* Recorremos el array $usuariosPorCategoria y metemos cada objeto en $usuario */
          foreach ($filtrados as $usuario):

            /*Con esta variable seguida de la siguiente estructura if determinamos que icono vayamos a introducir en caso de que se esté emitiendo o no el usuario*/
            $estadoConexion = $usuario["emitiendo"] ? "glyphicon glyphicon-play icono-canales icono-canales-play" : "glyphicon glyphicon-stop icono-canales icono-canales-stop";
            /* Metemos en la variable $imagen la imagen de cada usuario según su id */
            $imagen = obtenerImagenCanalUsuario($usuario["id"]);
            ?>
            <!--COMIENZO ESTRUCTURA TARJETAS DE USUARIO-->
            <div class="col-xs-6 col-sm-6 col-lg-2 col-md-2 tarjeta-usuario-canales">
              <div class="thumbnail contenido-tarjeta-usuario-canales">
                <a href="reproductor.php?canal=<?=$usuario["nombre_usuario"]?>"><img class="img-responsive img-rounded imagen-usuario-canales" src="<?= $imagen ?>">
                  <div class="caption"></a>
                    <h4><a href="reproductor.php?canal=<?=$usuario["nombre_usuario"]?>" class="titulo1"><?= $usuario["titulo_canal"] ?></a>
                    </h4>
                  </div>
                  <div class="row ratings">
                    <p class="col-lg-4 col-md-4 col-xs-4 col-sm-4 mano">
                      <span class="glyphicon glyphicon-thumbs-up"> <?= $usuario["votos"] ?></span>
                    </p>
                    <p class="col-lg-4 col-md-4 col-xs-2 col-sm-2">
                      <span class="<?=$estadoConexion; ?>"></span>
                    </p>
                    <p class="col-lg-4 col-md-4 col-xs-4 col-md-4 pull-right mano">
                      <span class="glyphicon glyphicon-eye-open"></span> <?= $usuario["visitas"] ?>
                    </p>
                  </div>
                </div>
              </div>
              <!--FIN ESTRUCTURA TARJETAS DE USUARIO-->
              <?php endforeach; ?>
          </div>
        </div>
          <?php endforeach; ?>
      </div>

    </div>
  </div>


  <script defer type="text/javascript">
  /* AQUÍ VA EL JAVASCRIPT */


  </script>

  <?php
  /* NO TOCAR ESTO */
  $contenidoPagina = ob_get_clean();
  include_once("master.php");
  ?>
