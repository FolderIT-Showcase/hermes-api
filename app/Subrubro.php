<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subrubro extends Model
{
    public function rubro()
    {
        return $this->belongsTo(Rubro::class);
    }

    public function articulos()
    {
        return $this->hasMany(Articulo::class);
    }

    protected $fillable  = ['codigo', 'nombre', 'rubro_id'];

}
