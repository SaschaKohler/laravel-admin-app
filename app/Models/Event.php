<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

   protected $guarded = ['id'];
    // protected $fillable = ['type', 'color', 'start', 'end', 'event_id', 'customer_id'];

    protected $casts = ['start' => 'date', 'end' => 'date'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class)
            ->withPivot(['kmBegin','kmEnd','kmSum'])
            ->withTimestamps();
    }

}
