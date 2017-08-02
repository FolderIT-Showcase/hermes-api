<?php

namespace App;

use App\Events\ComprobanteCreated;
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

    public function listaPrecios()
    {
        return $this->belongsTo(ListaPrecios::class, 'lista_id');
    }

    public function items()
    {
        return $this->hasMany(ComproItem::class);
    }

    public function ctaCteCliente()
    {
        return $this->hasOne(CtaCteCliente::class);
    }

    public function forma_pago()
    {
        return $this->belongsTo(TipoFormaPago::class);
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
        'anulado',
        'lista_id',
        'forma_pago_id'];

    protected $events = [
        'created' => ComprobanteCreated::class,
    ];
}
