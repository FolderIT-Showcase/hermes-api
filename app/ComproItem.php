<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComproItem extends Model
{
    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class);
    }

    public function articulo()
    {
        return $this->hasOne(Articulo::class);
    }

    protected $fillable  = ['comprobante_id',
         'articulo_id',
         'cantidad',
         'importe_unitario',
         'costo_unitario',
         'importe_total',
         'importe_neto',
         'alicuota_iva',
         'importe_iva'
    ];
}
