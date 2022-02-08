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
        $first = $this->faker->firstName();
        $last= $this->faker->lastName();
        $domain = $this->faker->domainName();
        $email = $first .'.'.$last .'@'. $domain;
        return [
            'first' => $first,

            'last' => $last,
            'email' => $this->faker->email(),
            'title' => $this->faker->title($gender='male'|'female'),
            'street' => $this->faker->streetName,
            'city' => $this->faker->city,
            'phone' => $this->faker->phoneNumber,

        ];
    }
}
