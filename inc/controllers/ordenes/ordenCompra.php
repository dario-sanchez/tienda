<?php

include($_SERVER['DOCUMENT_ROOT'] . '/tienda/inc/bootstrap.php');

use Models\ArticuloOrden;
use Models\CodigoDescuento;
use Models\Orden;
use Models\CostoMiscelaneo;
use Models\CostoProducto;
use Models\Edicion;
use Models\Producto;

class OrdenCompra
{
    public function guardar($input)
    {
        $orden = null;
        $subtotal = null;
        $costos = CostoMiscelaneo::all()->first();

        //se inicailiza la orden basica
        $data = [
            'tipo_cotizacion' => $input->tipo_cotizacion,
            'estatus' => 1,
            'usuario_id' => $_SESSION['usuario_id'],
            'precio_usd' => $costos->precio_dollar,
        ];
        if (isset($input->comentarios)) $data['comentarios'] = $input->comentarios;

        if (!isset($input->id)) {
            $data['referencia'] = $this->random_strings(8);
            $orden = Orden::create($data);
        } else {
            $orden = Orden::findOrFail($input->id);
            $orden->update($data);
        }

        //se guardan los articulos de la orden
        $articulosConservados = [];
        foreach ($input->articulos as $articulo) {

            $precioArt = null;
            $producto = Producto::find($articulo->producto_id);
            $edicion = Edicion::find($articulo->edicion_id);
            $costo = CostoProducto::find($articulo->costo_id);
            $costoUp = null;
            $costoAct = null;
            $costoSop = null;
            $descripcion = '';


            if ($articulo->tipo == 2) $descripcion .= "Renovación: ";
            if ($articulo->tipo == 3) $descripcion .= "Upgrade de producto:\r\n";

            $descripcion .= $producto->nombre;
            if (!is_null($edicion)) $descripcion .= ' - ' . $edicion->nombre;
            if (!is_null($costo->num_usuarios)) $descripcion .= ' - ' . (($costo->num_usuarios > 0) ? 'Licencia para ' . $costo->num_usuarios . ' usuarios.' : 'Licencia para usuarios ilimitados.') . ' - $' . number_format(($articulo->tipo == 2 ? 0 : $costo->precio), 2, ".", ",");


            if ($articulo->tipo == 3) {
                $edicionUp = Edicion::find($articulo->upg_edicion_id);
                $costoUp = CostoProducto::find($articulo->upg_costo_id);

                $descripcion .= "\r\n";
                $descripcion .= "A nueva configuración:\r\n";
                $descripcion .= $producto->nombre;
                if (!is_null($edicionUp)) $descripcion .= ' - ' . $edicionUp->nombre;
                if (!is_null($costoUp->num_usuarios)) $descripcion .= ' - ' . (($costoUp->num_usuarios > 0) ? 'Licencia para ' . $costoUp->num_usuarios . ' usuarios.' : 'Licencia para usuarios ilimitados.') . ' - $' . number_format($costoUp->precio, 2, ".", ",");
            }

            if ($articulo->actualizacion_years > 0) {
                $costoAct = $costos['soporte_year_' . $articulo->actualizacion_years];
                $descripcion .= "\r\n";
                $descripcion .= "Actualizacion: " . $articulo->actualizacion_years . " años";

                if ($articulo->tipo != 3) $descripcion .= " - $" . number_format(($costo->precio * $articulo->cantidad) * (($costoAct / 100) * $articulo->actualizacion_years), 2, ".", ",");

                if ($articulo->tipo == 3) {
                    $costUp = ($costoUp->precio * ($costoAct / 100)) * $articulo->actualizacion_years;
                    $descripcion .= " - $" . number_format($costUp, 2, ".", ",");
                }
            }

            if ($articulo->soporte_hours > 0) {

                if ($input->orden_antigua || is_null($input->orden_antigua)) {
                    $costoSop = $costos['soporte_hora_1'] * $articulo->soporte_hours;
                } else {
                    $costoSop = $costos['soporte_hora_' . $articulo->soporte_hours];
                }

                $descripcion .= "\r\n";
                $descripcion .= "Soporte: " . $articulo->soporte_hours . " horas - $" . number_format($costoSop, 2, ".", ",");
            }

            if ($articulo->tipo == 1)
                $precioArt = ($costo->precio * $articulo->cantidad);
            if ($articulo->tipo == 2)
                $precioArt = ($costo->precio * $articulo->cantidad);
            if ($articulo->tipo == 3)
                $precioArt = ($costoUp->precio - $costo->precio) * 1.1;


            switch ($articulo->tipo) {
                case 1:
                    $precioArt += ($precioArt * ($costoAct / 100)) * $articulo->actualizacion_years;

                    break;
                case 2:
                    $precioArt = ($precioArt * ($costoAct / 100)) * $articulo->actualizacion_years;
                    break;

                case 3:
                    $precioArt += ($costoUp->precio * ($costoAct / 100)) * $articulo->actualizacion_years;
                    break;
            }

            $precioArt += $costoSop;

            $art = [
                'tipo' => $articulo->tipo,
                'producto_id' => $articulo->producto_id,
                'edicion_id' => $articulo->edicion_id,
                'costo_producto_id' => $articulo->costo_id,
                'anos_actualizacion' => $articulo->actualizacion_years,
                'horas_soporte' => $articulo->soporte_hours,
                'cantidad' => $articulo->cantidad,
                'clave_activacion' => $articulo->clave,
                'desc_producto' => $descripcion,
                'precio' => $precioArt,
            ];

            if ($articulo->tipo == 3) {
                $art['upg_edicion_id'] = $articulo->upg_edicion_id;
                $art['upg_costo_producto_id'] = $articulo->upg_costo_id;
            };

            if (!isset($articulo->id)) {
                $articulosConservados[] = $orden->articulos()->create($art)->id;
            } else {
                $articulosConservados[] = $articulo->id;
                ArticuloOrden::find($articulo->id)->update($art);
            }

            $subtotal = $subtotal + $art['precio'];
        }
        // exit($subtotal);
        ArticuloOrden::where('orden_id', $orden->id)->whereNotIn('id', $articulosConservados)->delete();

        //se guardan los totales de la orden
        $orden->update(['subtotal' => $subtotal]);

        if (!is_null($input->cupon_id)) {
            $codDescuento = CodigoDescuento::find($input->cupon_id);

            $orden->update(['codigo_descuento_id' => $codDescuento->id]);
            $orden->update(['descuento_porcentaje' => $codDescuento->monto * 100]);
            $orden->update(['descuento_cantidad' => $subtotal * $codDescuento->monto]);
            $subtotal = $subtotal - $orden->descuento_cantidad;
        }

        $pack = false;
        if ($orden->articulos->contains('producto_id', 1)) $pack = true;
        $orden->update(['pack' => $pack]);

        $descPack = null;
        if ($orden->fresh()->pack) {
            foreach ($orden->articulos as $articulo) {
                if (in_array($articulo->producto_id, [2, 4, 6])) $descPack += ($articulo->precio * .1);
            }
        }
        $orden->update(['descuento_pack' => $descPack]);
        $subtotal = $subtotal - $descPack;


        $orden->update(['iva_porcentaje' => $costos->iva]);
        $orden->update(['iva' => $subtotal * ($costos->iva / 100)]);
        $orden->update(['total_no_iva' => $subtotal]);
        $orden->update(['total' => $subtotal + ($subtotal * ($costos->iva / 100))]);

        return $orden;
    }

    public function ver($ordenId)
    {
        $orden = Orden::where('id', $ordenId)->where('usuario_id', $_SESSION['usuario_id']);
        return $orden;
    }

    public function borrar($ordenId) {}

    private function random_strings($length_of_string)
    {
        // md5 the timestamps and returns substring
        // of specified length
        return substr(md5(time()), 0, $length_of_string);
    }
}
