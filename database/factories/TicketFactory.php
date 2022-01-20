<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'rating' => $this->faker->numberBetween(1,5),
            'status' => $this->faker->randomElement(['new', 'open', 'progress','ready']),
            'body' => $this->faker->paragraph(5)
        ];
    }
}
