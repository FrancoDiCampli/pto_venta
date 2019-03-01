<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Factura;
class FacturasController extends Controller
{
    public function index(){

      
        $factura = Factura::orderBy('id')->first()->get();
     
        return response()->json([
          
            'factura' =>$factura
        ]);
    }
}
