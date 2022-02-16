<?php

namespace App\Models;

use App\Observers\RecurrenceObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    // protected $fillable = ['type', 'color', 'start', 'end', 'event_id', 'customer_id'];

    protected $casts = ['start' => 'date:Y-m-d', 'end' => 'date'];   // in order to get right data format for vuetify calendar !

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
            ->withPivot(['kmBegin', 'kmEnd', 'kmSum', 'hours'])
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->using(EventUser::class)
            ->withPivot('startTime')
            ->withPivot('endTime')
            ->withPivot('hours')
            ->withTimestamps();
    }

    public function allowedUsers($value)
    {
        return $this->users()->where('user_id','=', $value );
    }

    public function scopeStartsAfter(Builder $query, $date): Builder
    {
        return $query->where('start', '>=', Carbon::parse($date));
    }

    public function scopeStartsBefore(Builder $query, $date): Builder
    {
        return $query->where('start', '<=', Carbon::parse($date));
    }

    public function tools()
    {
        return $this->belongsToMany(Tool::class)
            ->withPivot('hours')
            ->withTimestamps();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

}
