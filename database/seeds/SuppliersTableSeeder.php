<?php

use App\Supplier;
use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proveedor = Supplier::create([
            'proveedor' => 'Arcla SRL',
            'cuit' => '22332221119',
            'direccion' => '25 de Mayo 36',
            'telefono' => '3735432123',

        ]);
        $proveedor = Supplier::create([
            'proveedor' => 'Surco SRL',
            'cuit' => '23123121239',
            'direccion' => '25 de Mayo 36',
            'telefono' => '3735657483',

        ]);
        $proveedor = Supplier::create([
            'proveedor' => 'MS SRL',
            'cuit' => '238907658',
            'direccion' => '25 de Mayo 36',
            'telefono' => '3735433458',

        ]);
    }
}
