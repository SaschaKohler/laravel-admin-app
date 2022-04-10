<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;
use App\Http\Resources\Event as EventResource;
use App\Mail\EventConfirm;
use App\Mail\EventDismiss;
use App\Models\Tool;
use App\Models\Traits\MyMediaTrait;
use App\Models\Vehicle;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EventController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Event::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return EventResource::collection(
            QueryBuilder::for(Event::class)
                ->with('vehicles:id,branding,type')
                ->with('customer:id,prefix,title,first,last,brand,phone,email,county,type,street,city')
                ->with('users:id,name')
                ->with('customerOrder:id,prefix,title,first,last,brand,phone,email,county,type,street,city')
                ->with('tools:id,title')
                ->allowedFilters([
                    AllowedFilter::custom('q', new SearchFilter(['type'])),

                    AllowedFilter::callback('vehicles', function (Builder $query, $value) {
                        $query->whereHas('vehicles', function (Builder $query) use ($value) {
                            $query->where('vehicle_id', '=', $value);
                        });
                    }),
                    AllowedFilter::callback('users', function (Builder $query, $value) {
                        $query->whereHas('users', function (Builder $query) use ($value) {
                            $query->where('name', 'LIKE', '%' . $value . '%');
                        });
                    }),
                    AllowedFilter::callback('users_id', function (Builder $query, $value) {
                        $query->whereHas('users', function (Builder $query) use ($value) {
                            $query->where('user_id', '=', $value);
                        });
                    }),
                    AllowedFilter::callback('vehicle_id', function (Builder $query, $value) {
                        $query->whereHas('vehicles', function (Builder $query) use ($value) {
                            $query->where('vehicle_id', '=', $value);
                        });
                    }),
                    AllowedFilter::callback('customer', function (Builder $query, $value) {
                        $query->whereHas('customer', function (Builder $query) use ($value) {
                            $query->where('customers.id', '=', $value);
                        });
                    }),
                    AllowedFilter::scope('where_has'),
                    AllowedFilter::scope('starts_after'),
                    AllowedFilter::scope('starts_before'),
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('fixed'),
                    AllowedFilter::exact('finished'),
                    AllowedFilter::partial('type'),
                ])
                ->allowedSorts(['id', 'is_job_order','start', 'type', 'customer', 'updated_at', 'finished', 'fixed'])
                ->allowedIncludes(['customer', 'users', 'tools', 'vehicles','customerOrder'])
                ->orderBy('start')
                ->get()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Event $event
     * @return EventResource
     */
    public function show(Event $event)
    {
        return new EventResource($event->load(['vehicles', 'users', 'customer', 'tools', 'media','customerOrder']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return EventResource
     */
    public function store(StoreEvent $request)
    {

        $event = Event::create($request->all());

        switch ($request->type) {
            case 'Baumpflege':
                $event->color = "brown lighten-1";
                break;
            case 'Stockfräsen':
                $event->color = "orange";
                break;
            case 'Zaunbau':
                $event->color = "purple";
                break;
            case 'Gartenpflege':
                $event->color = "green";
                break;
            case 'Transport':
                $event->color = "blue";
                break;
            case 'pers_Termin':
                $event->color = "red";
                break;
            case 'Winterdienst':
                $event->color = "grey";
                break;
            case 'Sonstiges':
                $event->color = "orange darken-1";
                break;
        }

            $event->end = $request->start;
            $event->save();

        if (request()->hasFile('images')) {
            $event->addMultipleMediaFromRequest(['images'])
                ->each(function (FileAdder $file)  {
                    $file->toMediaCollection('images');
                });
        }


        if (is_array($request->input('users'))) {
                $event->users()->sync($request->input('users'));
            }
            if (is_array($request->input('vehicles'))) {
                $event->vehicles()->sync($request->input('vehicles'));
            }
            if (is_array($request->input('tools'))) {
                $event->tools()->sync($request->input('tools'));
            }

            return new EventResource($event);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param \App\Models\Event $event
         * @return EventResource
         */
        public
        function update(UpdateEvent $request, Event $event)
        {
            if (request()->hasFile('images')) {
                $event->addMultipleMediaFromRequest(['images'])
                    ->each(function (FileAdder $file) {
                        $file->toMediaCollection('images');
                    });
            }


            if ($request->has('allDay')) {
                if (!$request->allDay) {
                    $event->allDay = false;
                    $event->startTime = $request->startTime;
                    $event->endTime = $request->endTime;
                } else {
                    $event->allDay = true;
                    $event->startTime = Carbon::parse('07:00:00')->format('H:i:s');
                    $event->endTime = Carbon::parse('16:00:00')->format('H:i:s');

                }
            }

            if ($event->allDay) {
                $event->startTime = Carbon::parse('07:00:00')->format('H:i:s');
                $event->endTime = Carbon::parse('16:00:00')->format('H:i:s');
            }


            if (($request->has('vehicles') || $request->has('tools') || $request->has('users')) &&
                (!is_array($request->input('vehicles')[0]) || !is_array($request->input('tools')[0]) || !is_array($request->input('users')[0]))) {

                if ($request->has('vehicles')) {
                    $event->vehicles()->sync($request->input('vehicles'));
                }
                if ($request->has('tools')) {
                    $event->tools()->sync($request->input('tools'));
                }
                if ($request->has('users')) {
                    $event->users()->sync($request->input('users'));
                }
            } else {

                if ($request->has('vehicles')) {

                    $vehicleSync = array();

                    foreach ($request->input('vehicles') as $vehicle) {

                        if ($vehicle['pivot']['kmEnd'] || $vehicle['pivot']['kmBegin'] || $vehicle['pivot']['hours']) {
                            $sum = $vehicle['pivot']['kmEnd'] - $vehicle['pivot']['kmBegin'];
                            $vehicle['kmAll'] += $sum;
                            $vehicleSync[$vehicle['pivot']['vehicle_id']] = [
                                'kmBegin' => $vehicle['pivot']['kmBegin'],
                                'kmEnd' => $vehicle['pivot']['kmEnd'],
                                'hours' => $vehicle['pivot']['hours'],
                                'kmSum' => $sum
                            ];
                            $vehicleModel = Vehicle::find($vehicle['pivot']['vehicle_id']);

                            if ($sum != 0) {
                                $vehicleModel->kmAll += $sum;
                            }
                            if ($vehicle['pivot']['hours'] != 0) {
                                $vehicleModel->hoursAll += $vehicle['pivot']['hours'];
                            }
                            $vehicleModel->save();
                        }
                        if (count($vehicleSync) > 0) {
                            $event->vehicles()->sync($vehicleSync);
                        }
                    }
                }
                if ($request->has('tools')) {
                    $toolSync = array();

                    foreach ($request->input('tools') as $tool) {
                        $toolSync[$tool['pivot']['tool_id']] = [
                            'hours' => $tool['pivot']['hours'],
                        ];
                        $toolModel = Tool::find($tool['pivot']['tool_id']);
                        $toolModel->hoursAll += $tool['pivot']['hours'];
                        $toolModel->save();
                    }
                    if (count($toolSync) > 0) {
                        $event->tools()->sync($toolSync);
                    }
                }
                if ($request->has('users')) {
                    $usersSync = array();

                    foreach ($request->input('users') as $user) {
                        $work = Carbon::parse($user['pivot']['endTime'])->diff(Carbon::parse($user['pivot']['startTime']))->format('%H:%i');
                        $diff = Carbon::parse($user['pivot']['endTime'])->diffInHours(Carbon::parse($user['pivot']['startTime']));

                        $usersSync[$user['pivot']['user_id']] = [
                            'hours' => $work, //$user['pivot']['hours'],
                            'startTime' => $user['pivot']['startTime'],
                            'endTime' => $user['pivot']['endTime']
                        ];


//                    $userModel = User::find($user['pivot']['user_id']);
//                    $userModel->hoursAll += $user['pivot']['hours'];
//                    $userModel->save();
                    }
                    if (count($usersSync) > 0) {
                        $event->users()->sync($usersSync);
                    }
                }
            }
            $event->update($request->all());


            return new EventResource($event);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param \App\Models\Event $event
         * @return \Illuminate\Http\Response
         * @throws \Exception
         */
        public
        function destroy(Event $event)
        {
            $event->delete();

            return response()->noContent();
        }

        public
        function sendConfirmMail(Event $event)
        {

            Mail::to($event->customer->email)->send(new EventConfirm($event));

            $event->fixed = true;
            $event->save();

            return response()->json(['message' => 'Email an ' . $event->customer->email . ' versendet'], 200);
        }

        public
        function sendDismissMail(Event $event)
        {

            Mail::to($event->customer->email)->send(new EventDismiss($event));

            $event->fixed = false;
            $event->save();

            return response()->json(['message' => 'Email an ' . $event->customer->email . ' versendet'], 200);
        }


    }
