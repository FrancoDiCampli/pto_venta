<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticulo extends FormRequest
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
            'codarticulo'=>'required|unique:articulos|min:1|max:10',
            'articulo'=>'required|unique:articulos|min:1',
            'descripcion'=>'required|min:1|max:190',
            'marca_id'=>'required|min:1',
            'categoria_id'=>'required|min:1',
           
                       
        ];
    }
}
