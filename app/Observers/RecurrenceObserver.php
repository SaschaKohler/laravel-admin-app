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
            $start = Carbon::parse(explode(' ',$event->start)[0]);
            $recurrence = $recurrences[$event->recurrence] ?? null;
            $color = $event->color;
            $type = $event->type;
            $customer_id = $event->customer_id;
            $notes = $event->notes;
            $allDay = $event->allDay;

            if(!$allDay) {
                $startTime = Carbon::parse($event->startTime);//->format('H:i:s');
                $endTime = Carbon::parse($event->endTime);//->format('H:i:s');
            }
            else{
                $startTime = Carbon::parse('07:00:00');//->format('H:i:s');
                $endTime = Carbon::parse('16:00:00');//->format('H:i:s');

            }

            if ($recurrence)
                for ($i = 0; $i < $recurrence['times']; $i++) {
                    $start->{$recurrence['function']}($recurrence['value']);
                    $event->events()->create([                 // create child events of parent event
                        'name' => $event->name,
                        'start' => $start,                 // whole day not over days
                        'startTime' => $startTime,                 // whole day not over days
                        'endTime' => $endTime,
                        'color' => $color,
                        'type' => $type,
                        'customer_id' => $customer_id,
                        'notes' => $notes,
                        'allDay' => $allDay,
                        'recurrence' => $event->recurrence,
                    ]);

                }


            foreach ($event->events as $item) {  // iterate childEvents and sync the mana-to-many-relationships accordingly
                if (is_array(static::$request->input('user_ids'))) {
                    $item->users()->sync(static::$request->input('user_ids'));
                }
                if (is_array(static::$request->input('vehicle_ids'))) {
                    $item->vehicles()->sync(static::$request->input('vehicle_ids'));
                }
                if (is_array(static::$request->input('tool_ids'))) {
                    $item->tools()->sync(static::$request->input('tool_ids'));
                }

                $item->save();

            }

        }


    }

    public function updated(Event $event)
    {
        if ($event->events()->exists() || $event->event) {
            $startTime = Carbon::parse($event->getOriginal('start'))->diffInRealSeconds($event->start, false);
//            $endTime = Carbon::parse($event->getOriginal('end'))->diffInRealSeconds($event->end, false);
            if ($event->event)   // event is a childEvent so call all events with start bigger than this child
                $childEvents = $event->event->events()->whereDate('start', '>', $event->getAttribute('start'))->get();
            else
                $childEvents = $event->events;

            foreach ($childEvents as $childEvent) {
                if ($startTime)
                    $childEvent->start = Carbon::parse($childEvent->start)->addSeconds($startTime)->format('Y-m-d');
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
