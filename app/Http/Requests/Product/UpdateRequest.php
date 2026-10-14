<?php

namespace App\Http\Requests\Product;

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
            'name' => ['required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($this->route('product'))],
            'code' => ['nullable', 'string', 'max:50', Rule::unique('products', 'code')->ignore($this->route('product'))],
            'sell_price' => ['required', 'numeric', 'min:0'],
            'min_stock' => ['nullable', 'integer', 'min:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'provider_id' => ['required', 'integer', 'exists:providers,id'],
            'picture' => ['nullable', 'image', 'max:4096'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'code' => 'código de barras',
            'sell_price' => 'precio de venta',
            'min_stock' => 'stock mínimo',
            'category_id' => 'categoría',
            'provider_id' => 'proveedor',
            'picture' => 'imagen',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['min_stock' => $this->min_stock ?? 5]);
    }
}
