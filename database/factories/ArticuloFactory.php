<?php

use Faker\Generator as Faker;
use App\Marca;
use App\Categoria;

$factory->define(App\Articulo::class, function (Faker $faker) {
    $foto = '/img/articulos/noimage.png';
    return [
        'articulo' => $faker->sentence(2),
        'codarticulo' => $faker->randomNumber($nbDigits = 6, $strict = true),
        'descripcion' => $faker->sentence(3),

        'marca_id' => $faker->boolean($chanceOfGettingTrue = 50),
        'foto' => $foto,
        'categoria_id' => Categoria::all()->random()->id,
        'marca_id' => Marca::all()->random()->id,

    ];
});
