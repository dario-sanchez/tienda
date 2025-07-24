<?php

use Models\CodigoDescuento;

require_once '../../bootstrap.php';

ob_start();
session_start();
http_response_code(500);
if ($_SESSION['usuario_tipo'] != 2) exit('Ocurrió un error');

CodigoDescuento::findOrFail($_GET['codigo'])->delete();

$response = [
    'message' => 'El codigo se borro correctamente.'
];

http_response_code(200);
echo json_encode($response, JSON_NUMERIC_CHECK);
ob_end_flush();
