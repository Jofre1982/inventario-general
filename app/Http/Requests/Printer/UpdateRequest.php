<?php

namespace App\Http\Requests\Printer;

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
            'name' => ['required_unless:connector,network', 'nullable', 'string', 'max:255'],
            'connector' => ['required', Rule::in(array_keys(\App\Models\Printer::CONNECTORS))],
            'host' => ['required_if:connector,network', 'nullable', 'string', 'max:255'],
            'port' => ['nullable', 'integer', 'min:1', 'max:65535'],
            'width' => ['required', 'integer', 'min:24', 'max:64'],
        ];
    }

    public function attributes()
    {
        return ['name' => 'nombre de la impresora', 'connector' => 'tipo de conexión', 'host' => 'IP', 'port' => 'puerto', 'width' => 'caracteres por línea'];
    }
}
