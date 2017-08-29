<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CtaCteCliente extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tipo_comprobante()
    {
        return $this->belongsTo(TipoComprobante::class);
    }

    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class);
    }

    public function cobro()
    {
        return $this->belongsTo(Cobro::class);
    }

    protected $fillable  = ['cliente_id',
        'tipo_comprobante_id',
        'comprobante_id',
        'cobro_id',
        'fecha',
        'descripcion',
        'debe',
        'haber',
        ];
}
