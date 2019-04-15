<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Marca;
use App\Categoria;
use App\Remito;

class Articulo extends Model
{
    protected $fillable = [
        'codarticulo',
        'articulo',
        'descripcion',
        'costo',
        'utilidades',
        'precio',
        'alicuota',
        'estado',
        'foto',
        'marca_id',
        'categoria_id',
    ];

    public function stock()
    {
        return $this->hasMany('App\Inventario')
            ->selectRaw('SUM(cantidad) as total')
            ->addSelect('articulo_id')
            ->groupBy('articulo_id');
    }



    public function marca()
    {

        return $this->belongsTo('App\Marca', 'marca_id');
    }

    public function categoria()
    {

        return $this->belongsTo('App\Categoria', 'categoria_id');
    }

    public function facturas()
    {

        return $this->belongsToMany('App\Factura')
            ->withPivot('cantidad', 'medida', 'preciounitario', 'subtotal')
            ->withTimestamps();
    }

    public function factus()
    {
        return $this->belongsToMany(Factura::class, 'articulo_factura');
    }

    public function inventarios()
    {
        return $this->hasMany('App\Inventario', 'articulo_id');
    }

    public function remitos()
    {

        return $this->belongsToMany('App\Remito')
            ->withPivot('lote', 'cantidad', 'medida', 'costo', 'subtotal')
            ->withTimestamps();
    }
}
