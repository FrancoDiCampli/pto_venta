<?php

use App\Articulo;
use Illuminate\Database\Seeder;

class ArticulosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Articulo::class, 20)->create();
    }
}
