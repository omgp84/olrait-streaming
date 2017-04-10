<?php

// include_once("../../modelos/conexion.php");

function comprobarErroresRegistro($datos) {
	if (empty($datos["nombre_usuario"])) {
		return "Debe completar el nombre de usuario";
	}
	if ((count(hacerListado("SELECT id FROM usuarios WHERE nombre_usuario='" . $datos['nombre_usuario'] . "'")) > 0) ||
		(count(hacerListado("SELECT id FROM usuarios_pendientes WHERE nombre_usuario='" . $datos['nombre_usuario'] . "'")) > 0)) {
		return "Ese nombre de usuario ya existe";
	}
	if (empty($datos["nombre"])) {
		return "Debe completar el nombre";
	}
	if (empty($datos["correo"])) {
		return "Debe proporcionar una dirección de correo electrónico.";
	}
	if ((count(hacerListado("SELECT id FROM usuarios WHERE correo='" . $datos['correo'] . "'")) > 0) ||
		(count(hacerListado("SELECT id FROM usuarios_pendientes WHERE correo='" . $datos['correo'] . "'")) > 0)) {
		return "Ese correo electrónico ya existe";
	}
	if(empty($datos['contrasena'])) {
		return "Debe introducir una contraseña.";
	}
	if($datos['contrasena'] != $datos['verifica_contrasena']){
		return "Las contraseñas no coinciden.";
	}
	if (empty($datos['titulo_canal'])) {
		return "Debe introducir un título para el canal";
	}
	if (empty($datos['descripcion_canal'])) {
		return "Debe introducir una descripción para el canal";
	}
	return false;
}

function guardarUsuario($datos) {
	unset($datos["verifica_contrasena"]);
	$datos["contrasena"] = cifrarContrasena($datos["contrasena"]);
	$consulta = "INSERT INTO usuarios_pendientes (" . implode(", ", array_keys($datos)) . ") VALUES ('" . implode("', '", array_values($datos)) . "')";
	ejecutarConsulta($consulta);
	$id = hacerListado("SELECT MAX(id) AS id FROM usuarios_pendientes")[0]["id"];
	echo aprobarUsuario($id);
}

function cifrarContrasena($contrasena) {
	return sha1($contrasena);
}

if (comprobarErroresRegistro($_POST) != false) {
	echo '{"error": "' . $resultado . '"}';
} else {
	if(guardarUsuario($_POST) != false) {
		echo '{"error": false, "res": "' . $_POST['nombre_usuario'] . '"}';
	} else {
		echo '{"error": "true"}';
	}
}

function aprobarUsuario($id) {
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

?>
