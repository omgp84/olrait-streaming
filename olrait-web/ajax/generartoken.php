<?php
include_once("../modelos/conexion.php");

$usuario = (!empty($_POST["usuario"])) ? $_POST["usuario"] : false;
$token = (!empty($_POST["token"])) ? $_POST["token"] : false;
$tokenDB = hacerlistado("SELECT token FROM usuarios WHERE nombre_usuario='$usuario'")[0]["token"];

if ($tokenDB == $token) {
  $tokenNuevo = bin2hex(openssl_random_pseudo_bytes(16));
  $tokenCreado = date('Y-m-d G:i:s');
  if (ejecutarConsulta("UPDATE usuarios SET token='$tokenNuevo',token_creado='$tokenCreado' WHERE nombre_usuario='$usuario'")) {
    setcookie('token', $tokenNuevo, time()+60*60*24*30, '/');
    setcookie('usuario', $_POST["usuario"], time()+60*60*24*30, '/');
    echo $tokenNuevo;
  }
} else {
  echo false;
}
?>
