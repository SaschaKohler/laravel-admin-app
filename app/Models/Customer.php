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
        'brand',
        'county',
        'title',
        'first',
        'last',
        'email',
        'street',
        'city',
        'phone'
    ];

    protected $casts = [];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
