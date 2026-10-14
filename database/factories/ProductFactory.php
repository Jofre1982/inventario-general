<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'code' => (string) fake()->unique()->ean13(),
            'stock' => 0,
            'min_stock' => 5,
            'sell_price' => fake()->numberBetween(1, 200) * 100,
            'status' => 'ACTIVE',
            'category_id' => \App\Models\Category::factory(),
            'provider_id' => \App\Models\Provider::factory(),
        ];
    }
}
