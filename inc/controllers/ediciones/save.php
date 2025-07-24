<?php

use Models\Edicion;

require_once '../../bootstrap.php';

ob_start();
session_start();
http_response_code(500);
$input = json_decode(file_get_contents("php://input"));

if (is_null($input)) exit('Ocurrió un error');

$data = [
    'producto_id' => $input->producto_id,
    'nombre' => $input->nombre,
    'orden' => $input->orden,
    'activo' => $input->activo,
];

$action = null;

try {
    if ($input->id === null) {
        $edicion = Edicion::create($data);
        $action = 'create';
    } else {
        $edicion = Edicion::findOrFail($input->id);
        $edicion->update($data);
        $action = 'update';
    }
} catch (\Throwable $th) {
    exit('Ocurrió un error: ' . $th);
}

$response = [
    'message' => 'La información se guardo con éxito.',
    'edicion' => $edicion,
    'action' => $action
];

http_response_code(200);
echo json_encode($response, JSON_NUMERIC_CHECK);
ob_end_flush();
