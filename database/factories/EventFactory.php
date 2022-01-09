<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'type' => ucfirst($this->faker->words($this->faker->numberBetween(1,5),true)),
            'color' => $this->faker->colorName,

            'start' => $this->faker->date('d-M-Y'),




        ];
    }
}
