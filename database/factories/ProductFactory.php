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
            'name'=>$this->faker->name(),
            'description'=>$this->faker->paragraph(5),
            'price'=>$this->faker->numberBetween(100, 250),
            'image'=>'/images/2.jpg',
            'tags'=>'blue, apple, sauce'
        ];
    }
}
