<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function cuenta()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }

    public function cobro_valor()
    {
        return $this->belongsTo(CobroValor::class);
    }

    public function orden_pago_valor()
    {
        return $this->belongsTo(OrdenPagoValor::class);
    }

    protected $fillable  = ['cliente_id',
        'cuenta_id',
        'numero',
        'importe',
        'fecha_ingreso',
        'fecha_acreditacion',
        'fecha_deposito',
        'tipo',
        'descripcion',
        'cobro_valor_id',
        'orden_pago_valor_id',
        'proveedor_id',
    ];
}
