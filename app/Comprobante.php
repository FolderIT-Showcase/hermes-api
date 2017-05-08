<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tipo_comprobante()
    {
        return $this->belongsTo(TipoComprobante::class);
    }

    public function items()
    {
        return $this->hasMany(ComproItem::class);
    }

    protected $fillable  = ['cliente_id',
        'tipo_comprobante_id',
        'fecha',
        'punto_venta',
        'numero',
        'cliente_nombre',
        'cliente_tipo_resp',
        'cliente_cuit',
        'importe_neto',
        'alicuota_iva',
        'importe_iva',
        'importe_total',
        'saldo',
        'cae',
        'fecha_cae',
        'fecha_venc_cae',
        'anulado'];
}
