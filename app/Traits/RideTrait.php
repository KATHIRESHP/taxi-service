<?php

namespace App\Traits;

use App\Models\Drivers;
use App\Models\Payments;
use App\Models\Ride;

trait RideTrait
{
    public function completeRide(Ride $ride)
    {
        if ($ride->status != 'payment') {
            $amount = \Helper::fareCalculator($ride->distance, $ride->updated_at, now());
            $payment = Payments::where('ride_id', $ride->id)->first();
            if (!$payment) {
                Payments::create([
                    'ride_id' => $ride->id,
                    'user_id' => $ride->user_id,
                    'amount' => $amount,
                    'status' => 'pending'
                ]);
            }
            $ride->status = 'payment';
            $ride->save();
        }
    }
}
