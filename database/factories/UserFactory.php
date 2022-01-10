<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{


    protected $model = User::class;


    protected $counter = 0;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $users = ['Dirneder, Karl', 'Brunner, Gerald', 'Freinhofer,Martin', 'Holzer, Emanuel', 'Lettner, Birgit',
            'Moser, Philip', 'Ortmayr, Stephan', 'Puehringer, Johann', 'Steinkellner, Günther', 'Pointer, Rudi',
            'Steinbauer, Karl', 'Kohler, Sascha', 'Strasser, Franz', 'Schwaiger, Johann',
        ];
        $roles = [
            '{"role" : "admin" }',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',
            '{"role" : "employee", "outdoor"}',

        ];

        $role = $roles[$this->counter];


        $user = $users[$this->counter];
        $pieces = explode(",", $users[$this->counter]);

        $email = strtolower($pieces[0]) . '@home.at';

        $this->counter += 1;


        return [

            'name' => $user,
            'email' => $email,
            'phone1' => $this->faker->phoneNumber(),
            'phone2' => $this->faker->phoneNumber(),
            'address' => $this->faker->address,
            'category_id' => random_int(1, 3),
            'roles' => ['admin'],
            'email_verified_at' => now(),
            'active' => true,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),

        ];


    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
