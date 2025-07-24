<?php
require_once '../../bootstrap.php';
require_once './ordenCompra.php';

ob_start();
session_start();
http_response_code(500);

$orden = json_decode(file_get_contents("php://input"));
if( is_null($orden) ) exit('Orden no especificada');
if( !count($orden->articulos) ) exit('Orden vacia');

$ordenCompra = new OrdenCompra();
$response = $ordenCompra->guardar($orden);

http_response_code(200);
echo json_encode( $response );
ob_end_flush();

