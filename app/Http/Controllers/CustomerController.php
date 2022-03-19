<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomer;
use App\Http\Requests\UpdateCustomer;
use App\Http\Resources\Customer as CustomerResource;
use App\Models\Customer;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $resource = CustomerResource::collection(
            QueryBuilder::for(Customer::class)
                ->allowedFilters([
                    AllowedFilter::custom('q', new SearchFilter(['county','brand','first', 'last', 'street', 'city'])),
                    AllowedFilter::exact('id'),
                    AllowedFilter::partial('city'),
                    AllowedFilter::partial('last'),
                    AllowedFilter::partial('brand'),
                    AllowedFilter::partial('county'),
                    AllowedFilter::partial('first'),
                    AllowedFilter::exact('type'),
                    AllowedFilter::exact('offer'),



                ])
                ->allowedSorts(['county','brand','offer','offerType','first', 'last', 'street', 'city','email'])
                ->allowedIncludes('events')
                ->get()
        );
        return $resource;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return CustomerResource
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer->load([]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CustomerResource
     */
    public function store(StoreCustomer $request)
    {
        $customer = Customer::create($request->all());

        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return CustomerResource
     */
    public function update(UpdateCustomer $request, Customer $customer)
    {
        $customer->update($request->all());

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->noContent();
    }
}
