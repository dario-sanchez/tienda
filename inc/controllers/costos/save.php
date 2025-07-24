<?php

use Models\CostoProducto;

require_once '../../bootstrap.php';

ob_start();
session_start();
http_response_code(500);
$input = json_decode(file_get_contents("php://input"));

if (is_null($input)) exit('Ocurrió un error');

$data = [
    'producto_id' => $input->producto_id,
    'edicion_id' => $input->edicion_id,
    'orden' => $input->orden,
    'num_usuarios' => $input->num_usuarios,
    'precio' => $input->precio,
];

$action = null;

try {
    if ($input->id === null) {
        $costo = CostoProducto::create($data);
        $action = 'create';
    } else {
        $costo = CostoProducto::findOrFail($input->id);
        $costo->update($data);
        $action = 'update';
    }
} catch (\Throwable $th) {
    exit('Ocurrió un error: ' . $th);
}

$response = [
    'message' => 'La información se guardo con éxito.',
    'costo' => $costo,
    'action' => $action
];

http_response_code(200);
echo json_encode($response, JSON_NUMERIC_CHECK);
ob_end_flush();
