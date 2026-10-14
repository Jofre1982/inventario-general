<?php

namespace App\Http\Requests\Client;

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
            'document' => ['required', 'string', 'max:20', Rule::unique('clients', 'document')->ignore($this->route('client'))],
            'adress' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
        ];
    }

    public function attributes()
    {
        return ['name' => 'nombre', 'document' => 'documento', 'adress' => 'dirección', 'phone' => 'teléfono', 'email' => 'correo'];
    }
}
