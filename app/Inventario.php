<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Articulo;
class Inventario extends Model
{
    protected $fillable = [
        'articulo_id',
        'cantidad',
        'lote',
        'stockminimo',
        'preciocosto',
        'precioventa',
        'vencimiento',
        'proveedor_id'
        ];

        public function articulo(){

            return $this->belongsTo('App\Articulo','articulo_id');
        }

        public function movimientos()
        {
        return $this->hasMany('App\Movimiento');
        }

        public function proveedor(){
            return $this->belongsTo('App\Supplier','proveedor_id');
        }
}
