<?php

namespace App\Models;

use App\Http\Controllers\Driver\DriverController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['created_at', 'update_at'];

    public function riderequests()
    {
        return $this->hasMany(RideRequest::class, 'ride_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function driver()
    {
        return $this->hasOne(Drivers::class, 'id', 'driver_id');
    }

    public function payment()
    {
        return $this->hasOne(Payments::class, 'ride_id', 'id');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class, 'ride_id', 'id');
    }
}
