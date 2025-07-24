<?php
ini_set("memory_limit", "256M");
setlocale(LC_MONETARY, "es_MX");

include($_SERVER['DOCUMENT_ROOT'] . '/tienda/inc/bootstrap.php');

use Models\Orden;
use Dompdf\Dompdf;
use Dompdf\Options;
use Models\CostoMiscelaneo;

class Recibo
{
    public function generar($ordenId)
    {
        $orden = Orden::find($ordenId);
        $showBlock = ($orden->tipo_cotizacion != 2) ? '' : 'display:none;';
        $totalOrden = ($orden->tipo_cotizacion != 2) ? $orden->total : $orden->total_no_iva;
        $costos = CostoMiscelaneo::all()->first();
        // $fecha = strftime("%e de %B %Y");
        $formatter = new IntlDateFormatter('es_MX', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $fecha = $formatter->format(time());
        $host = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}";
        $opciones = new Options();
        $opciones->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($opciones);
        $codDesc = (!is_null($orden->codigoDescuento)) ? $orden->codigoDescuento->codigo . " - " . ($orden->codigoDescuento->monto * 100) . '%' : '<i>Ninguno</i>';


        $tbody = "";
        foreach ($orden->articulos as $articulo) {
            $tbody .= "
            <tr>
                <td>" . nl2br($articulo->desc_producto) . ((!is_null($orden->descuento_pack) && in_array($articulo->producto_id, [2, 4, 6])) ? "<br> <span style='font-weight:bold'>Descuento por pack: 10%</span>" : " ") . "</td>
                <td style='text-align:center;'>" . $articulo->cantidad . "</td>
                <td style='text-align:right;'>$" . number_format($articulo->costo_total, 2, ".", ",") . "</td>
                <td style='text-align:right;" . $showBlock . "'>$" . number_format(($articulo->costo_total * $costos->precio_dollar), 2, ".", ",") . "</td>
            </tr>
            ";
        }

        $rowDesc = "";
        if (!is_null($orden->codigoDescuento)) {
            $rowDesc = "
            <tr>
                <td></td>
                <td>Descuento por cupón</td>
                <td style='color:red;'> - $" . number_format($orden->descuento_cantidad, 2, '.', ',') . "</td>
                <td style='color:red;" . $showBlock . "'> - $" . number_format(($orden->descuento_cantidad * $costos->precio_dollar), 2, ".", ",") . "</td>
            </tr>";
        }

        $rowPack = "";
        if (!is_null($orden->descuento_pack)) {
            $rowPack = "
            <tr>
                <td></td>
                <td>Descuento de arma tu paquete</td>
                <td style='color:red;'> - $" . number_format($orden->descuento_pack, 2, '.', ',') . "</td>
                <td style='color:red;{$showBlock}'> - $ " . number_format(($orden->descuento_pack * $costos->precio_dollar), 2, '.', ',') . "</td>
            </tr>";
        }

        $html = "<!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <title>Recibo | TSPLUS</title>
            <style>
                #cotizacion, #cotizacion th, #cotizacion td {
                    border: 1px solid gray;
                    border-collapse: collapse;
                    padding: 5px;
                }
                #cotizacion th{
                    background-color: black;
                    color:white;
                }
            </style>
        </head>
        <body style='font-family:sans-serif;font-size:14px;'>
            <table style='width:100%; margin-bottom:15px;'>
                <tr>
                    <td style='width:70%'>
                        <img src='{$host}/image/logo.png' style='width: 200px;height:auto;'>
                    </td>
                    <td>
                        <strong>Fecha:</strong> {$fecha}<br>
                        <strong>Nombre:</strong> {$orden->comprador->nombre} {$orden->comprador->apellido}<br>
                        <strong>Orden</strong> #{$orden->id}
                    </td>
                </tr>
            </table>
        
            <table style='width:100%;' id='cotizacion'>
                <thead>
                    <tr>
                        <th style='width:55%'>Concepto</th>
                        <th style='width:15%'>Cantidad</th>
                        <th style='width:15%'>Precio (USD)</th>
                        <th style='width:15%;" . $showBlock . "'>Precio (MXN)</th>
                    </tr>
                </thead>
                <tbody>
                    {$tbody}
                </tbody>
                <tfoot style='text-align:right;font-weight:bold;background-color:#eee;'>
                    <tr>
                        <td></td>
                        <td>SubTotal antes de descuento</td>
                        <td>$" . number_format(($orden->subtotal), 2, ".", ",") . "</td>
                        <td style='" . $showBlock . "'>$" . number_format(($orden->subtotal * $costos->precio_dollar), 2, ".", ",") . "</td>
                    </tr>
                    " . $rowDesc . "
                    " . $rowPack . "
                    <tr style='" . $showBlock . "'>
                        <td></td>
                        <td>SubTotal</td>
                        <td>$" . number_format(($orden->subtotal - $orden->descuento_cantidad - $orden->descuento_pack), 2, ".", ",") . "</td>
                        <td style='" . $showBlock . "'>$" . number_format((($orden->subtotal - $orden->descuento_cantidad - $orden->descuento_pack) * $costos->precio_dollar), 2, ".", ",") . "</td>
                    </tr>
                    <tr style='" . $showBlock . "'>
                        <td></td>
                        <td>IVA</td>
                        <td>$" . number_format(($orden->iva), 2, ".", ",") . "</td>
                        <td>$" . number_format(($orden->iva * $costos->precio_dollar), 2, ".", ",") . "</td>
                    </tr>
                    <tr>
                        <td style='text-align:left;'>
                            <small>*Precios en USD 1x $" . number_format(($costos->precio_dollar), 2, ".", ",") . " MXN</small><br>
                            <span>Código descuento:" . $codDesc . "</span>
                        </td>
                        <td>Total</td>
                        <td>$" . number_format(($totalOrden), 2, ".", ",") . "</td>
                        <td style='" . $showBlock . "'>$" . number_format(($orden->total * $costos->precio_dollar), 2, ".", ",") . "</td>
                    </tr>
                </tfoot>
            </table>
            <div>
                <h3>Comentarios:</h3>
                <p> {$orden->comentarios} </p>
            </div>
            <hr>
            <div>
                <h3>Datos para Pago referenciado (Transferencia SPEI, Depósito en efectivo/cheque)</h3>
                <p>
                    Neogénesys, S.A. de C.V.<br> 
                    Banco del Bajio SA<br>
                    Cuenta Pesos: 101848440201<br>
                    CLABE: 030180900001492018<br>
                </p>
                <p>
                    Neogénesys, S.A. de C.V.<br>
                    Banco del Bajio SA<br>
                    Cuenta USD: 101848440401<br>
                    CLABE: 030180900001492034<br>
                </p>
                <h3>Al realizar el pago utilize la siguiente referencia: <span style='font-size:20px'>{$orden->referencia}</span></h3>
                <small>Si no se agrega al referencia no podrá verificarse su pago</small>
            </div>
            
        </body>
        </html>";
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->loadHtml($html);
        return $dompdf;
    }

    public function descargar($ordenId)
    {
        $pdf = $this->generar($ordenId);
        $pdf->render();
        return $pdf->stream("Cotización TSPlus", ["Attachment" => 0]);
    }

    public function getFile($ordenId)
    {
        $pdf = $this->generar($ordenId);
        $pdf->render();
        return $pdf->output();
    }
}
