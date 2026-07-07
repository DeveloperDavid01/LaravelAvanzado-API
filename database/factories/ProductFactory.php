<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(20), // Cambiado a text(20) ya que 'name' suele generar nombres de personas
            'price' => $this->faker->numberBetween(10000, 60000),
            
            'category_id' => \App\Models\Category::factory(),
            
            'created_by' => \App\Models\User::factory(),
        ];
    }
}