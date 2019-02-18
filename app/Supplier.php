<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected  $fillable = ['proveedor', 'cuit','direccion','telefono'];

    public function inventarios(){
        return $this->hasMany('App\Inventario');
    }
}
