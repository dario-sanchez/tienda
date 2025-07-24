<?php

use Models\CodigoDescuento;

require_once '../../bootstrap.php';

ob_start();
session_start();
http_response_code(500);
$input = json_decode(file_get_contents("php://input"));

if (is_null($input)) exit('Ocurrió un error');

$data = [
    'codigo' => $input->codigo,
    'monto' => $input->monto,
    'activo' => $input->activo,
];

$action = null;

try {
    if ($input->id === null) {
        $codigo = CodigoDescuento::create($data);
        $action = 'create';
    } else {
        $codigo = CodigoDescuento::findOrFail($input->id);
        $codigo->update($data);
        $action = 'update';
    }
} catch (\Throwable $th) {
    exit('Ocurrió un error: ' . $th);
}

$response = [
    'message' => 'La información se guardo con éxito.',
    'codigo' => $codigo,
    'action' => $action
];

http_response_code(200);
echo json_encode($response, JSON_NUMERIC_CHECK);
ob_end_flush();
