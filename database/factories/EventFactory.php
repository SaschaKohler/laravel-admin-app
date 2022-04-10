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
        $dateTime = $this->faker->dateTimeBetween('-1 month', '+11 month')->format('Y-m-d');;
        $timeStart = Carbon::createFromFormat('H:i', $this->faker->time('H:i'))->format('H:i:s');
        $timeEnd = Carbon::createFromFormat('H:i:s', $timeStart)->addHour()->format('H:i:s');

        $type = $this->faker->randomElement(['Baumpflege', 'Stockfräsen','Zaunbau', 'Gartenpflege',
            'Transport', 'pers_Termin', 'Winterdienst', 'Sonstiges']);

        $color = '';
        switch ($type) {
            case 'Baumpflege' :
                $color = 'brown lighten-1';
                break;
            case 'Stockfräsen' :
                $color = 'orange';
                break;
            case 'Zaunbau':
                $color = 'purple';
                break;
            case 'Gartenpflege':
                $color = 'green';
                break;

            case 'Transport':
                $color = 'blue';
                break;
            case 'pers_Termin':
                $color = 'red';
                break;
            case 'Winterdienst':
                $color = 'grey';
                break;
            case 'Sonstiges':
                $color = 'orange';
        }

        return [
            'type' => $type,
            'color' => $color,
            'start' => $dateTime,
            'end' => $dateTime,

            'startTime' => $timeStart,
            'endTime' => $timeEnd,
            'allDay' => (bool)random_int(0, 1),

        ];
    }
}
