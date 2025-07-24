<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;


    protected $table = 'productos';
    protected $fillable = [
        'activo',
        'nombre',
        'orden',
        'por_usuario'
    ];

    public function ediciones()
    {
        return $this->hasMany('Models\Edicion', 'producto_id');
    }

    public function costos()
    {
        return $this->hasMany('Models\CostoProducto', 'producto_id');
    }
}
