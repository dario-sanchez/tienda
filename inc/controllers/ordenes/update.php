<?php
require_once '../../bootstrap.php';
require_once './ordenCompra.php';
ob_start();
session_start();
http_response_code(500);

$input = json_decode(file_get_contents("php://input"));
if( is_null($input) ) exit('Orden no especificada');
if( !count($input->articulos) ) exit('Orden vacia');

$ordenCompra = new OrdenCompra();
$response = $ordenCompra->guardar($input);

http_response_code(200);
echo 'La información se guardo con éxito.';
ob_end_flush();
