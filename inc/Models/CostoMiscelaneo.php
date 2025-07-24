<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class CostoMiscelaneo extends Model
{

    protected $table = 'costos_miscelaneos';
    protected $fillable = [
        'precio_dollar',
        'fecha_precio_dollar',
        'iva',
        'soporte_year_1',
        'soporte_year_2',
        'soporte_year_3',
        'soporte_hora_1',
        'soporte_hora_5',
        'soporte_hora_10',
        'soporte_hora_20',
        'congelarDolar',
    ];
}
