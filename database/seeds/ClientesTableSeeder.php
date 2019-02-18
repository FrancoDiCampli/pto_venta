<?php

use Illuminate\Database\Seeder;
use App\Cliente;
class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cliente = Cliente::create([
    		'nombre' => 'Franco',
    		'doc'=> '28806646',
            'direccion' =>'Begrano 25',
            'cp' =>'3540',
            'percibeiva' =>false,
            'percibeiibb' =>false,
            'enviarcomprobante' =>true,
            'estado' =>true,
            'condicionpago' =>'Contado',
            'mail'=>'franco@mail.com',
            'telefono'=>'43234',
            'foto'=>'img/clientes/noimage.png'

    	]);
    }
}
