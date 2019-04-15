<?php

namespace App\Http\Controllers\API;

use Afip;
use App\Factura;
use Carbon\Carbon;
use App\Inventario;
use App\Movimiento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Afip as Comprobante;

class FacturasController extends Controller
{
    public function index()
    {

        $factura = Factura::orderBy('id', 'desc')->first();

        if ($factura) {
            return response()->json([

                'factura' => $factura
            ]);
        } else { }
    }

    public function store()
    {

        $afip = new Afip(array('CUIT' => 23288066469));


        $detalles = array();
        $detalles = request()->detalle;

        $detalle = array();


        $factura = new Factura;




        $factura->fill([
            'ptoventa' => request()->ptoventa,
            'numfactura' => request()->numFactura,
            'cuit' => (request()->cuit) * 1,
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


            $aux['articulo_id'] = $item['id'];
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

            $arti = Inventario::where('articulo_id', '=', $item['id'])
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

        // $data = array(
        //     'CantReg'         => 1, // Cantidad de comprobantes a registrar
        //     'PtoVta'         => request()->ptoventa, // Punto de venta
        //     'CbteTipo'         => 11, // Tipo de comprobante (ver tipos disponibles) 
        //     'Concepto'         => 1, // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
        //     'DocTipo'         => 99, // Tipo de documento del comprador (ver tipos disponibles)
        //     'DocNro'         => 0, // Numero de documento del comprador
        //     'CbteDesde'     => request()->numFactura, // Numero de comprobante o numero del primer comprobante en caso de ser mas de uno
        //     'CbteHasta'     => request()->numFactura, // Numero de comprobante o numero del ultimo comprobante en caso de ser mas de uno
        //     'CbteFch'         => intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
        //     'ImpTotal'         => request()->total, // Importe total del comprobante
        //     'ImpTotConc'     => 0, // Importe neto no gravado
        //     'ImpNeto'         => request()->total, // Importe neto gravado
        //     'ImpOpEx'         => 0, // Importe exento de IVA
        //     'ImpIVA'         => 0, //Importe total de IVA
        //     'ImpTrib'         => 0, //Importe total de tributos
        //     'FchServDesde'     => null, // (Opcional) Fecha de inicio del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
        //     'FchServHasta'     => null, // (Opcional) Fecha de fin del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
        //     'FchVtoPago'     => null, // (Opcional) Fecha de vencimiento del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
        //     'MonId'         => 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
        //     'MonCotiz'         => 1, // Cotización de la moneda usada (1 para pesos argentinos)  


        // );

        // $afip = new Afip(array('CUIT' => 23288066469));

        // $cae = $afip->ElectronicBilling->CreateVoucher($data);

        // return $cae;
    }

    public function facturar($numfactura)
    {
        $factura = Factura::find($numfactura);

        $comprobante = Comprobante::where('factura_id', $factura->id)->get();



        if (count($comprobante) > 0) {
            return "Ya posee comprobante";
        } else {


            $afip = new Afip(array('CUIT' => 23288066469));

            $ultimo  = $afip->ElectronicBilling->GetLastVoucher(1, 11);
            $ultimo += 1;
            $cuit = ($factura->cuit) * 1;

            $data = array(
                'CantReg'         => 1, // Cantidad de comprobantes a registrar
                'PtoVta'         => $factura->ptoventa, // Punto de venta
                'CbteTipo'         => 11, // Tipo de comprobante (ver tipos disponibles) 
                'Concepto'         => 1, // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
                'DocTipo'         => 80, // Tipo de documento del comprador (ver tipos disponibles)
                'DocNro'         => $cuit, // Numero de documento del comprador
                'CbteDesde'     => $ultimo, // Numero de comprobante o numero del primer comprobante en caso de ser mas de uno
                'CbteHasta'     => $ultimo, // Numero de comprobante o numero del ultimo comprobante en caso de ser mas de uno
                'CbteFch'         => intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
                'ImpTotal'         => $factura->total, // Importe total del comprobante
                'ImpTotConc'     => 0, // Importe neto no gravado
                'ImpNeto'         => $factura->total, // Importe neto gravado
                'ImpOpEx'         => 0, // Importe exento de IVA
                'ImpIVA'         => 0, //Importe total de IVA
                'ImpTrib'         => 0, //Importe total de tributos
                'FchServDesde'     => null, // (Opcional) Fecha de inicio del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
                'FchServHasta'     => null, // (Opcional) Fecha de fin del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
                'FchVtoPago'     => null, // (Opcional) Fecha de vencimiento del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
                'MonId'         => 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
                'MonCotiz'         => 1, // Cotización de la moneda usada (1 para pesos argentinos)  


            );

            $cae = $afip->ElectronicBilling->CreateVoucher($data);

            $nuevo = new Comprobante;

            $nuevo->numcomprobante = $ultimo;
            $nuevo->factura_id = $factura->id;

            $nuevo->cae = $cae['CAE'];
            $nuevo->fechavto = $cae['CAEFchVto'];

            $nuevo->save();

            return 'Done';
        }
    }

    public function lista()
    {

        $facturas = Factura::with(['comprobante'])->latest()->paginate(10);

        return response()->json([

            'facturas' => $facturas
        ]);
        // return view('facturas.index', compact('facturas'));
    }

    public function show($id)
    {

        $factura = Factura::find($id);



        $pdf = app('dompdf.wrapper')->loadView('facturas.show', ['factura' => $this]);


        return $pdf->stream('invoice.pdf');

        return $factura->getPdf();
    }

    public function getPdf($type = 'stream')
    {
        $pdf = app('dompdf.wrapper')->loadView('order-pdf', ['order' => $this]);

        if ($type == 'stream') {
            return $pdf->stream('invoice.pdf');
        }

        if ($type == 'download') {
            return $pdf->download('invoice.pdf');
        }
    }

    public function detalles($id)
    {
        $factura = Factura::find($id);
        $detalle = $factura->articulos;

        return response()->json([

            'detalle' => $detalle
        ]);
    }

    public function afip($id)
    {

        $comprobante = Comprobante::where('factura_id', $id)->get();
        return $comprobante->cae;

        $afip = new Afip(array('CUIT' => 23288066469));


        $factura = $afip->ElectronicBilling->GetVoucherInfo($numero, 1, 11);
        $cae = $factura->CodAutorizacion;
        $vto = $factura->FchVto;
        $num = '23288066469' . '11' . '0001' . $cae . $vto;
        $cod = $this->codVerificador($num);
        // $factura = Factura::orderBy('id', 'desc')->first();

        if ($factura) {
            return response()->json([

                'factura' => $factura,
                'cod' => $cod
            ]);
        } else { }
    }

    public function codVerificador($num)
    {

        $Numero = $num;
        $j = strlen($Numero);
        $par = 0;
        $impar = 0;
        for ($i = 0; $i < $j; $i++) {
            if ($i % 2 == 0) {
                $par = $par + $Numero[$i];
            } else {
                $impar = $impar + $Numero[$i];
            }
        }
        $par = $par * 3;
        $suma = $par + $impar;
        for ($i = 0; $i < 9; $i++) {
            if (fmod(($suma + $i), 10) == 0) {
                $verificador = $i;
            }
        }
        $digito = 10 - ($suma - (intval($suma / 10) * 10));
        if ($digito == 10) {
            $digito = 0;
        }
        $num =  $Numero . $digito;

        return $num;
    }


    public function traerFactura($id)
    {
        $factura = Factura::find($id);

        return $factura->comprobante;
    }
}
