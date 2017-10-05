<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChequePropio extends Model
{
    protected $table = 'cheques_propios';

    public function cuenta_bancaria()
    {
        return $this->belongsTo(CuentaBancaria::class);
    }

    public function orden_pago_valor()
    {
        return $this->belongsTo(OrdenPagoValor::class);
    }

    protected $fillable  = [
        'cuenta_bancaria_id',
        'numero',
        'importe',
        'fecha_emision',
        'fecha_vencimiento',
        'destinatario',
        'descripcion',
        'cobro_valor_id'
    ];
}