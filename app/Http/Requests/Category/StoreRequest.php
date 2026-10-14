<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:50', Rule::unique('categories', 'name')],
            'descriptions' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes()
    {
        return ['name' => 'nombre', 'descriptions' => 'descripción'];
    }
}
