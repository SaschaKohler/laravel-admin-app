<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicket;
use App\Http\Requests\UpdateTicket;
use App\Http\Resources\Ticket as TicketResource;
use App\Models\Ticket;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Ticket::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return TicketResource::collection(
            QueryBuilder::for(Ticket::class)
                ->allowedFilters([
                    AllowedFilter::custom('q', new SearchFilter([])),
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('event_id'),

                ])
                ->allowedSorts(['event', 'user', 'rating', 'status'])
                ->allowedIncludes(['event','user'])
                ->exportOrPaginate()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return TicketResource
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket->load(['event','user']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return TicketResource
     */
    public function store(StoreTicket $request)
    {
        $ticket = Ticket::create($request->all());

        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return TicketResource
     */
    public function update(UpdateTicket $request, Ticket $ticket)
    {
        $ticket->update($request->all());

        return new TicketResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response()->noContent();
    }
}
