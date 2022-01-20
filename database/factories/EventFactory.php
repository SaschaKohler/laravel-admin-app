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
            'type' => $this->faker->randomElement(['Baumpflege','Zaunbau','Gartenpflege',
                    'Transport','pers. Termin','Winterdienst','Sonstiges']),
            'start' => $this->faker->dateTimeBetween('-1 month','+2 month'),

        ];
    }
}
