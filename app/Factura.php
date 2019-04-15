<?php

namespace App;

use App\Cliente;
use App\Articulo;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
  protected $fillable = [
    'ptoventa',
    'numfactura',
    'cuit',
    'fecha',
    'total',
    'recargo',
    'cliente_id',
    'user_id'
  ];

  public function cliente()
  {

    return $this->belongsTo(Cliente::class, 'cliente_id');
  }



  public function user()
  {

    return $this->belongsTo(User::class, 'user_id');
  }

  public function articulos()
  {
    return $this->belongsToMany('App\Articulo')
      ->withPivot('cantidad', 'medida', 'preciounitario', 'subtotal')
      ->withTimestamps();
  }

  public function artis()
  {
    return $this->belongsToMany(Articulo::class, 'articulo_factura');
  }



  public function comprobante()
  {
    return $this->hasOne('App\Afip');
  }
}
