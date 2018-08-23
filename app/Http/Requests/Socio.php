<?php

namespace Lupita\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Socio extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombres' => 'required',
        ];
    }

    public function messages()
   {
    return [
        'nombres.required' => 'El nombre es requerido',

    ];
   }
}
