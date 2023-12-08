<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Drivers extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = "driver";

    protected $guarded = [];

    protected $hidden = ['password', 'created_at', 'updated_at'];

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'driver_id', 'id');
    }
}
