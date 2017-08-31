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

    protected $fillable  = [ 'cliente_id',
        'fecha',
        'punto_venta',
        'numero',
        'importe'
    ];
}
