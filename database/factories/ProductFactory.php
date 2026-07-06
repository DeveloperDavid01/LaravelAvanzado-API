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
            'name' => $this->faker->name,
            'price' => $this->faker->numberBetween(10000, 60000),
            'category_id' => function () {
                return \App\Models\Category::query()->inRandomOrder()->first()->id;
            },
            'created_by' => function () {
                return \App\Models\User::query()->inRandomOrder()->first()->id;
            }
        ];
    }
}