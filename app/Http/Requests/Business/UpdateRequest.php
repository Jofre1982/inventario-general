<?php

namespace App\Http\Requests\Business;

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
            'nit' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string', 'max:255'],
            'mail' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'picture' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function attributes()
    {
        return ['name' => 'nombre', 'description' => 'descripción', 'mail' => 'correo', 'address' => 'dirección', 'picture' => 'logo'];
    }
}
