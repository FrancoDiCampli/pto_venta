<?php

namespace App\Http\Controllers\API;

use App\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SuppliersController extends Controller
{
    public function index()
    {
        return $suppliers = Supplier::latest()->paginate(100);
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'proveedor' => 'required|unique:suppliers|min:1|max:190',
            'cuit' => 'required|unique:suppliers|min:11|max:11',
            'direccion' => 'required|min:1|max:190',
            'telefono' => 'required|min:8|max:13'
        ]);

        $data['proveedor'] = ucwords($data['proveedor']);
        $data['direccion'] = ucwords($data['direccion']);

        $supplier = Supplier::create($data);

        return ['message' => 'guardado'];
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $data = $request->validate([
            'proveedor' => 'required|min:1|max:190|unique:suppliers,proveedor,' . $supplier->id,
            'cuit' => 'required|min:11|max:11|unique:suppliers,cuit,' . $supplier->id,
            'direccion' => 'required|min:1|max:190',
            'telefono' => 'required|min:8|max:13'
        ]);

        $data['proveedor'] = ucwords($data['proveedor']);
        $data['direccion'] = ucwords($data['direccion']);

        $supplier->update($data);

        return ['message' => 'editado'];
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        return ['msg', 'Proveedor eliminado'];
    }

    public function searchSupplier()
    {

        if ($search = \Request::get('q')) {
            $supplier = Supplier::where(function ($query) use ($search) {
                $query->where('proveedor', 'LIKE', "%$search%");
            })->paginate(20);
        } else {
            $supplier = Supplier::latest()->paginate(5);
        }
        return $supplier;
    }

    public function buscarR()
    {
        $buscar = 'Ar';
        return $proveedores = Supplier::where('proveedor', 'LIKE', '%' . $buscar . '%')->get();
    }

    public function buscar(Request $request)
    {

        $proveedores = Supplier::where('proveedor', 'LIKE', '%' . $request->buscar . '%')->get();
        $user = 1;
        return response()->json([
            'user' => $user,
            'proveedores' => $proveedores
        ]);
    }
}
