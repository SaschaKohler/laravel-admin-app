<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'roles' => ['admin']
        ]);

        User::factory()->create([
            'name' => 'Employee',
            'email' => 'employee@example.com',
            'roles' => ['employee','indoor','admin']
        ]);

        for ($i = 1; $i <= 10; $i++) {
            User::factory()->create([
                'name' => "Employee $i",
                'email' => "employee-$i@example.com",
                'roles' => ['employee', 'outdoor'],
            ]);
        }


    }
}
