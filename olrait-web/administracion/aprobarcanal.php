<?php
session_start();

// include_once('../modelos/conexion.php');

function aprobarCanal($id) {
	$servidor = "localhost";
	$usuario = "root";
	$contrasena = "";
	$baseDeDatos = "olrait";
	$enlace = mysqli_connect($servidor, $usuario, $contrasena, $baseDeDatos);
	if (mysqli_connect_errno()) die("Error de conexión: " . mysqli_connect_error());

	$consulta = "INSERT INTO usuarios SELECT * FROM usuarios_pendientes WHERE id='$id'";
	mysqli_set_charset($enlace, 'utf8');
	mysqli_begin_transaction($enlace);
	mysqli_query($enlace, $consulta);
	$consulta = "DELETE FROM usuarios_pendientes WHERE id='$id'";
	mysqli_query($enlace, $consulta);
	$resultado = mysqli_commit($enlace);
	mysqli_close($enlace);
	return $resultado;
}

$id = (!empty($_GET['id'])) ? $_GET['id'] : false;

if ($id) {
	echo aprobarCanal($id);
	header('Location: canalespendientes.php');
}

?>
