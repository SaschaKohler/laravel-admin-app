<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'roles','address','phone1',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'email_verified_at' => 'datetime',
        'roles' => 'array',
    ];

    public function hasRole(...$roles)
    {
        return (bool) count(array_intersect($this->roles, $roles));
    }

    public function events()
    {
        return $this->belongsToMany(Event::class)->using(EventUser::class)
            ->withTimestamps();
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

}
