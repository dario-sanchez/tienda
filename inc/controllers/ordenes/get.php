<?php

use Models\Orden;
use Models\Usuario;

require_once '../../bootstrap.php';

ob_start();
session_start();
http_response_code(500);
// $user = Usuario::findOrFail();
$query = Orden::query();

if (isset($_GET['orden'])) {
    if ($_SESSION['usuario_tipo'] === 1) {
        $query->where('usuario_id', $_SESSION['usuario_id']);
    }
    $data = $query->where('id', $_GET['orden'])
        ->with('articulos.producto', 'articulos.edicion', 'articulos.costo', 'articulos.edicionUpg', 'articulos.costoUpg', 'comprador', 'codigoDescuento')
        ->first();
} else {
    if ($_SESSION['usuario_tipo'] === 1) {
        $query->where('usuario_id', $_SESSION['usuario_id']);
    }
    $data = $query->with('articulos.producto', 'articulos.edicion', 'articulos.costo', 'articulos.edicionUpg', 'articulos.costoUpg', 'comprador', 'codigoDescuento')->orderBy('created_at', 'desc')->get();
}

if ($_SESSION['usuario_tipo'] == 2 && !isset($_GET['orden'])) {
    foreach ($data as $d) {
        $d->root = true;
    }
}

http_response_code(200);

echo json_encode($data, JSON_NUMERIC_CHECK);
ob_end_flush();
