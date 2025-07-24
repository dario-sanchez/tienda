<?php

use Models\CostoMiscelaneo;

require_once '../../bootstrap.php';

ob_start();
session_start();
http_response_code(500);
$input = json_decode(file_get_contents("php://input"));

$costos = CostoMiscelaneo::findOrFail(1);
if (is_null($costos)) exit('Ocurrió un error');
if (is_null($input)) exit('Ocurrió un error');

$data = [
    'iva' => $input->iva,
    'soporte_year_1' => $input->actualizacion1,
    'soporte_year_2' => $input->actualizacion2,
    'soporte_year_3' => $input->actualizacion3,
    'soporte_hora_1' => $input->soporte1,
    'soporte_hora_5' => $input->soporte5,
    'soporte_hora_10' => $input->soporte10,
    'soporte_hora_20' => $input->soporte20,
    'congelarDolar' => $input->congelarDolar,
];

if ($input->congelarDolar) {
    $data['precio_dollar'] = $input->dolar;
}

try {
    $costos->update($data);
} catch (\Throwable $th) {
    exit('Ocurrió un error: ' . $th);
}

http_response_code(200);
echo 'La información se guardo con éxito.';
ob_end_flush();
