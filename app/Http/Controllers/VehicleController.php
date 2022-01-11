<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicle;
use App\Http\Requests\UpdateVehicle;
use App\Http\Resources\Vehicle as VehicleResource;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Vehicle::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return VehicleResource::collection(
            QueryBuilder::for(Vehicle::class)
                ->allowedFilters([
                    AllowedFilter::custom('q', new SearchFilter(['id','type', 'branding', 'insurance_company'])),
                    AllowedFilter::callback('events', function (Builder $query, $value) {
                        $query->whereHas('events', function (Builder $query) use ($value) {
                            $query->where('type', 'LIKE' , '%' .$value. '%');
                        });
                    }),
                    AllowedFilter::exact('type'),
                    AllowedFilter::exact('id'),
                    AllowedFilter::partial('insurance_company'),
                    AllowedFilter::partial('branding'),
                ])
                ->allowedSorts(['type', 'permit', 'inspection','kmAll'])
                ->allowedIncludes(['events'])
                ->exportOrPaginate()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return VehicleResource
     */
    public function show(Vehicle $vehicle)
    {
        return new VehicleResource($vehicle->load([]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return VehicleResource
     */
    public function store(StoreVehicle $request)
    {
        $vehicle = Vehicle::create($request->all());

        return new VehicleResource($vehicle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return VehicleResource
     */
    public function update(UpdateVehicle $request, Vehicle $vehicle)
    {
        $vehicle->update($request->all());

        return new VehicleResource($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->noContent();
    }
}
