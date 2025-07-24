<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class ArticuloOrden extends Model
{

    protected $table = 'articulos_ordenes';
    protected $fillable = [
        'orden_id',
        'tipo',
        'producto_id',
        'edicion_id',
        'costo_producto_id',
        'anos_actualizacion',
        'horas_soporte',
        'upg_edicion_id',
        'upg_costo_producto_id',
        'cantidad',
        'clave_activacion',
        'desc_producto',
        'precio'
    ];

    public function orden()
    {
        return $this->belongsTo('Models\Orden', 'orden_id');
    }
    public function producto()
    {
        return $this->hasOne('Models\Producto', 'id', 'producto_id');
    }
    public function edicion()
    {
        return $this->hasOne('Models\Edicion', 'id', 'edicion_id');
    }
    public function costo()
    {
        return $this->hasOne('Models\CostoProducto', 'id', 'costo_producto_id');
    }
    public function edicionUpg()
    {
        return $this->hasOne('Models\Edicion', 'id', 'upg_edicion_id');
    }
    public function costoUpg()
    {
        return $this->hasOne('Models\CostoProducto', 'id', 'upg_costo_producto_id');
    }
    public function getCostoTotalAttribute()
    {
        $costoTotal = 0;
        $costosMiscelaneos = CostoMiscelaneo::first();
        switch ($this->tipo) {
            case 1:
                $costoTotal = $this->costo->precio * $this->cantidad;
                if ($this->anos_actualizacion > 0) {
                    $costoTotal = $costoTotal * (1 + (($costosMiscelaneos['soporte_year_' . $this->anos_actualizacion] / 100) * $this->anos_actualizacion));
                }

                break;
            case 2:
                $costoTotal = $this->costo->precio * $this->cantidad;
                if ($this->anos_actualizacion > 0) {
                    $costoTotal = $costoTotal * (($costosMiscelaneos['soporte_year_' . $this->anos_actualizacion] / 100) * $this->anos_actualizacion);
                }
                break;
            case 3:
                $costoTotal = $this->costoUpg->precio - ($this->costo->precio + $this->costoUpg->precio) * 0.1;
                if ($this->anos_actualizacion > 0) {
                    $costoTotal = $costoTotal * (1 + (($costosMiscelaneos['soporte_year_' . $this->anos_actualizacion] / 100) * $this->anos_actualizacion));
                }
        }
        if ($this->horas_soporte > 0) {
            $costoTotal = $costoTotal + $costosMiscelaneos['soporte_hora_' . $this->horas_soporte];
        }
        return $costoTotal;
    }
}
