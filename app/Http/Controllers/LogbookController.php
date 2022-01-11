<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEvent;
use App\Http\Resources\Event as EventResource;
use App\Http\Resources\Logbook as LogbookResource;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class LogbookController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Event::class);
    }

    public function index()
    {
        return LogbookResource::collection(
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
                ->allowedSorts(['start',  'type', 'customer'])
                ->allowedIncludes(['vehicles'])
                ->exportOrPaginate()
        );
    }

    public function show(Event $event)
    {
        return new LogbookResource($event->load(['vehicles']));
    }

    public function update(UpdateEvent $request, Event $event)
    {
        $event->update($request->all());

        //       $vehicleSync = array();

//        foreach ($request->vehicles as $vehicle) {
//
//            if (!$vehicle['pivot']['kmEnd'] || !$vehicle['pivot']['kmBegin']) {
//                $sum = $vehicle['pivot']['kmEnd'] - $vehicle['pivot']['kmBegin'];
//                $vehicle['kmAll'] += $sum;
//                $vehicleSync[$vehicle['pivot']['vehicle_id']] = [
//                    'kmBegin' => $vehicle['pivot']['kmBegin'],
//                    'kmEnd' => $vehicle['pivot']['kmEnd'],
//                    'kmSum' => $sum
//                ];
//                $vehicleModel = Vehicle::find($vehicle['pivot']['vehicle_id']);
//                $vehicleModel->kmAll += $sum;
//                $vehicleModel->save();
//            }
//        }
//        if (count($vehicleSync) > 0) {
//            $event->vehicles()->sync($vehicleSync);
//        }


        if ($request->vehicles) {
            $event->vehicles()->sync($request->vehicles);
        }
        if ($request->tools) {
            $event->tools()->sync($request->tools);
        }

        $event->users()->sync($request->users);


        return new EventResource($event);
    }

}
