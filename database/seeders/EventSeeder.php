<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Event;
use App\Models\Tool;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{


    protected $colors = ['green lighten-2', 'cyan darken-1', 'blue lighten-2',
        'brown lighten-2', 'red lighten-2', 'grey', 'orange darken-1'];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        $users = User::all();
        $tools = Tool::all();

        Event::factory(10)->make()->each(function (Event $event) use ($customers, $vehicles, $users, $tools) {
            $event->customer()->associate($customers->random());

            $event->color = $this->colors[random_int(0, 6)];
            $event->save();

            $event->vehicles()->sync($vehicles->random(random_int(1, 3)));
            $event->users()->sync($users->random(random_int(1, 3)));
            $event->tools()->sync($tools->random(random_int(1, 5)));
        });
    }
}
