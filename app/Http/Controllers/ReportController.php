<?php

namespace App\Http\Controllers;

use App\Http\Resources\Report as ReportResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ReportController extends Controller
{


    public function index(Request $request)
    {

        $filter = $request->get('filter')['users'] ?? ''; // this is for filtering the include if there a r more than one user in it!

        return ReportResource::collection(QueryBuilder::for(Event::class)
            ->with('users', function ($query) use ($filter) {
                $query->where('name', 'LIKE', '%' . $filter . '%');

            })
            ->allowedFilters([
                AllowedFilter::callback('users', function (Builder $query, $value) {
                    $query->whereHas('users', function (Builder $query) use ($value) {
                        $query->where('name', 'LIKE', '%' . $value . '%');
                    });
                }),
                AllowedFilter::scope('starts_after'),
                AllowedFilter::scope('starts_before'),
                AllowedFilter::exact('finished'),
            ])
            ->allowedIncludes(['customer','users'])
            ->exportOrPaginate()
        );

    }
}
