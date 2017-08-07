<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cuenta()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }

    protected $fillable  = ['cliente_id',
        'cuenta_id',
        'numero',
        'importe',
        'fecha_ingreso',
        'fecha_acreditacion',
        'fecha_deposito',
        'tipo',
        'descripcion'];
}
