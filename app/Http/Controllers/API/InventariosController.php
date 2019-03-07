<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

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

        $articulos = Articulo::orderBy('created_at', 'asc')->paginate(5);
        return response()->json([
            'articulos' => $articulos
        ]);
        // return view('inventarios.index',compact('articulos'));
    }
    public function traerInventario($id)
    {

        $proveedores = Proveedor::all();
        $inventario = Inventario::where('articulo_id', $id)->paginate(5);
        $articulo = Articulo::where('id', $id)->get();

        return response()->json([
            'proveedores' => $proveedores,
            'inventario' => $inventario,
            'articulo' => $articulo
        ]);


        // return response()->json(['inventario'=>$inventario]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    { }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $att = $request->validate([
            'articulo_id' => 'required',
            'proveedor_id' => 'required',
            'cantidad' => 'required|min:1|max:3',
            'stockminimo' => 'min:1|max:3',
            'preciocosto' => 'required',

            'lote' => 'min:1',
            'vencimiento' => 'date|date_format:Y-m-d',
        ]);

        $inventario = Inventario::create($att);



        $ultimo = $inventario->id;

        $mov = new Movimiento;
        $mov->inventario_id = $ultimo;
        $mov->tipo = 1;
        $mov->cantidad = request()->cantidad;
        $mov->fecha = now();

        $mov->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // $articulo = Articulo::find($id);
        // $proveedores = Proveedor::all();
        // $suma = $articulo->inventarios->sum('cantidad');
        // return view('inventarios.show',compact('articulo','proveedores','suma'));

        $inventario = Inventario::where('id', $id)->get();
        $proveedores = Proveedor::all();

        return response()->json([
            'proveedores' => $proveedores,
            'inventario' => $inventario
        ]);
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
        return view('inventarios.edit', compact('inventario', 'articulo'));
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

        $att = $request->validate([
            'articulo_id' => 'required',
            'proveedor_id' => 'required',
            'cantidad' => 'required|min:1|max:3',
            'stockminimo' => 'min:1|max:3',
            'preciocosto' => 'required',

            'lote' => 'min:1',
            'vencimiento' => 'date|date_format:Y-m-d',
        ]);

        $inventario->update($att);

        $ultimo = $inventario->id;

        $mov = Movimiento::where('inventario_id', $id)->where('tipo', 1)->latest()->first();

        $mov->cantidad = $request->cantidad;
        $mov->touch();

        $mov->save();
    }

    public function moverInventario(Request $request, $id)
    {


        $cantidad = 0;
        $inventario = Inventario::find($request->id);

        if ($request->movimiento === 2) {
            $inventario->cantidad = $inventario->cantidad - $request->unidades;
            $cantidad = $request->unidades;
        }
        if ($request->movimiento === 3) {
            $inventario->cantidad = $inventario->cantidad + $request->unidades;
            $cantidad = $request->unidades;
        }
        if ($request->movimiento === 4) {

            $inventario->cantidad = 0;
            $cantidad = $request->stock;
        }

        $inventario->update();


        $mov = new Movimiento;
        $mov->inventario_id = $id;
        $mov->tipo = $request->movimiento;

        $mov->cantidad = $cantidad;
        $mov->fecha = now();
        $mov->touch();

        $mov->save();
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
