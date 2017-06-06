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

    protected $fillable  = ['cliente_id',
        'tipo_comprobante_id',
        'comprobante_id',
        'fecha',
        'descripcion',
        'debe',
        'haber',
        ];
}
