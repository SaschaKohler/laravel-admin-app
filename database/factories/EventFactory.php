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
        $dateTime = $this->faker->dateTimeBetween('-1 month','+2 month');
        return [
            'type' => $this->faker->randomElement(['Baumpflege','Zaunbau','Gartenpflege',
                    'Transport','pers. Termin','Winterdienst','Sonstiges']),
            'start' => $dateTime,
            'end' => $dateTime,

        ];
    }
}
