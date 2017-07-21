<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class ComprobanteCompraImportes extends Model
{
    protected $table = 'comprobantes_compras_importes';

    public function comprobante()
    {
        return $this->belongsTo(ComprobanteCompra::class);
    }

    protected $fillable  = [
        'comprobante_id',
        'importe_neto_gravado',
        'importe_neto_no_gravado',
        'alicuota_iva',
        'importe_iva'
    ];
}