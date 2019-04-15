<?php

namespace App\Http\Controllers\API;

use Afip;
use Image;
use App\Cliente;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCliente;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCliente;
use function GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Auth;

class ClientesController extends Controller
{




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cliente::latest()->paginate(5);
    }


    public function store(StoreCliente $request)
    {
        $ruta = public_path() . '/img/clientes/';
        $name = 'noimage.png';


        if ($request->get('foto')) {
            $carpeta = public_path() . '/img/clientes/';
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 777, true);
            }

            $image = $request->get('foto');
            // $name = $this->random_string() . '.' . $image->getClientOriginalExtension();
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('foto'))->save(public_path('img/clientes/') . $name);
        }

        $foto = '/img/clientes/' . $name;



        $data = $request->validated();

        $data['razonsocial'] = ucwords($data['razonsocial']);
        $data['direccion'] = ucwords($data['direccion']);
        $data['foto'] = $foto;

        $clientes = Cliente::create($data);
    }
    protected function random_string()
    {
        $key = '';
        $keys = array_merge(range('a', 'z'), range(0, 9));

        for ($i = 0; $i < 10; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }



    public function update(UpdateCliente $request, $id)
    {

        $cliente = Cliente::findOrFail($id);

        $ruta = public_path() . 'img/clientes/';



        if ($request->get('foto') != $cliente->foto) {
            $carpeta = '/img/clientes/';
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $eliminar = $cliente->foto;

            if (file_exists($eliminar)) {
                @unlink($eliminar);
            }

            $image = $request->get('foto');
            // $name = $this->random_string() . '.' . $image->getClientOriginalExtension();
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('foto'))->save(public_path('img/clientes/') . $name);

            $foto = 'img/clientes/' . $name;
        } else {
            $foto = $cliente->foto;
        }


        $data = $request->validated();
        $data['razonsocial'] = ucwords($data['razonsocial']);
        $data['direccion'] = ucwords($data['direccion']);

        $data['foto'] = $foto;

        $cliente->update($data);
        return ['message' => 'editado'];
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Cliente::findOrFail($id);

        $user->delete();

        return ['msg', 'Cliente eliminado'];
    }

    public function validarDato($cadena)
    {

        return $cadena = str_replace('.', '', $cadena);
    }

    public function searchUser()
    {

        if ($search = \Request::get('q')) {
            $users = Cliente::where(function ($query) use ($search) {
                $query->where('nombre', 'LIKE', "%$search%")
                    ->orWhere('mail', 'LIKE', "%$search%")
                    ->orWhere('doc', 'LIKE', "%$search%")
                    ->orWhere('telefono', 'LIKE', "%$search%");
            })->paginate(20);
        } else {
            $users = Cliente::latest()->paginate(5);
        }
        return $users;
    }


    public function buscar(Request $request)
    {
        $clientes = Cliente::where('razonsocial', 'LIKE', '%' . $request->buscar . '%')->get();
        $user = 1;
        return response()->json([
            'user' => $user,
            'clientes' => $clientes
        ]);
    }

    public function show($id)
    {


        return $cliente = Cliente::find($id);

        return response()->json([
            'cliente' => $cliente

        ]);
    }

    public function traerCliente($id)
    {

        $afip = new Afip(array('CUIT' => 23288066469));

        $id = $id * 1;

        $clientes = $afip->RegisterScopeTen->GetTaxpayerDetails($id);
        // $cliente2 = $afip->RegisterScopeFour->GetTaxpayerDetails($id);
        //$cliente3 = $afip->RegisterScopeFive->GetTaxpayerDetails($id);

        return response()->json([
            // 'cliente1' => $cliente1,
            // 'cliente2' => $cliente2
            'clientes' => $clientes

        ]);
    }
}
