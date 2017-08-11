<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CobroItem extends Model
{
    public function cobro()
    {
        return $this->belongsTo(Cobro::class);
    }

    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class);
    }

    protected $fillable  = [ 'cobro_id',
        'comprobante_id',
        'descripcion',
        'importe',
        'descuento',
        'importe_total',
        'anticipo'
    ];
}
