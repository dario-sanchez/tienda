<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodigoDescuento extends Model
{
    use SoftDeletes;


    protected $table = 'codigos_descuento';
    protected $fillable = [
        'codigo',
        'monto',
        'activo',
    ];


    public function orden()
    {
        return $this->hasMany('Models\Orden', 'codigo_descuento_id');
    }
}
