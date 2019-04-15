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
            'razonsocial' => 'Franco',
            'cuit' => '23288066469',
            'doc' => '28806646',
            'condicioniva' => 'Responsable Monotributo',
            'enviarcomprobante' => true,
            'estado' => true,
            'condicionpago' => 'Contado',
            'mail' => 'franco@mail.com',
            'telefono' => '43234',
            'direccion' => 'Begrano 25',
            'cp' => '3540',
            'localidad' => 'Villa Angela',
            'provincia' => 'Chaco',
            'sexo' => 'Masculino',
            'foto' => 'img/clientes/noimage.png'

        ]);
    }
}
