<?php

namespace App\Http\Controllers\API;

use App\Marca;
use App\Articulo;
use App\Categoria;

use App\Inventario;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticulo;
use App\Http\Requests\UpdateArticulo;

class ArticulosController extends Controller
{
    public function index()
    {
        $marcas = Marca::all();
        $categorias = Categoria::all();
        $articulos = Articulo::orderBy('id', 'asc')->with('stock')->paginate(100);


        // Articulo::with('stock')->get();


        return response()->json([
            'marcas' => $marcas,
            'categorias' => $categorias,
            'articulos' => $articulos
        ]);
    }

    public function store(StoreArticulo $request)
    {

        $ruta = public_path() . '/img/articulos/';
        $name = 'noimage.png';


        if ($request->get('foto')) {
            $carpeta = public_path() . '/img/articulos/';
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 777, true);
            }

            $image = $request->get('foto');
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('foto'))->save(public_path('img/articulos/') . $name);
        }

        $foto = '/img/articulos/' . $name;



        $data = $request->validated();

        $data['articulo'] = ucwords($data['articulo']);
        $data['descripcion'] = ucwords($data['descripcion']);
        $data['foto'] = $foto;

        $clientes = Articulo::create($data);
    }

    public function update(Request $request, $id)
    {

        $articulo = Articulo::findOrFail($id);

        $ruta = public_path() . 'img/articulos/';



        if ($request->get('foto') != $articulo->foto) {
            $carpeta = '/img/articulos/';
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $eliminar = $articulo->foto;

            if (file_exists($eliminar)) {
                @unlink($eliminar);
            }

            $image = $request->get('foto');
            $name = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            \Image::make($request->get('foto'))->save(public_path('img/articulos/') . $name);

            $foto = 'img/articulos/' . $name;
        } else {
            $foto = $articulo->foto;
        }


        $data = $request->validate([
            'codarticulo' => 'required|min:1|max:10|unique:articulos,codarticulo,' . $articulo->id,
            'articulo' => 'required|min:1|unique:articulos,articulo,' . $articulo->id,
            'descripcion' => 'nullable',
            'costo' => 'required|min:1',
            'utilidades' => 'required|min:1',
            'precio' => 'required|min:1',
            'marca_id' => 'required|min:1',
            'categoria_id' => 'required|min:1',
        ]);

        $data['articulo'] = ucwords($data['articulo']);
        $data['descripcion'] = ucwords($data['descripcion']);
        $data['foto'] = $foto;

        $articulo->update($data);

        return ['message' => 'actualizado'];
    }

    public function searchArticle()
    {

        if ($search = \Request::get('q')) {
            $articulo = Articulo::where(function ($query) use ($search) {
                $query->where('articulo', 'LIKE', "%$search%");
            })->paginate(20);
        } else {
            $articulo = Articulo::latest()->paginate(5);
        }
        return $articulo;
    }

    public function buscarCodigo($cod)
    {
        $articulos = Articulo::where('codArticulo', 'LIKE', $cod . '%')->get();


        // $articulo = Articulo::firstOrFail()->where('codArticulo', $value);

        return response()->json($articulos);
    }
    public function buscarArticulo($cod)
    {
        $articulos = Articulo::where('articulo', 'LIKE', $cod . '%')->get();

        // $articulo = Articulo::firstOrFail()->where('codArticulo', $value);

        return response()->json($articulos);
    }

    public function traerInventario($id)
    {


        $inventarios = Inventario::where('articulo_id', $id)->get();

        $stock = $inventarios->sum('cantidad');


        return response()->json([
            'stock' => $stock,
            'inventarios' => $inventarios
        ]);
    }
}
