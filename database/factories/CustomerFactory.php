<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pref = [
            1 => 'Herr',
            2 => 'Frau',
            3 => 'Familie'
        ];

        $first = $this->faker->firstName();
        $last = $this->faker->lastName();
        $domain = $this->faker->domainName();
        $email = $first . '.' . $last . '@' . $domain;

        return [
            'first' => $first,

            'last' => $last,
            'email' => $this->faker->email(),
            'prefix' => $pref[random_int(1,3)],
            'title' => $this->faker->title($gender = 'male' | 'female'),
            'street' => $this->faker->streetName,
            'city' => $this->faker->city,
            'phone' => $this->faker->phoneNumber,

        ];
    }
}
