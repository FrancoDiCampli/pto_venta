<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticulo extends FormRequest
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
            'codarticulo'=>'required|min:1|max:10|unique:articulos,codarticulo,'.$this->articulo,
            'articulo'=>'required|min:1|unique:articulos,articulo,'.$this->articulo,
            'precio'=>'required',
            'stockminimo'=>'min:1',
            'marca_id'=>'required|min:1',
            'categoria_id'=>'required|min:1',
                       
        ];
    }
}
