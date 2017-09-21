<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenPago extends Model
{
    protected $table = 'ordenes_pago';

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function orden_pago_items()
    {
        return $this->hasMany(OrdenPagoItem::class);
    }

    public function orden_pago_valores()
    {
        return $this->hasMany(OrdenPagoValor::class);
    }

    public function cta_cte_proveedor()
    {
        return $this->hasOne(CtaCteProveedor::class);
    }

    protected $fillable  = [ 'proveedor_id',
        'fecha',
//        'punto_venta',
//        'numero',
        'importe'
    ];
}
