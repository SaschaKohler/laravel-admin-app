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
        'name',
        'name2',
        'manager',
        'manager_title',
        'brand',
        'county',
        'title',
        'email',
        'email2',
        'street',
        'city',
        'phone',
        'phone2',
        'phone3',
        'uident',
        'kunr',
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
