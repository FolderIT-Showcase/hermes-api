<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParametroUsuario extends Model
{
    protected $table = 'parametros_usuario';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $fillable  = ['id',
        'user_id',
        'punto_venta'
    ];
}
