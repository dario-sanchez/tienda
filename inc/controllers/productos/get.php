<?php
require_once '../../bootstrap.php';
require_once '../miscelaneos.php';

use Models\CodigoDescuento;
use Models\CostoMiscelaneo;
use Models\CostoProducto;
use Models\Edicion;
use Models\Producto;

ob_start();
session_start();
http_response_code(500);
$dllr = new actualizarDolar();
$dllr->update();

if (!isset($_GET['query'])) {
    exit('No se definio la consulta correctamente.');
}
$data = null;
switch ($_GET['query']) {
    case 'all':
        $data['productos'] = Producto::query()->orderBy('orden', 'asc')->get();
        $data['ediciones'] = Edicion::all();
        $data['costos'] = CostoProducto::all();
        $data['miscelaneos'] = CostoMiscelaneo::first();
        if ($_SESSION['usuario_tipo'] == 2) $data['codigos'] = CodigoDescuento::all();
        break;
    case 'productos':
        $data = Producto::all();
        break;
    case 'ediciones':
        if (!isset($_GET['producto'])) {
            exit('No se definio la consulta correctamente.');
        }
        $data = Edicion::where('producto_id', $_GET['producto'])->get();
        break;
    case 'modalidades':
        if (!isset($_GET['edicion'])) {
            exit('No se definio la consulta correctamente.');
        }
        $data = CostoProducto::where('edicion_id', $_GET['edicion'])->get();
        break;
}

http_response_code(200);
echo json_encode($data, JSON_NUMERIC_CHECK);
ob_end_flush();
