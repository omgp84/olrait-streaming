<?php
/***************************************************************************
¡NO TOCAR! Si necesitáis añadir algo decidmelo
En este archivo van las funciones globales que no encajan en otros archivos
***************************************************************************/

function evitarAccesoDirecto($archivo, $url) {
  // Comprueba si la patición es get y la ruta del archivo coincide con la URL
  if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath($archivo) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header("Location: $url"));
  }
}

function esAdmin() {
  $grupo = (!empty($_SESSION["usuario"])) ? $_SESSION["usuario"]["grupo"] : false;
  return ($grupo && $grupo == 1) ? true : false;
}

function esEditor() {
  $grupo = (!empty($_SESSION["usuario"])) ? $_SESSION["usuario"]["grupo"] : false;
  return ($grupo && $grupo <= 2) ? true : false;
}

function esStreamer() {
  $grupo = (!empty($_SESSION["usuario"])) ? $_SESSION["usuario"]["grupo"] : false;
  return ($grupo && $grupo <= 3) ? true : false;
}

function esUsuario() {
  $grupo = (!empty($_SESSION["usuario"])) ? $_SESSION["usuario"]["grupo"] : false;
  return ($grupo && $grupo <= 4) ? true : false;
}

function accesoSoloAdmins($url) {
  if (!esAdmin()) die(header("Location: $url"));
}

function accesoSoloEditores($url) {
  if (!esEditor()) die(header("Location: $url"));
}

function accesoSoloStreamers($url) {
  if (!esStreamer()) die(header("Location: $url"));
}

function accesoSoloUsuariosRegistrados($url) {
  if (!esUsuario()) die(header("Location: $url"));
}
?>
