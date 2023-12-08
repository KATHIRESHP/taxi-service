<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ride()
    {
        return $this->belongsTo(Ride::class, 'id', 'ride_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function driver()
    {
        return $this->belongsTo(Drivers::class, 'rides', 'id', 'driver_id');
    }
}
