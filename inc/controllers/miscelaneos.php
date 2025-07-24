<?php
require_once '../../bootstrap.php';

use Models\CostoMiscelaneo;

class actualizarDolar
{
    public function update()
    {
        $ver = CostoMiscelaneo::all();
        $url = 'https://dolar.info/mexico/hoy/precio/banbajio.php';
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
        $html = curl_exec($handle);
        libxml_use_internal_errors(true); // Prevent HTML errors from displaying
        $resp_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if ($resp_code === 200) {
            $classname = "colCompraVenta";
            $doc = new DOMDocument();
            $doc->loadHTML($html);
            $a = new DOMXPath($doc);
            $nodes = $a->query("//div[@class='bienvenida']/text()[contains(., 'Venta:')]")->item(0)->data;
            $precio = str_replace('Venta: $', '', $nodes);
            // Verificar que el valor de $precio sea numérico y mayor a 0
            if (is_numeric($precio) && $precio > 0) {
                $cambio = (float)$precio + 0.50;

                $costo = CostoMiscelaneo::first();

                // Verificar si el valor de $costo->congelarDolar es false antes de actualizar
                if (!$costo->congelarDolar) {
                    $costo->update([
                        'precio_dollar' => (float)$cambio,
                        'fecha_precio_dollar' => date("Y-m-d H:i:s")
                    ]);
                }
            }
        }
    }
}
