<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cobro_items()
    {
        return $this->hasMany(CobroItem::class);
    }

    public function cobro_valores()
    {
        return $this->hasMany(CobroValor::class);
    }

    public function ctaCteCliente()
    {
        return $this->hasOne(CtaCteCliente::class);
    }

    public function punto_venta()
    {
        return $this->belongsTo(PuntoVenta::class, 'punto_venta');
    }

    protected $fillable  = [ 'cliente_id',
        'fecha',
        'punto_venta',
        'numero',
        'importe'
    ];
}
