<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orden extends Model
{
    use SoftDeletes;

    protected $table = 'ordenes';
    protected $fillable = [
        'tipo_cotizacion',
        'estatus',
        'usuario_id',
        'subtotal',
        'iva',
        'iva_porcentaje',
        'codigo_descuento_id',
        'descuento_porcentaje',
        'descuento_cantidad',
        'total_no_iva',
        'total',
        'pago_id',
        'metodo_pago',
        'fecha_pago',
        'referencia',
        'pack',
        'descuento_pack',
        'comentarios',
        'orden_antigua',
    ];

    public function comprador()
    {
        return $this->belongsTo('Models\Usuario', 'usuario_id');
    }

    public function articulos()
    {
        return $this->hasMany('Models\ArticuloOrden', 'orden_id');
    }

    public function codigoDescuento()
    {
        return $this->hasOne('Models\CodigoDescuento', 'id', 'codigo_descuento_id');
    }
}
