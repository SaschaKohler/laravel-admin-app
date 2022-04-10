<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOffer;
use App\Http\Requests\UpdateOffer;
use App\Http\Resources\Offer as OfferResource;
use App\Models\Offer;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Offer::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return OfferResource::collection(
            QueryBuilder::for(Offer::class)
                ->with('customer:id,first,last,brand,county,type,street,city')

                ->allowedFilters([
                    AllowedFilter::custom('q', new SearchFilter(['type'])),
                    AllowedFilter::exact('id'),
                    AllowedFilter::partial('type'),
                ])
                ->allowedSorts(['type'])
                ->exportOrPaginate()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return OfferResource
     */
    public function show(Offer $offer)
    {
        return new OfferResource($offer->load(['customer','media']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return OfferResource
     */
    public function store(StoreOffer $request)
    {
        $offer = Offer::create($request->all());

        if (request()->hasFile('images')) {
            $offer->addMultipleMediaFromRequest(['images'])
                ->each(function (FileAdder $file)  {
                    $file->toMediaCollection('images');
                });
        }

        return new OfferResource($offer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return OfferResource
     */
    public function update(UpdateOffer $request, Offer $offer)
    {
        $offer->update($request->all());

        if (request()->hasFile('images')) {
            $offer->addMultipleMediaFromRequest(['images'])
                ->each(function (FileAdder $file)  {
                    $file->toMediaCollection('images');
                });
        }

        return new OfferResource($offer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Offer $offer)
    {
        $offer->delete();

        return response()->noContent();
    }
}
