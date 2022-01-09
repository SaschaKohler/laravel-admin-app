<?php

namespace App\Http\Controllers;

use App\Http\Resources\Statistic;
use App\Models\Event;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $builder = Event::with('vehicles');



        return Statistic::collection($builder->get());



        // dump($collection->toArray());
    }
}
