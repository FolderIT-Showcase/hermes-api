<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CtaCteProveedor extends Model
{
    protected $table = 'cta_cte_proveedores';

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function tipo_comp_compras()
    {
        return $this->belongsTo(TipoComprobanteCompra::class);
    }

    public function comprobante_compras()
    {
        return $this->belongsTo(ComprobanteCompra::class);
    }

    protected $fillable  = [
        'proveedor_id',
        'tipo_comp_compras_id',
        'comprobante_compras_id',
        'fecha',
        'descripcion',
        'debe',
        'haber',
    ];
}