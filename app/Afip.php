<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Afip extends Model
{
    protected $fillable = [
        'numcomprobante',
        'cae',
        'fechavto',
        'codbarra',
        'factura_id'
    ];

    public function factura()
    {
        return $this->hasOne('App\Factura');
    }
}
