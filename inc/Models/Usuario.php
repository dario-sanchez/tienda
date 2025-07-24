<?php

namespace Models;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model {

    protected $table = 'usuarios';
    protected $fillable = [
        'nombre',
        'apellido',
        'empresa',
        'clave',
        'email',
        'telefono',
        'direccion',
        'estado',
        'colonia',
        'ciudad',
        'zip',
        'pais',
        'rfc',
        'digitos',
        'pago',
        'moneda',
        'cupon',
        'tipo',
        'customer_openpay'
    ];
    protected $hidden = ['clave','customer_openpay','pago','digitos'];

    public function ordenes() {
        return $this->hasMany('Models\Edicion', 'producto_id');
    }
}