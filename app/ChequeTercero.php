<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChequeTercero extends Model
{
    protected $table = 'cheques_terceros';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    protected $fillable  = ['nombre',
        'cliente_id',
        'banco_id',
        'sucursal',
        'numero',
        'nro_interno',
        'importe',
        'fecha_emision',
        'fecha_ingreso',
        'fecha_vencimiento',
        'fecha_cobro',
        'origen',
        'destinatario',
        'estado',
        'descripcion'];
}
