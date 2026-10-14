<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->unique()->company(),
            'email' => fake()->unique()->companyEmail(),
            'nit' => (string) fake()->unique()->numerify('9########-#'),
            'adress' => fake()->address(),
            'phone' => fake()->numerify('3#########'),
        ];
    }
}
