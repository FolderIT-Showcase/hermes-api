<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    protected $table = 'cuentas_bancarias';

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    protected $fillable  = [
        'banco_id',
        'tipo',
        'numero'];
}
