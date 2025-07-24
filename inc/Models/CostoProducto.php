<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CostoProducto extends Model
{
    use SoftDeletes;

    protected $table = 'costos_productos';
    protected $fillable = [
        'edicion_id',
        'producto_id',
        'num_usuarios',
        'orden',
        '2fa',
        'precio',
    ];


    public function producto()
    {
        return $this->belongsTo('Models\Producto', 'producto_id');
    }

    public function edicion()
    {
        return $this->belongsTo('Models\Edicion', 'edicion_id');
    }
}
