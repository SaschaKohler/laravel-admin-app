<?php

namespace App\Http\Resources;

use Okami101\LaravelAdmin\Http\Resources\BaseResource;

class Vehicle extends BaseResource
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

//        $attributes['chartData'] = [ 'labels' => [ 'J', 'M', 'D', 'A', 'O', 'N'] ,
//                                        'series' => [
//                                            [12,49,17,34,4,7],
//                                            [24,3,12,3,29,19],
//                                        ]
//        ];

        return $attributes;
    }
}
