<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cobro extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    protected $fillable  = [ 'cliente_id',
        'fecha',
        'punto_venta',
        'numero',
        'importe'
    ];
}
