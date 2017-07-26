<?php

namespace App;


use App\Events\ComprobanteCompraCreated;
use Illuminate\Database\Eloquent\Model;

class ComprobanteCompra extends Model
{
    protected $table = 'comprobantes_compras';

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function tipo_comp_compras()
    {
        return $this->belongsTo(TipoComprobanteCompra::class);
    }

    public function periodo()
    {
        return $this->belongsTo(PeriodoFiscal::class);
    }

    public function comprobante_compra_importes()
    {
        return $this->hasOne(ComprobanteCompraImportes::class, 'comprobante_id', 'id');
    }


    public function comprobante_compra_retenciones()
    {
        return $this->hasMany(ComprobanteCompraRetenciones::class, 'comprobante_id', 'id');
    }

    protected $fillable  = [
        'proveedor_id',
        'tipo_comp_compras_id',
        'periodo_id',
        'fecha',
        'punto_venta',
        'numero',
        'proveedor_nombre',
        'proveedor_tipo_resp',
        'proveedor_cuit',
        'importe_total',
        'saldo',
        'anulado'
    ];

    protected $events = [
        'created' => ComprobanteCompraCreated::class,
    ];
}