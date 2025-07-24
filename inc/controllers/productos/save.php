<?php

use Models\Producto;

require_once '../../bootstrap.php';

ob_start();
session_start();
http_response_code(500);
$input = json_decode(file_get_contents("php://input"));

if (is_null($input)) exit('Ocurrió un error');

$data = [
    'activo' => $input->activo,
    'nombre' => $input->nombre,
    'orden' => $input->orden,
    'por_usuario' => $input->por_usuario
];

$action = null;

try {
    if ($input->id === null) {
        $producto = Producto::create($data);
        $action = 'create';
    } else {
        $producto = Producto::findOrFail($input->id);
        $producto->update($data);
        $action = 'update';
    }
} catch (\Throwable $th) {
    exit('Ocurrió un error: ' . $th);
}

$response = [
    'message' => 'La información se guardo con éxito.',
    'producto' => $producto,
    'action' => $action
];

http_response_code(200);
echo json_encode($response, JSON_NUMERIC_CHECK);
ob_end_flush();
