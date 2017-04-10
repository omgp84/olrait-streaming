<?php

include_once("../modelos/conexion.php");

function guardarImagen($archivos, $tituloCanal, $idCanal) {
  $consulta = "UPDATE usuarios SET imagen_canal='" .  $archivos["imagen"]["name"] . "' WHERE titulo_canal='$tituloCanal'";
  if (ejecutarConsulta($consulta)) {
    $path = "../img/usuarios/" . $idCanal . "/img_canal/";
    if (!is_dir($path)) mkdir($path, 0777, true);
    if (!empty(glob($path . "*"))) array_map('unlink', glob($path . "*"));
    $filePath = $path . basename($_FILES["imagen"]['name']);
    move_uploaded_file($archivos["imagen"]["tmp_name"], $filePath);
  }
}

/*A TRAVÉS DE ESTA FUNCIÓN SE ACTUALIZA LA BASE DE DATOS CON LOS DATOS QUE SE LE ENVÍA*/
function consultaUpdateEditarCanal($datos, $tabla) {
  foreach ($datos as $clave => $valor) {
    $arr[] = "$clave='$valor'";
  }
  return "UPDATE $tabla SET " . implode(",", $arr) . " WHERE id='" . $datos["id"] . "'";
}

/* ESTA FUNCIÓN LE ENVÍA A LA FUNCIÓN consultaUpdate LA INFORMACIÓN EN BASE A LA CUAL DEBE ACTUALIZAR LA TABLA INDICADA, EN ESTE CASO LA TABLA USUARIO.*/
function actualizarCanal($datos) {
  $consulta = consultaUpdateEditarCanal($datos, "usuarios");
  echo ejecutarConsulta($consulta);
}

if (!empty($_POST)) {
  if(!empty($_FILES["imagen"]["name"])) {
    guardarImagen($_FILES, $_POST["titulo_canal"], $_POST['id']);
  }
  actualizarCanal($_POST);
}

?>
