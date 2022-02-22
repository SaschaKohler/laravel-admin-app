<?php

namespace Database\Factories;

use Carbon\Carbon;
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
        $dateTime = $this->faker->dateTimeBetween('-1 month','+11 month')->format('Y-m-d');;
        $timeStart = Carbon::createFromFormat('H:i', $this->faker->time('H:i'))->format('H:i:s');
        $timeEnd = Carbon::createFromFormat('H:i:s', $timeStart)->addHour()->format('H:i:s');

        return [
            'type' => $this->faker->randomElement(['Baumpflege','Zaunbau','Gartenpflege',
                    'Transport','pers. Termin','Winterdienst','Sonstiges']),
            'start' => $dateTime,
            'end' => $dateTime,
            'startTime' => $timeStart,
            'endTime' => $timeEnd,
            'allDay' => (bool) random_int(0,1),

        ];
    }
}
