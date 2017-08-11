<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CobroValor extends Model
{
    protected $table = 'cobro_valor';

    public function cobro()
    {
        return $this->belongsTo(Cobro::class);
    }

    public function medio_pago()
    {
        return $this->belongsTo(MedioPago::class);
    }

    protected $fillable  = [ 'cobro_id',
        'medio_pago_id',
        'importe',
    ];
}
