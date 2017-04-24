<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    public function subrubros()
    {
        return $this->hasMany(Subrubro::class);
    }

    protected $fillable  = ['codigo', 'nombre'];

}
