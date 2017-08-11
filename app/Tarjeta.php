<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tipo_tarjeta()
    {
        return $this->belongsTo(TipoTarjeta::class, 'tarjeta_id');
    }

    protected $fillable  = ['cliente_id',
        'tarjeta_id',
        'importe',
        'fecha_ingreso',
        'fecha_acreditacion',
        'estado',
        'descripcion'];
}
