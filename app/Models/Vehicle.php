<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['owner', 'type', 'branding', 'permit', 'insurance_type', 'inspection', 'insurance_company', 'insurance_manager'];

    protected $casts = ['inspection' => 'date'];

    public function events()
    {
        return $this->belongsToMany(Event::class)
            ->withPivot(['kmBegin','kmEnd','kmSum']);
    }
}
