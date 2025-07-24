<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Edicion extends Model
{
    use SoftDeletes;


    protected $table = 'ediciones';
    protected $fillable = [
        'activo',
        'nombre',
        'orden',
        'producto_id',
    ];


    public function costos()
    {
        return $this->hasMany('Models\CostoProducto', 'edicion_id');
    }

    public function producto()
    {
        return $this->belongsTo('Models\Producto', 'producto_id');
    }
}
