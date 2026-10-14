<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('providers', 'email')->ignore($this->route('provider'))],
            'nit' => ['required', 'string', 'max:20', Rule::unique('providers', 'nit')->ignore($this->route('provider'))],
            'adress' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ];
    }

    public function attributes()
    {
        return ['name' => 'nombre', 'email' => 'correo', 'nit' => 'NIT', 'adress' => 'dirección', 'phone' => 'teléfono'];
    }
}
