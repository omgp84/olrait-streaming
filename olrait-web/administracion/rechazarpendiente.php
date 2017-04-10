<?php
session_start();

include_once("../modelos/conexion.php");

function eliminarUsuarioPorId($id) {
  return ejecutarConsulta("DELETE FROM usuarios_pendientes WHERE id='$id'");
}

if (!empty($_GET["id"])) {
  eliminarUsuarioPorId($_GET["id"]);
}

header("Location: canalespendientes.php");

?>
