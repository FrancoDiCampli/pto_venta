<?php

namespace App\Http\Controllers\API;

use App\Remito;
use App\Articulo;
use App\Inventario;
use App\Movimiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RemitosController extends Controller
{

    public function index()
    {
        return $remitos = Remito::orderBy('fecha')->get();
    }

    public function store()
    {

        $detalles = request()->detalle;

        $detalle = array();



        $remito = new Remito;

        $remito->fill([
            'numremito' => request()->ptoventa,
            'fecha' => now(),
            'total' => request()->total,
            'recargo' =>  request()->recargo,
            'proveedor_id' => request()->cliente_id,
            'user_id' => request()->user_id,
        ])->save();


        $ultimo = $remito->id;


        $remito = Remito::find($ultimo);

        $aux = array();

        foreach (request()->detalles as $item) {

            $aux['articulo_id'] = $item['id'];
            $aux['remito_id'] = $ultimo;
            $aux['lote'] = $item['lote'];
            $aux['cantidad'] = $item['unidades'];
            $aux['medida'] = 'unidad';
            $aux['costo'] = $item['precioUnitario'];
            $aux['subtotal'] = $item['sTotal'];

            array_push($detalle, $aux);
        }

        unset($detalle[0]);

        $remito->articulos()->attach($detalle);

        $i = 0;

        $detalles = request()->detalles;

        unset($detalles[0]);


        foreach ($detalles as $item) {
            // Aqui modificar la logica para descontar del lote mas viejo
            $descuento = $item['unidades'];

            $arti = Inventario::where('articulo_id', '=', $item['id'])
                ->where('lote', '=', $item['lote'])->get()->first();
            if ($arti) {

                $arti->cantidad = intval($arti->cantidad) + intval($item['unidades']);
                $i++;
                $arti->save();
            } else {

                $att['articulo_id'] = $item['id'];
                $att['proveedor_id'] = request()->cliente_id;
                $att['cantidad'] = $item['unidades'];
                $att['stockminimo'] = 1;
                $att['vencimiento'] = now();
                $att['preciocosto'] = $item['precioUnitario'];
                $att['lote'] = $item['lote'];

                $arti = Inventario::create($att);
            }



            $mov = new Movimiento;

            $mov->inventario_id = $arti->id;
            $mov->tipo = 1;
            $mov->cantidad = $descuento;
            $mov->fecha = now();

            $mov->save();
        }
    }

    public function remitosFecha($inicio, $fin)
    {

        $remitos =  Remito::where('fecha', '>=', $inicio)
            ->where('fecha', '<=', $fin)->get();

        $detalles =  $remitos->toArray();


        return response()->json([
            'remitos' => $remitos,
            'detalles' => $detalles

        ]);
    }

    public function remitosProducto($producto)
    {

        $remitos = Articulo::find($producto)->remitos()->orderBy('fecha')->get();
        $detalles =  $remitos->toArray();



        return response()->json([
            'remitos' => $remitos,
            'detalles' => $detalles

        ]);
    }
}
