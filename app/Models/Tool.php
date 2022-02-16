<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'acquisitionDate', 'acquisitionPrice'];

    protected $casts = ['acquisitionDate' => 'date', 'acquisitionPrice' => 'date'];

    public function events()
    {
        return $this->belongsToMany(Event::class)->withDefault()->withTimestamps();
    }
}
