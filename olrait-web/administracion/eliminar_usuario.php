<?php
session_start();

include_once("../modelos/conexion.php");

function eliminarUsuarioPorId($id) {
  return ejecutarConsulta("DELETE FROM usuarios WHERE id='$id'");
}

if (!empty($_GET["id"])) {
  header("Location: canales.php");
}

header("Location: canales.php");

?>
