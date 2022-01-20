<?php

namespace App\Http\Controllers;

use App\Http\Resources\Statistic as StatisticResource;
use App\Models\Event;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class StatisticsController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Event::class);
    }


    public function index()
    {

        return StatisticResource::collection(
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
                            $query->where('user_id', '=', $value );
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
                ->allowedSorts(['id', 'start', 'workingHours', 'type', 'customer', 'updated_at','finished'])
                ->allowedIncludes(['customer', 'vehicles', 'users', 'tools'])
                ->exportOrPaginate()
        );
    }


}
