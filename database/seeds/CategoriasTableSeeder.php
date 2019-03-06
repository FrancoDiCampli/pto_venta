<?php

use Illuminate\Database\Seeder;
use App\Categoria;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria = Categoria::create([
            'categoria' => 'Bebidas',
        ]);

        $categoria = Categoria::create([
            'categoria' => 'Lacteos',

        ]);

        $categoria = Categoria::create([
            'categoria' => 'Comestibles',

        ]);
    }
}
