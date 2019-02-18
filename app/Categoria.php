<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['categoria'];

	public function articulos(){

		 return $this->hasMany(Articulo::class);
	}
}
