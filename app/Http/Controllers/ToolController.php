<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTool;
use App\Http\Requests\UpdateTool;
use App\Http\Resources\Tool as ToolResource;
use App\Models\Tool;
use Okami101\LaravelAdmin\Filters\SearchFilter;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ToolController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Tool::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ToolResource::collection(
            QueryBuilder::for(Tool::class)
                ->allowedFilters([
                    AllowedFilter::custom('q', new SearchFilter(['title', 'acquisitionDate', 'acquisitionPrice'])),
                    AllowedFilter::exact('id'),

                ])
                ->allowedSorts(['title', 'acquisitionDate', 'acquisitionPrice'])
                ->allowedIncludes([])
                ->get()
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tool  $tool
     * @return ToolResource
     */
    public function show(Tool $tool)
    {
        return new ToolResource($tool->load([]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ToolResource
     */
    public function store(StoreTool $request)
    {
        $tool = Tool::create($request->all());

        return new ToolResource($tool);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tool  $tool
     * @return ToolResource
     */
    public function update(UpdateTool $request, Tool $tool)
    {
        $tool->update($request->all());

        return new ToolResource($tool);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tool  $tool
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Tool $tool)
    {
        $tool->delete();

        return response()->noContent();
    }
}
