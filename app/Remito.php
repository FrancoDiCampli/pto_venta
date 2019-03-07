<?php

namespace App;

use App\Articulo;
use App\Supplier;
use Illuminate\Database\Eloquent\Model;

class Remito extends Model
{
    protected $fillable = [
        'numremito',
        'fecha',
        'total',
        'recargo',
        'proveedor_id',
        'user_id'
    ];

    public function proveedor()
    {

        return $this->belongsTo(Supplier::class, 'proveedor_id');
    }

    public function user()
    {


        return $this->belongsTo(User::class, ' user_id');
    }

    public function articulos()
    {
        return $this->belongsToMany('App\Articulo')
            ->withPivot('lote', 'cantidad', ' medida', ' costo', ' subtotal')
            ->withTimestamps();
    }

    public function artis()
    {
        return $this->belongsToMany(Articulo::class, 'articulo_remito');
    }
}
