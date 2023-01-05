<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required|string|max:50',
            'descriptions'=>'nullable|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'name.requiered'=>'Este campo es requerido',
            'name.string'=>'El valor no es correcto',
            'name.max'=>'Solo se permiten 50 caracteres',
            'descriptions.string'=>'El valor no es correcto',
            'descriptions.max'=>'Solo se permiten 255 caracteres',
        ];
    }
}
