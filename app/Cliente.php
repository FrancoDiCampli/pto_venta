<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = ['nombre','doc','direccion','cp','percibeiva','percibeiibb',
    'condicionpago','enviarcomprobante', 'mail','telefono','estado','foto'];


    

}
