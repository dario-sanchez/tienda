<?php

use Models\Usuario;

require_once '../../bootstrap.php';

ob_start();
session_start();
http_response_code(500);
// $user = Usuario::findOrFail();
$data = Usuario::find($_SESSION['usuario_id']);
if( is_null($data) ) exit('Ocurrio un error');
http_response_code(200);

echo json_encode($data,JSON_NUMERIC_CHECK);
ob_end_flush();
