<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    public function articulos()
    {
        return $this->hasMany(Articulo::class);
    }

    protected $fillable  = ['codigo', 'nombre'];

}
