<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CobroValor extends Model
{
    protected $table = 'cobro_valores';

    public function cobro()
    {
        return $this->belongsTo(Cobro::class);
    }

    public function medio_pago()
    {
        return $this->belongsTo(MedioPago::class);
    }

    public function tarjeta()
    {
        return $this->hasOne(Tarjeta::class);
    }

    public function cheque()
    {
        return $this->hasOne(ChequeTercero::class);
    }

    public function deposito()
    {
        return $this->hasOne(Deposito::class);
    }

    protected $fillable  = [ 'cobro_id',
        'medios_pago_id',
        'importe',
    ];
}
