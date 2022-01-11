<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvent;
use App\Http\Requests\UpdateEvent;
use App\Http\Resources\Event as EventResource;
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
                ->allowedSorts(['start', 'workingHours', 'type', 'customer'])
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


//        $vehicleSync = array();
//
//        foreach ($request->vehicles as $vehicle) {
//
//            $vehicleSync[] = $vehicle['pivot']['vehicle_id'];
//        }
//        $event->vehicles()->sync($vehicleSync);

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
        $event->update($request->all());

        if($request->users) {
            if ($request->vehicles) {
                $event->vehicles()->sync($request->vehicles);
            }
            if ($request->tools) {
                $event->tools()->sync($request->tools);
            }

            $event->users()->sync($request->users);

        } else {

        $vehicleSync = array();
            foreach ($request->vehicles as $vehicle) {

                if ($vehicle['pivot']['kmEnd'] || $vehicle['pivot']['kmBegin']) {
                    $sum = $vehicle['pivot']['kmEnd'] - $vehicle['pivot']['kmBegin'];
                    $vehicle['kmAll'] += $sum;
                    $vehicleSync[$vehicle['pivot']['vehicle_id']] = [
                        'kmBegin' => $vehicle['pivot']['kmBegin'],
                        'kmEnd' => $vehicle['pivot']['kmEnd'],
                        'kmSum' => $sum
                    ];
                    $vehicleModel = Vehicle::find($vehicle['pivot']['vehicle_id']);
                    $vehicleModel->kmAll += $sum;
                    $vehicleModel->save();
                }
            }
            if (count($vehicleSync) > 0) {
                $event->vehicles()->sync($vehicleSync);
            }



        }






        return new EventResource($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Event $event
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->noContent();
    }
}
