<?php

use Models\Usuario;

require_once '../../bootstrap.php';
ob_start();
session_start();
http_response_code(500);

$usuario = Usuario::find($_SESSION['usuario_id']);
if (is_null($usuario)) exit('Ocurrió un error');

$data = [
    'nombre' => $_POST['nombre'],
    'apellido' => $_POST['apellido'],
    'empresa' => $_POST['empresa_nombre'],
    'telefono' => $_POST['telefono'],
    'direccion' => $_POST['direccion'],
    'estado' => $_POST['estado'],
    'colonia' => $_POST['colonia'],
    'ciudad' => $_POST['ciudad'],
    'zip' => $_POST['zip'],
    'pais' => $_POST['pais'],
    'cupon' => $_POST['cupon'],
];

if ($_POST['password'] != '') $data['clave'] = md5( $_POST['password'] );
$usuario->update($data);
http_response_code(200);
echo 'La información se guardo con éxito.';
ob_end_flush();
