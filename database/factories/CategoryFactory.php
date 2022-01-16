<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->colorName(),
            'description' => $this->faker->randomElement([$this->faker->sentence(),null]),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
