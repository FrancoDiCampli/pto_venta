<?php

namespace App\Http\Controllers\API;

use App\Categoria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriasController extends Controller
{
    public function index(){

        return Categoria::latest()->paginate(5);
        
    }

    public function store(Request $request){

        $data = $request->validate([
            'categoria'=>'required|unique:categorias|min:1|max:190',
        ]);

        $data['categoria'] = ucwords($data['categoria']);
       
        $categoria = Categoria::create($data);

        return ['message'=>'guardado'];

    }

    public function update(Request $request, $id){

        $categoria = Categoria::findOrFail($id); 

        $data = $request->validate([
            'categoria'=>'required|min:1|max:190|unique:categorias,categoria,'.$categoria->id,
        ]);

        $data['categoria'] = ucwords($data['categoria']);
       
        $categoria->update($data);
        
        return ['message'=>'editado'];

    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        $categoria->delete();

        return ['msg','Categoria eliminada'];
    }

    public function searchCategory(){

        if ($search = \Request::get('q')) {
            $categoria = Categoria::where(function($query) use ($search){
                $query->where('categoria','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $categoria = Categoria::latest()->paginate(5);
        }
        return $categoria;
    }



}
