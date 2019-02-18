<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Inventario;
use App\Movimiento;
use App\Articulo;
use App\Supplier as Proveedor;
class InventariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $articulos = Articulo::orderBy('created_at','asc')->paginate(5);
        return view('inventarios.index',compact('articulos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
      
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        
        $att = request()->validate([
            'articulo_id'=>'required',
    		'proveedor_id'=>'required',
    		'cantidad'=>'required|min:1|max:3',
           
            'lote'=> 'min:1',
            'vencimiento'=>'date|date_format:Y-m-d',
        ]);

        $inventario = Inventario::create($att);
        
        
        
        $ultimo = $inventario->id;

        $mov = new Movimiento;
        $mov->inventario_id = $ultimo;
        $mov->tipo = 1;
        $mov->cantidad = request()->cantidad;
        $mov->fecha = now();

        $mov->save();

        return redirect()->back();

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $articulo = Articulo::find($id);
        $proveedores = Proveedor::all();
        $suma = $articulo->inventarios->sum('cantidad');
        return view('inventarios.show',compact('articulo','proveedores','suma'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventario = Inventario::find($id);
       $articulo = Articulo::find($inventario->articulo_id);
        return view('inventarios.edit',compact('inventario','articulo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inventario = Inventario::find($id);
        $opt = $request->movimiento;
        switch ($opt) {
            case '1':
                $inventario->cantidad = $request->cantidad + $request->descuento;
                break;
            case '2':
                $inventario->cantidad = $request->cantidad - $request->descuento;
                break;
            case '3':
                $inventario->cantidad = $request->cantidad + $request->descuento;
                break;
            case '4':
                $inventario->cantidad = $request->cantidad - $request->descuento;
                break;
            default:
                # code...
                break;
        }  

     
        $inventario->update();

        $mov = new Movimiento;
        $mov->inventario_id = $id;
        $mov->tipo = $opt;
        $mov->cantidad = $request->descuento;
        $mov->fecha = now();

        $mov->save();

        return redirect('/inventarios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
