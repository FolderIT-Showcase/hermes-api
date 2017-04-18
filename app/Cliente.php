<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function vendedor()
    {
        return $this->belongsTo('Vendedor');
    }

    public function zona()
    {
        return $this->belongsTo('Zona');
    }

    public function tipo_categoria_cliente()
    {
        return $this->belongsTo('TipoCategoriaCliente');
    }

    public function domicilios()
    {
        return $this->hasMany('Domicilio');
    }

    protected $fillable  = ['vendedor_id', 'zona_id', 'tipo_categoria_id', 'codigo', 'nombre', 'tipo_responsable', 'cuit', 'telefono', 'celular', 'email', 'activo', 'motivo'];
}