<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;

class Updaterequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|string|max:255',
            'email'=>'required|email|string|unique:providers,email,'.$this->route('provider')->id.'|max:255',
            'nit'=>'required|string|unique:providers,nit,'.$this->route('provider')->id.'|max:20',
            'adress'=>'nullable|string|max:255',
            'phone'=>'required|string|unique:providers,phone,'.$this->route('provider')->id.'|max:10',
            
        ];
    }
    public function messages()
    {
        return [
            'name.requiered'=>'Este campo es requerido',
            'name.string'=>'El valor no es correcto',
            'name.max'=>'Solo se permiten 255 caracteres',

            'email.required'=>'Este campo es requerido',
            'email.email'=>'No es un correo electronico',
            'email.string'=>'El valor no es correcto',
            'email.max'=>'Solo se permiten 255 caracteres',
            'email.uniqued'=>'Ya se encuentra registrada',
            
            'nit.required'=>'Este campo es requerido',
            'nit.string'=>'El valor no es correcto',
            'nit.max'=>'Solo se permiten 20 caracteres',
            'nit.uniqued'=>'Ya se encuentra registrado',

            'adress.string'=>'El valor no es correcto',
            'adress.max'=>'Solo se permiten 255 caracteres',

            'phone.required'=>'Este campo es requerido',
            'phone.string'=>'El valor no es correcto',
            'phone.max'=>'Solo se permiten 10 caracteres',
            'phone.uniqued'=>'Ya se encuentra registrado',

            
        ];
    }
}
