<?php

use Models\CodigoDescuento;
use Illuminate\Database\Capsule\Manager as DB;

require_once '../../bootstrap.php';

ob_start();
session_start();
http_response_code(500);
$data=null;

if (isset($_GET['codigo'])) {
    $data = CodigoDescuento::where( DB::raw('upper(codigo)' ), strtoupper($_GET['codigo']) )->where('activo',1)->first();
    // $data = CodigoDescuento::where('codigo', 'LIKE', '%' . $_GET['codigo'] . '%')->where('activo',1)->first();
} else {
    $data = CodigoDescuento::where('activo',1)->get();    
}

http_response_code(200);

echo json_encode($data,JSON_NUMERIC_CHECK);
ob_end_flush();
