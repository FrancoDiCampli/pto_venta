<?php

use App\Marca;
use Illuminate\Database\Seeder;

class MarcasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $marca = Marca::create([
            'marca' => 'Coca Cola',

        ]);
        $marca = Marca::create([
            'marca' => 'Arcor',

        ]);

        $marca = Marca::create([
            'marca' => 'Sancor',

        ]);
    }
}
