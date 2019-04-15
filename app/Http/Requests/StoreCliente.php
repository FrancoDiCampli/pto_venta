<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCliente extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'razonsocial' => 'required|unique:clientes|min:3|max:190',
            'doc' => 'required|unique:clientes|min:7',
            'cuit' => 'sometimes|required|min:11',
            'direccion' => 'required|min:3|max:190',
            'cp' => 'required',
            'localidad' => 'required',
            'provincia' => 'required',
            'mail' => 'max:190',
            'condicionpago' => 'required|max:190',
            'telefono' => 'required|min:6|max:16',
            'codigopostal' => 'min:1|max:4',
            'sexo' => 'sometimes',
            'enviarcomprobante' => 'min:1',
            'estado' => 'min:1'
        ];
    }
}
