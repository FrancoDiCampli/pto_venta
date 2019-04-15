<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'razonsocial', 'doc', 'cuit', 'condicioniva', 'enviarcomprobante', 'estado', 'sexo',
        'condicionpago',  'mail', 'telefono', 'direccion', 'localidad', 'provincia', 'cp', 'foto'
    ];
}
