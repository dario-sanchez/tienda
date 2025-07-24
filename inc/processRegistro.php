<?php
ob_start();
include('./conexion.php');

// creamos una función que nos parmita validar el email
function valida_email($correo)
{
	if (preg_match('/^[A-Za-z0-9-_.+%]+@[A-Za-z0-9-.]+\.[A-Za-z]{2,4}$/', $correo)) return true;
	else return false;
}

function validaRFC($valor)
{
	$valor = str_replace("-", "", $valor);
	$cuartoValor = substr($valor, 3, 1);
	//RFC Persona Moral. 
	if (ctype_digit($cuartoValor) && strlen($valor) == 12) {
		$letras = substr($valor, 0, 3);
		$numeros = substr($valor, 3, 6);
		$homoclave = substr($valor, 9, 3);
		if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) {
			return true;
		}
		//RFC Persona Física. 
	} else if (ctype_alpha($cuartoValor) && strlen($valor) == 13) {
		$letras = substr($valor, 0, 4);
		$numeros = substr($valor, 4, 6);
		$homoclave = substr($valor, 10, 3);
		if (ctype_alpha($letras) && ctype_digit($numeros) && ctype_alnum($homoclave)) {
			return true;
		}
	} else {
		return false;
	}
}

// Procedemos a comprobar que los campos del formulario no estén vacíos
$sin_espacios = count_chars($_POST['nombre'], 1);
if (!empty($sin_espacios[32])) { // comprobamos que el campo nombre no tenga espacios en blanco
	echo "El campo <em>nombre</em> no debe contener espacios en blanco. <a href='javascript:history.back();'>Reintentar</a>";
} elseif (empty($_POST['nombre'])) { // comprobamos que el campo nombre no esté vacío
	echo "No haz ingresado tu usuario. <a href='javascript:history.back();'>Reintentar</a>";
} elseif (empty($_POST['apellido'])) { // comprobamos que el campo usuario_clave no esté vacío
	echo "No haz ingresado tu apellido. <a href='javascript:history.back();'>Reintentar</a>";
} elseif (empty($_POST['password'])) { // comprobamos que el campo password no esté vacío
	echo "No haz ingresado contraseña. <a href='javascript:history.back();'>Reintentar</a>";
} elseif ($_POST['password'] != $_POST['passwordConf']) { // comprobamos que las contraseñas ingresadas coincidan
	echo "Las contraseñas ingresadas no coinciden. <a href='javascript:history.back();'>Reintentar</a>";
} elseif (!valida_email($_POST['usuario_email'])) { // validamos que el email ingresado sea correcto
	echo "El email ingresado no es válido. <a href='javascript:history.back();'>Reintentar</a>";
} else {
	// "limpiamos" los campos del formulario de posibles códigos maliciosos
	$nombre = $mysqli->real_escape_string($_POST['nombre']);
	$empresa_nombre = $mysqli->real_escape_string($_POST['empresa_nombre']);
	$usuario_clave = $mysqli->real_escape_string($_POST['password']);
	$usuario_email = $mysqli->real_escape_string($_POST['usuario_email']);
	//$rfc = $mysqli->real_escape_string($_POST['rfc']);	//Eliminado del form
	$apellido = $_POST['apellido'];
	$estado = $_POST['estado'];
	$ciudad = $_POST['ciudad'];
	$colonia = $_POST['colonia'];
	$pais = $_POST['pais'];
	$direccion = $_POST['direccion'];
	$telefono = $_POST['telefono'];
	$zip = $_POST['zip'];
	//$digitos = $_POST['digitos'];							//Eliminado del form
	//$pago = $_POST['pago'];								//Eliminado del form
	//$moneda = $_POST['moneda'];							//Eliminado del form
	$cupon = $_POST['cupon'];

	// comprobamos que el usuario ingresado no haya sido registrado antes
	$sql = $mysqli->query("SELECT email FROM usuarios WHERE email='" . $usuario_email . "'");
	if (mysqli_num_rows($sql) > 0) {
		echo "<script type=\"text/javascript\">alert('El Correo  elegido ya ha sido registrado anteriormente.'); window.location='/tienda/registro.php';</script>";
	}
	$usuario_clave = md5($usuario_clave);
	// encriptamos la contraseña ingresada con md5
	// ingresamos los datos a la BD
	$reg = $mysqli->query("INSERT INTO usuarios 
					(nombre, clave, email, 
					apellido, empresa, telefono, 
					direccion, estado, colonia, 
					ciudad, zip, pais, cupon) 
					VALUES ('" . $nombre . "', '" . $usuario_clave . "', '" . $usuario_email . "', '"
		. $apellido . "', '" . $empresa_nombre . "','" . $telefono . "','"
		. $direccion . "', '" . $estado . "','" . $colonia . "', '"
		. $ciudad . "','" . $zip . "' ,'" . $pais . "', '" . $cupon . "')");

	if ($reg) {
		echo "<script type=\"text/javascript\">alert('Se ha registrado exitosamente!'); window.location='/tienda';</script>";
	} else {
		echo $mysqli->affected_rows;
		// echo "<script type=\"text/javascript\">alert('ha ocurrido un error y no se registraron los datos.'); //window.location='/tienda/registro.php';</script>";
	}
}
ob_end_flush();
