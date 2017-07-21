<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class ComprobanteCompraRetenciones extends Model
{
    protected $table = 'comprobantes_compras_retenciones';

    public function comprobante_compra()
    {
        return $this->belongsTo(ComprobanteCompra::class);
    }

    public function tipo_retencion()
    {
        return $this->belongsTo(TipoRetencion::class);
    }

    protected $fillable  = [
        'comprobante_id',
        'retencion_id',
        'base_imponible',
        'alicuota',
        'importe'
    ];
}