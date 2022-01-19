<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;
use App\Http\Resources\Event as EventResource;
use App\Models\Tool;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
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
                ->allowedFilters([
                    AllowedFilter::custom('q', new SearchFilter(['type'])),
                    AllowedFilter::callback('vehicles', function (Builder $query, $value) {
                        $query->whereHas('vehicles', function (Builder $query) use ($value) {
                            $query->where('branding', 'LIKE', '%' . $value . '%');
                        });
                    }),
                    AllowedFilter::callback('users', function (Builder $query, $value) {
                        $query->whereHas('users', function (Builder $query) use ($value) {
                            $query->where('name', 'LIKE', '%' . $value . '%');
                        });
                    }),
                    AllowedFilter::callback('customer', function (Builder $query, $value) {
                        $query->whereHas('customer', function (Builder $query) use ($value) {
                            $query->where('last', 'LIKE', '%' . $value . '%');
                        });
                    }),

                    AllowedFilter::exact('id'),
                    AllowedFilter::partial('type'),
                ])
                ->defaultSort('updated_at')
                ->allowedSorts(['id', 'start', 'workingHours', 'type', 'customer', 'created_at', 'updated_at'])
                ->allowedIncludes(['customer', 'vehicles', 'users', 'tools'])
                ->exportOrPaginate()
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

        if ($request->vehicles) {
            $event->vehicles()->sync($request->vehicles);
        }
        if ($request->tools) {
            $event->tools()->sync($request->tools);
        }

        $event->users()->sync($request->users);


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


        if (($request->vehicles || $request->tools || $request->users) &&
            (!is_array($request->vehicles[0]) || !is_array($request->tools[0]) || !is_array($request->users[0]))) {

            if ($request->vehicles) {
                $event->vehicles()->sync($request->vehicles);
            }
            if($request->tools){
                $event->tools()->sync($request->tools);
            }
            $event->users()->sync($request->users);
        } else {

            if ($request->vehicles) {

                $vehicleSync = array();

                foreach ($request->vehicles as $vehicle) {

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
            if($request->tools) {
                $toolSync = array();

                foreach ($request->tools as $tool) {
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
            if($request->users) {
                $usersSync = array();

                foreach ($request->users as $user) {
                    $usersSync[$user['pivot']['user_id']] = [
                        'hours' => $user['pivot']['hours'],
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
}
