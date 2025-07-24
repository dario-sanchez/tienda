<?php
require_once 'bootstrap.php';
use Models\Usuario;

ob_start();
session_start();
http_response_code(500);

//sanitizado
$email = filter_var( trim( $_POST['email'] ), FILTER_VALIDATE_EMAIL);
$pass = trim( $_POST['password'] );

//encodeo de password
$pass = md5($pass);
$usuario = Usuario::where('email',$email)->where('clave',$pass)->first();
if(is_null($usuario)) exit('Datos de inicio de sesión incorrectos.');


$_SESSION['usuario_id'] = $usuario->id; // creamos la sesion "usuario_id" y le asignamos como valor el campo usuario_id
$_SESSION['usuario_tipo'] = $usuario->tipo; // creamos la sesion "usuario_id" y le asignamos como valor el campo usuario_id
$_SESSION['usuario_nombre'] = $usuario->nombre.' '.$usuario->apellido; // creamos la sesion "usuario_email" y le asignamos como valor el campo usuario_email
$_SESSION['usuario_email'] = $usuario->email; // creamos la sesion "usuario_email" y le asignamos como valor el campo usuario_email
$response = 'Loggin exitoso';
http_response_code(200);

echo json_encode([$response],JSON_NUMERIC_CHECK);
ob_end_flush();