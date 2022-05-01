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
            1 => '-',
            2 => 'Herr',
            3 => 'Frau',
        ];

        $first = $this->faker->firstName();
        $last = $this->faker->lastName();
        $domain = $this->faker->domainName();
        $email = $first . '.' . $last . '@' . $domain;
        $customerType = random_int(1, 3);
        $prefix = $pref[random_int(1, 3)];
        $brand = $this->faker->company();
        $county = $this->faker->city();


        return [

            'name' => $last . ' ' . $first,
            'email' => $email,
            'offer' => random_int(0, 1),
            'prefix' => $prefix,
            'manager' => $last . ' ' . $first,
            'title' => $this->faker->title($gender = 'male' | 'female'),
            'street' => $this->faker->streetName,
            'city' => $this->faker->city,
            'phone' => $this->faker->phoneNumber,
            'county' => $county,
            'brand' => $brand,
            'type' => $customerType,
            'can_job_order' => random_int(0,1)

        ];
    }
}
