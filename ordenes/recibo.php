<?php
require_once '../inc/bootstrap.php';
require_once '../inc/controllers/ordenes/recibo.php';

use Models\Orden;
use Dompdf\Dompdf;
use Dompdf\Options;
http_response_code(500);
if( !isset( $_GET['orden'] ) ) exit('No hay orden especificada');

$orden = new Recibo();

$orden->descargar( $_GET['orden'] );

http_response_code(200);