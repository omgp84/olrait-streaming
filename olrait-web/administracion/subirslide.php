<?php
include_once("../modelos/conexion.php");

if (!empty($_POST) && !empty($_FILES["imagen"]) {
  if (move_uploaded_file($_FILES["imagen"]['tmp_name'], "../img/slides/$nombreSlide")) {
    echo "El fichero es válido y se subió con éxito.\n";
  } else {
    echo "¡Posible ataque de subida de ficheros!\n";
  }
  $_POST["imagen"] = $_FILES["imagen"]["name"];
  $consulta = "INSERT INTO slider (" . implode(",", array_keys($datos)) . ") VALUES ('" . implode("','", array_values($datos)) . "')";
  return ejecutarConsulta($consulta);
}
?>
