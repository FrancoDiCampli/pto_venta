<?php

namespace App\Http\Controllers\API;

use App\Marca;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarcasController extends Controller
{
    public function index()
    {
        return $marcas = Marca::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        $ruta = public_path().'/img/marcas/';
        $name = 'noimage.png';

        if($request->get('file'))
            {
                $carpeta = public_path().'/img/marcas/';
                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 777, true);
                }

                $image = $request->get('file');
                $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                \Image::make($request->get('file'))->save(public_path('img/marcas/').$name);
            }
        
        $foto = '/img/marcas/'.$name;

        $data = $request->validate([
            'marca'=>'required|unique:marcas|min:1|max:190',
        ]);

        $data['marca'] = ucwords($data['marca']);
        $data['file']=$foto;
       
        $marca = Marca::create($data);

        return ['message'=>'guardado'];

    }

    public function update(Request $request, $id)
    {
        $marca = Marca::findOrFail($id);
        $ruta = public_path().'/img/marcas/';

        if($request->get('file')!= $marca->file){
            $carpeta = public_path().'/img/marcas/';
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 777, true);
            }
            $eliminar = $marca->file;

            if(file_exists($eliminar)){
                @unlink($eliminar);
            }

            $image = $request->get('file');
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('file'))->save(public_path('img/marcas/').$name);
            
            $foto = '/img/marcas/'.$name;
        }else{
            $foto = $marca->file;
        }

        $data = $request->validate([
            'marca'=>'required|min:1|max:190|unique:marcas,marca,'.$marca->id,
        ]);

        $data['marca'] = ucwords($data['marca']);
        $data['file']=$foto;
       
        $marca->update($data);

        return ['message'=>'actualizado'];

    }

    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);
        $marca->delete();
    }

    public function searchMarca(){

        if ($search = \Request::get('q')) {
            $marca = Marca::where(function($query) use ($search){
                $query->where('marca','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $marca = Marca::latest()->paginate(5);
        }
        return $marca;
    }
}
