<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $events = Event::all();
        $users = User::all();

        Ticket::factory(10)->make()->each(function (Ticket $ticket) use ($events , $users) {
            $ticket->event()->associate($events->random());
            $ticket->user()->associate($users->random());
            $ticket->save();
        });
    }

}
