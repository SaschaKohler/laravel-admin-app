<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Event;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{


    protected $colors = ['blue','yellow','green','amber','orange','purple','red'];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();

        Event::factory(10)->make()->each(function (Event $event) use ($customers,$vehicles){
            $event->customer()->associate($customers->random());

            $event->color = $this->colors[random_int(0,6)];
            $event->save();
            $event->vehicles()->sync($vehicles->random(random_int(2, 10)));
        });
    }
}
