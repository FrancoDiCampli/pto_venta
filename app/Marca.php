<?php

namespace App;
use App\Articulo;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $fillable = ['marca','file'];

	public function articulos(){

		 return $this->hasMany(Articulo::class);
	}
}
