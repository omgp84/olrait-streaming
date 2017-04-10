<?php
/*AQUI VA EL MODELO PHP*/

function obtenerCategoriasAside($numeroCategorias = 10) {
  return hacerListado("SELECT * FROM categorias LIMIT $numeroCategorias");
}
/*ESTA FUNCION ES INDISPENSABLE PARA EL ASIDE YA QUE NOS PERMITE SELECCIONAR LOS USUARIOS SEGUN EL TIPO DE EMISION Y LA CATEGORIA, ADEMÁS DE AGRUPAR A ESTOS USUSARIOS PARA LA PAGINACIÓN*/
function mostrarUsuariosPorFiltroYCategoria($filtro, $categoria, $limite=false, $offset=false){

  $orden = "ORDER BY emitiendo DESC";

  if ($filtro && $categoria) {
    $consulta = "SELECT * FROM usuarios WHERE tipo_emision='$filtro' AND id_categoria='$categoria' AND grupo<='3' $orden";
  } elseif (!$filtro && $categoria) {
    $consulta = "SELECT * FROM usuarios WHERE id_categoria='$categoria' AND grupo<='3' $orden";
  } elseif ($filtro && !$categoria) {
    $consulta = "SELECT * FROM usuarios WHERE tipo_emision='$filtro' AND grupo<='3' $orden";
  } else {
    $consulta = "SELECT * FROM usuarios AND grupo<='3' $orden";
  }


  if ($limite !== false) {
    $consulta .= " LIMIT $limite";
  }

  if ($offset !== false) {
    $consulta .= " OFFSET $offset";
  }
  //print($consulta); exit();
  return hacerListado($consulta);
}

/* AQUÍ VA LA LÓGICA PHP */


$categoriasAside = obtenerCategoriasAside();

/*VARIABLE FILTRO: recoge los datos del tipo de emisión de los usuarios*/
$filtro = (!empty($_GET["tipo_emision"])) ? $_GET["tipo_emision"] : false;
/*VARIABLE CATEGORIA: recoge los datos referente a las categorias que pueden tener los ususarios*/
$categoria = (!empty($_GET["categoria"])) ? $_GET["categoria"] : false;


?>

<style media="screen">
/* AQUÍ VA EL CSS */

/*Estructura general de la barra lateral o aside*/
.aside {
  min-height: 100%;
  box-sizing: border-box;
  text-align: center;
  height: 100%;
  width: 300px;
  position: fixed;
  background-color: #222;
  top: 50px;
  left: 0;
  padding: 20px;
}

/*Lista desplegable que aparece al hacer clic en el botón categorias*/
.listado-aside{
  width: 260px;
  max-height: 400px;
  overflow-y: auto;
  background-color: #e8e8e8;
  text-align: center;
  box-shadow: 0px 6px 10px #000;
}

/*Separación entre los botones de los filtros en el aside*/
.filtros-aside{
  margin-top: 40px;
}

/*Estructura del botón de Categorias en el aside*/
.boton-desplegable-aside{
  width: 260px;
  background-color: #e8e8e8;
  color: #337ab7;
}

/*Estructuar de los enlaces que aparecen en los botones de los filtros*/
.boton-aside, .boton-aside:hover{
  border: 2px solid;
  margin-bottom: 20px;
  background-color: #e8e8e8;
  text-decoration: none;
}

.boton-aside h2, .boton-desplegable-aside h2 {
  margin: 5px 0;
}

/*Estructura de la barra lateral en caso de que la ventana se reduzca a un cierto tamaño, puede modificarse según los parámetros que se introduzcan en media screen*/
@media screen and (max-width:800px) {
  .aside {
    position: relative;
    width: 100%;
    height: auto;
    margin-bottom: 70px;
  }
  .boton-desplegable-aside {
    width: 100%;
  }
  .listado-aside {
    width: 100%;
    margin-right: 50px;
    margin-left: 0;
  }
}
</style>



<aside class="aside">
  <!-- Este es el boton desplegable de CATEGORIAS que va en el aside -->
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle boton-desplegable-aside" type="button" id="dropdownMenuButton" data-toggle="dropdown"><h2>Categorías <span class="caret"></span></h2></button>
    <div class="dropdown-menu listado-aside" aria-labelledby="dropdownMenuButton">
      <li><a class="dropdown-item enlace-aside" href="canales.php">Todas las categorias</a></li>

      <!-- Recorremos el array $categorias y metemos cada objeto en $categoriaListado -->
      <?php foreach ($categoriasAside as $tipo): ?>

        <li><a class="dropdown-item enlace-aside" href="categoria.php?categoria=<?=$tipo["id"]?>&nombre=<?=$tipo["nombre"]?>&pagina=1"><?= $tipo["nombre"] ?></a></li>

      <?php endforeach; ?>
    </div>
  </div>

  <div class="filtros-aside">

  <!--Estructura if en la cual se establece qué se va a introducir en la dirección de cada enlace al hacer clic sobre cada uno de los botones de los filtros-->

    <?php
    if(!empty($categoria) && !empty($filtro)){
      $paginacion = "pagina=1";
      $paginaDestino = "categoria.php";
      $categoriaEnlace = "categoria=". $categoria;
    }elseif(!empty($categoria) && empty($filtro) ){
      $paginaDestino ="categoria.php";
      $categoriaEnlace = "categoria=". $categoria;
      $paginacion = "pagina=1";
    }else{
      $paginaDestino = "canales.php";
      $categoriaEnlace = "";
      $paginacion = "";
    }
    ?>

<!--Estos son los botones de los filtros que aparecen en el aside-->

    <a href="<?= $paginaDestino; ?>?tipo_emision=1&<?=$categoriaEnlace;  ?>&<?= $paginacion;?>" type="button" id="soloVideoBtn" class="btn btn-link btn-block boton-aside"><h2>Solo vídeo</h2></a>
    <a href="<?= $paginaDestino; ?>?tipo_emision=2&<?=$categoriaEnlace; ?>&<?= $paginacion;?>" type="button" id="soloAudioBtn" class="btn btn-link btn-block boton-aside"><h2>Solo audio</h2></a>
    <a href="<?= $paginaDestino; ?>?tipo_emision=3&<?=$categoriaEnlace; ?>&<?= $paginacion;?>" type="button" id="videoYAudioBtn" class="btn btn-link btn-block boton-aside"><h2>Vídeo y audio</h2></a>
    <a href="<?= $paginaDestino; ?>?tipo_emision=4&<?=$categoriaEnlace; ?>&<?= $paginacion;?>" type="button" id="pantallAudioBtn" class="btn btn-link btn-block boton-aside"><h2>Pantallaudio</h2></a>
    <a href="<?= $paginaDestino; ?>?<?=$categoriaEnlace; ?>&<?=$paginacion;?>" type="button" id="mostrarTodoBtn" class="btn btn-link btn-block boton-aside"><h2>Mostrar todo</h2></a>
  </div>
</aside>
