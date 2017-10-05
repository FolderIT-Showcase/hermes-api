<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenPagoItem extends Model
{
    public function orden_pago()
    {
        return $this->belongsTo(OrdenPago::class);
    }

    public function comprobante_compra()
    {
        return $this->belongsTo(ComprobanteCompra::class);
    }

    protected $fillable  = [ 'orden_pago_id',
        'comprobante_compra_id',
        'descripcion',
        'importe',
        'descuento',
        'importe_total',
        'anticipo'
    ];
}
