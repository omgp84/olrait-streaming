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

/* Obtenemos los usuarios ordenados por visitas */
function obtenerUsuariosOrdenadosPorVisitasCategoria($categoria) {
  return hacerListado("SELECT * FROM usuarios where id_categoria='$categoria' ORDER BY visitas DESC ");
}

/* Obtenemos las imagenes del canal del usuario tanto de la base de datos como de la carpeta */
function obtenerImagenCanalUsuario($id) {
  $imagen = hacerListado("SELECT imagen_canal FROM usuarios WHERE id='$id'");//Consulta para obtener los datos de la imagene
  $rutaImagen  = "./img/usuarios/" . $id . "/" . "img_canal/";//Ruta donde se obtendrá la imagen
  $imagenPorDefecto = "./img/usuarios/default_canal.jpg";//Ruta donde se obtendrá la imagen por defecto
  return $imagen = (!empty($imagen[0]["imagen_canal"]) && file_exists($rutaImagen))? $rutaImagen . $imagen[0]["imagen_canal"]: $imagenPorDefecto;//estructura if con operador ternario en donde se seleccionara una ruta u otra en funcion de si el usuario ha descargado o no una imagen
}


/* Obtenemos las categorias y las metemos como array en la variable $categorias*/
function obtenerCategoriasPorId($id) {
  $consulta = hacerListado("SELECT * FROM categorias where id = '$id'");
  return (!empty($consulta))? $consulta[0]: false;
}

/*Obtenemos el total del número de usuarios que hay en la base de datos*/
function obtenerNumeroDeUsuariosPorFiltroYCategoria($filtro, $categoria) {
  if (!empty($filtro) && !empty($categoria)) {
    $consulta = hacerListado("SELECT COUNT(id) AS total FROM usuarios WHERE tipo_emision = '$filtro' AND id_categoria = '$categoria'");
  } elseif (empty($filtro) && !empty($categoria)) {
    $consulta = hacerListado("SELECT COUNT(id) AS total FROM usuarios WHERE id_categoria = '$categoria'");
  } else {
    $consulta = hacerListado("SELECT COUNT(id) AS total FROM usuarios");
  }

  return (!empty($consulta))? $consulta[0]["total"]:  false;

}


/* AQUÍ VA LA LÓGICA PHP */


/* Declaramos la variable $usuarios que es un array */


$elementosPorPagina = 5;

ob_start();
?>

<style media="screen">
/* AQUÍ VA EL CSS */

.main {
  padding-left: 400px;
}

/*-----------------TITULO------------------*/
.destacados-categoria {
  border: solid 10px rgb(10,52,66);
  border-radius: 12px;
  background-color: rgb(10,52,66);
  margin: 0 20px 40px 0;
}

/*-----------------FIN TITULO------------------*/


/*----------------------CONTENEDOR USUARIOS--------------*/
/*Estructura generald de la "tarjeta" de canal*/
.tarjeta-usuario-categoria {
  padding-bottom: 25px;
}
/*Tamaño de la imagen de canal en la tarjeta*/
.imagen-usuario-categoria {
  height: 155px !important;
  width: 100%;
}
/*Fondo de la tarjeta de usuario*/
.contenido-tarjeta-usuario-categoria {
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
}
/*Determina el color y el tamaño de los iconos de emitiendo o no emitiendo (play, stop)*/
.icono-categoria{
  font-size: 20px;
  text-align: center;
}

.icono-categoria-stop{
  color: red;
}
.icono-categoria-play{
  color: green;
}

.tit-pag-cat {
  margin: 0 !important;
}

/*Estructura de la página en caso de que la ventana se reduzca a un cierto tamaño, puede modificarse según los parámetros que se introduzcan en media screen*/
@media screen and (max-width:800px) {
  .main {
    padding-left: 0;
  }

  .destacados-categoria {
    margin: 0 0 40px 0;
    border-radius: 0;
  }

  .contenido-pagina-categoria {
    padding-left: 0;
  }

  .tarjeta-usuario-directo {
    min-width: 200px;
    margin: 0 auto;
  }
}
/*----------------------FIN CONTENEDOR USUARIOS--------------*/

</style>

<div class="container-fluid contenido-main">
  <!-- AQUÍ VA EL CONTENIDO -->

  <?php
  //INCLUIMOS EL ASIDE A PARTIR DE ESTE EXTRAEMOS TODOS LOS DATOS DE LAS FUNCIONES QUE APARECEN EN EL ASIDE
  include_once("aside.php");


  $categoria = (!empty($_GET["categoria"])) ? $_GET["categoria"] : false;
  $categorias = (!empty($categoria))?obtenerCategoriasPorId($categoria):false;
  $filtro = (!empty($_GET["tipo_emision"])) ? $_GET["tipo_emision"] : false;
  $offset = (($_GET["pagina"]-1)*$elementosPorPagina);
  $filtrados = mostrarUsuariosPorFiltroYCategoria($filtro, $categoria, $elementosPorPagina, $offset);

  //ESTE ES EL CÓDIGO PARA LA PAGINACION



  //Los números de las páginas a las que se va con los botones "anteior" y "siguiente" respectivamente
  $numeroPaginaAnterior = $_GET["pagina"] - 1;
  $numeroPaginaPosterior = $_GET["pagina"] + 1;

  //Enlaces de los botones "anterior" y "siguiente"
  $paginaAnterior = "categoria.php?categoria=" . $categoria . "&tipo_emision=" . $filtro . "&pagina=" . $numeroPaginaAnterior;
  $paginaPosterior = "categoria.php?categoria=" . $categoria . "&tipo_emision=" . $filtro . "&pagina=" . $numeroPaginaPosterior;

  //Para desactivar los botones de "anterior" y "siguiente" respectivamente
  $desactivarBotonAnterior = "";
  $desactivarBotonPosterior = "";

  //Para conocer el número de paginas y de usuarios por página
  $numeroDeUsuarios = obtenerNumeroDeUsuariosPorFiltroYCategoria($filtro, $categoria);
  $numeroDePaginas = ceil($numeroDeUsuarios / $elementosPorPagina);

  //Estructura if que establece tanto los botones que se desactivan o no como los enlaces a los que va cada uno de los botones al hacer clic.

  if($_GET["pagina"]==1 && $_GET["pagina"] >= $numeroDePaginas){
    $desactivarBotonAnterior = "disabled='disabled'";
    $paginaAnterior = "";
    $desactivarBotonPosterior = "disabled ='disabled";
    $paginaPosterior = "";
  }elseif($_GET["pagina"] == 1){
    $desactivarBotonAnterior = "disabled='disabled";
    $paginaAnterior = "";
  }elseif($_GET["pagina"] >= $numeroDePaginas){
    $desactivarBotonPosterior = "disabled='disabled";
    $paginaPosterior = "";
  }

  ?>

  <!--Estructura del título y la paginación-->
  <div class="contenido-pagina-categoria">
    <div class="row" >


      <!-- COMIENZO ESTRUCTURA DEL TITULO Y PAGINACION -->
      <div class="destacados-categoria">
        <div class="col-md-2 col-xs-2 btn-pag-cat">
          <a href="<?= $paginaAnterior; ?>" class="btn btn-primary  btn-sm pull-left previous <?= $desactivarBotonAnterior; ?>"><span class="glyphicon glyphicon-arrow-left"></span> Anterior</a>
        </div>

        <div class="col-md-8 col-xs-8 text-center">
          <h2 class="tit-pag-cat">Categoria <?= $categorias["nombre"] ?></h2>
        </div>

        <div class="col-md-2 col-xs-2 text-right btn-pag-cat text-right">
          <a href=" <?= $paginaPosterior; ?>" class="btn btn-primary btn-sm pull-right next <?= $desactivarBotonPosterior; ?>">Siguiente <span class="glyphicon glyphicon-arrow-right"></span></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <!--FIN DE LA ESTRUCTURA DEL TITULO Y PAGINACION-->

      <!--COMIENZO ESTRUCTURA TARJETA DE CANAL-->
      <?php
      /* Recorremos el array $filtrados y metemos cada objeto en $usuario */
      foreach ($filtrados as $usuario) :

        /*Con la variable estadoConexion determinaremos qué icono aparece en caso de que el canal esté emitiendo o no*/
        $estadoConexion = $usuario["emitiendo"] ? "glyphicon glyphicon-play icono-categoria icono-categoria-play" : "glyphicon glyphicon-stop icono-categoria icono-categoria-stop";
        /* Metemos en la variable $imagen la imagen de cada usuario según su id */
        $imagen = obtenerImagenCanalUsuario($usuario["id"]);
        ?>
        <!--Por cada usuario que aparezca aparecerá en la página según esta estructura-->
        <div class="col-xs-6 col-sm-6 col-lg-2 col-md-2 tarjeta-usuario-categoria">
          <div class="thumbnail contenido-tarjeta-usuario-categoria">
            <a href="reproductor.php?canal=<?=$usuario["nombre_usuario"]?>"><img class="img-responsive img-rounded imagen-usuario-categoria" src="<?= $imagen ?>"></a>
            <div class="caption">
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
      <?php endforeach; ?>
        <!--FIN ESTRUCTURA TARJETA DE CANAL-->
    </div>
  </div>
</div>


<script type="text/javascript">
/* AQUÍ VA EL JAVASCRIPT */

</script>

<?php
/* NO TOCAR ESTO */
$contenidoPagina = ob_get_clean();
include_once("master.php");
?>
