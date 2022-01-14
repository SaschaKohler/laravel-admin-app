<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RecurrenceObserver
{
    private static $request;

    public function __construct(Request $request)
    {
        static::$request = $request;
    }

    public static function created(Event $event)
    {
        if (!$event->event()->exists()) {
            $recurrences = [
                1 => [   // weekly
                    'times' => 7,
                    'function' => 'addDay',
                    'value' => 1,
                ],
                2 => [   // weekly
                    'times' => 52,
                    'function' => 'addWeek',
                    'value' => 1,
                ],
                3 => [   // every 14th day
                    'times' => 26,
                    'function' => 'addWeek',
                    'value' => 2
                ],
                4 => [   // monthly
                    'times' => 12,
                    'function' => 'addMonth',
                    'value' => 1
                ],
                5 => [   //  every 3d month
                    'times' => 4,
                    'function' => 'addMonth',
                    'value' => 3
                ],
                6 => [   //  every half year
                    'times' => 2,
                    'function' => 'addMonth',
                    'value' => 6
                ],

            ];
            $startTime = Carbon::parse($event->start);
            $recurrence = $recurrences[$event->recurrence] ?? null;
            $color = $event->color;
            $type = $event->type;
            $customer_id = $event->customer_id;
            $notes = $event->notes;

            if ($recurrence)
                for ($i = 0; $i < $recurrence['times']; $i++) {
                    $startTime->{$recurrence['function']}($recurrence['value']);
                    $event->events()->create([                 // create child events of parent event
                        'name' => $event->name,
                        'start' => $startTime,                 // whole day not over days
                        'end' => $startTime,
                        'color' => $color,
                        'type' => $type,
                        'customer_id' => $customer_id,
                        'notes' => $notes,
                        'recurrence' => $event->recurrence,
                    ]);

                }

//            $employeeIds = array();
//            $vehicleIds = array();
//
//            if (static::$request->vehicles) {
//                $event->vehicles()->sync(static::$request->vehicles);
//            }
//            if (static::$request->tools) {
//                $event->tools()->sync(static::$request->tools);
//            }
//
//            $event->users()->sync(static::$request->users);


            foreach ($event->events as $item) {  // iterate childEvents and sync the mana-to-many-relationships accordingly
                if (static::$request->vehicles) {
                    $item->vehicles()->sync(static::$request->vehicles);
                }
                if (static::$request->tools) {
                    $item->tools()->sync(static::$request->tools);
                }
                $item->users()->sync(static::$request->users);

                $item->save();

            }

        }


    }

    public function updated(Event $event)
    {
        if ($event->events()->exists() || $event->event) {
            $startTime = Carbon::parse($event->getOriginal('start'))->diffInSeconds($event->start, false);
            $endTime = Carbon::parse($event->getOriginal('end'))->diffInSeconds($event->end, false);
            if ($event->event)
                $childEvents = $event->event->events()->whereDate('start', '>', $event->getOriginal('start'))->get();
            else
                $childEvents = $event->events;

            foreach ($childEvents as $childEvent) {
                if ($startTime)
                    $childEvent->start = Carbon::parse($childEvent->start)->addSeconds($startTime);
                //if($endTime)
                $childEvent->end = $childEvent->start;//Carbon::parse($childEvent->end)->addSeconds($endTime);
                if ($event->isDirty('name') && $childEvent->name == $event->getOriginal('name'))
                    $childEvent->name = $event->name;
                $childEvent->saveQuietly();
            }
        }

        if ($event->isDirty('recurrence') && $event->recurrence != 0)
            self::created($event);
    }

}
