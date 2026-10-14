<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'document' => (string) fake()->unique()->numerify('##########'),
            'phone' => fake()->numerify('3#########'),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
