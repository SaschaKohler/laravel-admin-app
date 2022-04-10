<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;


    protected $fillable = [
        'type',
        'prefix',
        'offer',
        'offerType',
        'brand',
        'county',
        'title',
        'first',
        'last',
        'email',
        'street',
        'city',
        'phone',
        'can_job_order'
    ];

    protected $casts = [];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function orderEvents()
    {
        return $this->hasMany(Event::class,'id',);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
}
