<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Logbook extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
        public function toArray($request)
    {
//        return parent::toArray($request);
        $attributes = parent::toArray($request);

        $attributes['pivot'] = $this->whenPivotLoaded('event_vehicle', function(){
            return $this->pivot->kmSum;
        });
        return $attributes;

    }

}
