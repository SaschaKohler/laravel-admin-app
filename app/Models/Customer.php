<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['first', 'last', 'street', 'city', 'phone'];

    protected $casts = [];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
