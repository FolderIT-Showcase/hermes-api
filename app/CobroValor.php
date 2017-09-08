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
        return $this->belongsTo(MedioPago::class, 'medios_pago_id');
    }

    public function tarjetas()
    {
        return $this->hasMany(Tarjeta::class);
    }

    public function cheques()
    {
        return $this->hasMany(ChequeTercero::class);
    }

    public function depositos()
    {
        return $this->hasMany(Deposito::class);
    }

    protected $fillable  = [ 'cobro_id',
        'medios_pago_id',
        'importe',
    ];
}
