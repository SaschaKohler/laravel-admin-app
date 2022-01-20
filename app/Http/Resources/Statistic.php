<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Statistic extends JsonResource
{

    protected $sum = 0;

    public function __construct($resource)
    {
        parent::__construct($resource);

    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $attributes = parent::toArray($request);

        return $attributes;

    }
}
