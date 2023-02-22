<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

  
    public function rules()
    {
        return [
            'name'=>'string|required|max:255',
            'document'=>'string|required|unique:clients,document,'.$this->route('client')->id.'max:255',
            'adress'=>'string|max:255',
            'phone'=>'string|required|max:10',
            'email'=>'string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'name.requiered'=>'Este campo es requerido',
            'name.string'=>'El valor no es correcto',
            'name.max'=>'Solo se permiten 50 caracteres',
            
            'document.requiered'=>'Este campo es requerido',
            'document.max'=>'Solo se permiten 20 caracteres',
            'document.string'=>'El valor no es correcto',
            'document.unique'=>'Este documento ya esta registrado',

            'adress.max'=>'Solo se permiten 255 caracteres',
            'adress.string'=>'El valor no es correcto',

            'phone.requiered'=>'Este campo es requerido',
            'phone.max'=>'Solo se permiten 10 caracteres',
            'phone.string'=>'El valor no es correcto',

            'email.max'=>'Solo se permiten 255 caracteres',
            'email.string'=>'El valor no es correcto',
            'email.email'=>'No es un correo electrónico', 
            

        ];
    }
}
