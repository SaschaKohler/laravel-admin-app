<?php

namespace App\Http\Resources;

use Okami101\LaravelAdmin\Http\Resources\BaseResource;

class Event extends BaseResource
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

        $attributes['pivot'] = $this->whenPivotLoaded('event_vehicle', function(){
            return $this->pivot->kmSum;
        });
        return $attributes;

    }
}
