<?php
namespace App\Http\Resources;

use Okami101\LaravelAdmin\Http\Resources\BaseResource;

class Report extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $attributes = parent::toArray($request);

        $attributes['sumHours'] =$this->users()->sum('hours');

        return $attributes;

    }
}
