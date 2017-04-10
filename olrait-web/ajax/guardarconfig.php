<?php
session_start();

include_once('../modelos/conexion.php');

if (!empty($_SESSION['usuario']) && $_SESSION['usuario']['grupo'] == 1) {
  $nombre = (!empty($_POST["accion"])) ? $_POST["accion"] : false;
  $valor = (!empty($_POST["valor"])) ? $_POST["valor"] : false;
  if ($nombre && $valor) {
    echo ejecutarConsulta("UPDATE config SET nombre='$nombre',valor='$valor' WHERE nombre='$nombre'");
  }
}
?>
