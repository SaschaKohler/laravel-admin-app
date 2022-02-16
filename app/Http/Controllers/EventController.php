<?php

namespace App\Http\Controllers;

use App\Events\EventStatusUpdated;
use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;
use App\Http\Resources\Customer;
use App\Http\Resources\Event as EventResource;
use App\Mail\EventConfirm;
use App\Mail\EventDismiss;
use App\Models\EventUser;
use App\Models\Tool;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Okami101\LaravelAdmin\Filters\SearchFilter;
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
                ->with('vehicles:branding,type')
                ->with('customer:id,first,last,city')
                ->with('users:id,name')
                ->with('tools:title')
                ->allowedFilters([
                    AllowedFilter::custom('q', new SearchFilter(['type'])),
                    AllowedFilter::callback('vehicles', function (Builder $query, $value) {
                        $query->whereHas('vehicles', function (Builder $query) use ($value) {
                            $query->where('vehicle_id', '=',  $value );
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
                            $query->where('last', 'LIKE', '%' . $value . '%');
                        });
                    }),
                    AllowedFilter::scope('starts_after'),
                    AllowedFilter::scope('starts_before'),
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('fixed'),
                    AllowedFilter::exact('finished'),
                    AllowedFilter::partial('type'),
                ])
                ->allowedSorts(['id','start','type', 'customer', 'updated_at', 'finished','fixed'])
                ->allowedIncludes(['customer', 'users', 'tools','vehicles'])
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
        return new EventResource($event->load(['vehicles', 'users', 'customer', 'tools']));
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


        if (is_array($request->input('user_ids'))) {
            $event->users()->sync($request->input('user_ids'));
        }
        if (is_array($request->input('vehicle_ids')) ) {
            $event->vehicles()->sync($request->input('vehicle_ids'));
        }
        if (is_array($request->input('tool_ids'))) {
            $event->tools()->sync($request->input('tool_ids'));
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
    public function update(UpdateEvent $request, Event $event)
    {

        if (($request->has('vehicle_ids') || $request->has('tool_ids') || $request->has('user_ids')) &&
            (!is_array($request->input('vehicle_ids')[0]) || !is_array($request->input('tool_ids')[0]) || !is_array($request->input('user_ids')[0]))) {

            if ($request->has('vehicle_ids')) {
                $event->vehicles()->sync($request->input('vehicle_ids'));
            }
            if ($request->has('tool_ids')) {
                $event->tools()->sync($request->input('tool_ids'));
            }
            if ($request->has('user_ids')) {
                $event->users()->sync($request->input('user_ids'));
            }
        } else {

            if ($request->has('vehicle_ids')) {

                $vehicleSync = array();

                foreach ($request->input('vehicle_ids') as $vehicle) {

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
            if ($request->has('tool_ids')) {
                $toolSync = array();

                foreach ($request->input('tool_ids') as $tool) {
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
            if ($request->has('user_ids')) {
                $usersSync = array();

                foreach ($request->input('user_ids') as $user) {
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

    public function sendConfirmMail(Event $event)
    {

        Mail::to($event->customer->email)->send(new EventConfirm($event));

        $event->fixed = true;
        $event->save();

        return response()->json(['message' => 'Email an ' . $event->customer->email . ' versendet'], 200);
    }

    public function sendDismissMail(Event $event)
    {

        Mail::to($event->customer->email)->send(new EventDismiss($event));

        $event->fixed = false;
        $event->save();

        return response()->json(['message' => 'Email an ' . $event->customer->email . ' versendet'], 200);
    }


}
