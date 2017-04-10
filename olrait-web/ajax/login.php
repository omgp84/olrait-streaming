<?php
session_start();

include_once("../lib/functions.php");
include_once("../modelos/conexion.php");

$nombreUsuario = (!empty($_POST["nombre_usuario"])) ? $_POST["nombre_usuario"] : "";
$contrasena = (!empty($_POST["contrasena"])) ? sha1($_POST["contrasena"]) : "";
$usuario = hacerListado("SELECT * FROM usuarios WHERE nombre_usuario='$nombreUsuario' AND contrasena='$contrasena'");

if ($usuario) {
  $_SESSION["usuario"] = $usuario[0];
  $token = bin2hex(openssl_random_pseudo_bytes(16));
  $tokenCreado = date('Y-m-d G:i:s');
  if (ejecutarConsulta("UPDATE usuarios SET token='$token',token_creado='$tokenCreado' WHERE id='" . $usuario[0]['id'] . "'")) {
    setcookie('token', $token, time()+60*60*24*30, '/');
    setcookie('usuario', $_SESSION['usuario']['nombre_usuario'], time()+60*60*24*30, '/');
    echo true;
  }
} else {
  echo false;
}
?>
