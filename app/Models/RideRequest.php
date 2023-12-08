<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideRequest extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ["created_at", "updated_at"];

    public function ride()
    {
        return $this->belongsTo(Ride::class, 'ride_id', 'id');
    }

    public function driver()
    {
        return $this->belongsTo(Ride::class, 'driver_id', 'id');
    }
}
