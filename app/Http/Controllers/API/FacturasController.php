<?php

namespace App\Http\Controllers\API;

use App\Factura;
use Carbon\Carbon;
use App\Inventario;
use App\Movimiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacturasController extends Controller
{
    public function index()
    {


        $factura = Factura::orderBy('id')->first()->get();

        return response()->json([

            'factura' => $factura
        ]);
    }

    public function store()
    {

        $detalles = array();
        $detalles = request()->detalle;

        $detalle = array();


        $factura = new Factura;

        $factura->fill([
            'ptoventa' => request()->ptoventa,
            'numfactura' => request()->numFactura,
            'cuit' => request()->cuit,
            'fecha' => now(),
            'total' => request()->total,
            'recargo' =>  request()->recargo,
            'cliente_id' => request()->cliente_id,
            'user_id' => request()->user_id,
        ])->save();


        $ultimo = $factura->id;


        $factura = Factura::find($ultimo);

        $aux = array();



        foreach (request()->detalle as $item) {


            $aux['articulo_id'] = $item['codArticulo'];
            $aux['factura_id'] = $ultimo;
            $aux['cantidad'] = $item['unidades'];
            $aux['medida'] = 'unidad';
            $aux['preciounitario'] = $item['precioUnitario'];
            $aux['subTotal'] = $item['sTotal'];

            array_push($detalle, $aux);
        }

        unset($detalle[0]);

        $factura->articulos()->attach($detalle);

        $i = 0;

        $detalles = request()->detalle;

        unset($detalles[0]);

        foreach ($detalles as $item) {
            // Aqui modificar la logica para descontar del lote mas viejo
            $descuento = $item['unidades'];

            $arti = Inventario::where('articulo_id', '=', $item['codArticulo'])
                ->where('cantidad', '>=', $item['unidades'])->get()->first();

            $arti->cantidad = intval($arti->cantidad) - intval($item['unidades']);
            $i++;
            $arti->save();

            $mov = new Movimiento;

            $mov->inventario_id = $arti->id;
            $mov->tipo = 2;
            $mov->cantidad = $descuento;
            $mov->fecha = now();

            $mov->save();
        }
    }
}
