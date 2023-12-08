<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Drivers;
use App\Models\Ride;
use App\Models\RideRequest;
use App\Traits\DriverAccessCheckTrait;
use App\Traits\RideTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class DriverRideController extends Controller
{
    use DriverAccessCheckTrait, RideTrait;

    public function __construct()
    {
        $this->middleware("auth:driver");
    }

    public function acceptRide(Ride $ride)
    {
        try {
            if (\auth()->user()->status == "available") {
                $ride->driver_id = \auth()->guard('driver')->id();
                $ride->status = "ongoing";
                $ride->save();

                $rideRequest = RideRequest::where('ride_id', $ride->id)
                    ->where('status', "requested")
                    ->first();
                $rideRequest->status = "picked";
                $rideRequest->save();

                $driver = Drivers::findOrFail(Auth::id());
                $driver->status = "inride";
                $driver->save();
                return to_route('driver.ride.show', $ride->id);
            } else {
                return back()->withError("Your current ride not completed");
            }
        } catch (Exception $e) {
            Log::error("Error in accepting ride by driver " . $e);
        }
    }

    public function currentRide()
    {
        $ride = Ride::where('driver_id', Auth::id())
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->first();
        if ($ride) {
            if ($ride->status == 'payment') {
                $ride = Ride::with(['payment'])
                    ->find($ride->id);
            }
            return view('driver.ride.show', compact('ride'));
        } else {
            return to_route('driver.ride.requests')->withError("You have no ongoing ride");
        }
    }

    public function rejectRide(Ride $ride)
    {
        $rejectRide = RideRequest::where('status', 'requested')
            ->where('ride_id', $ride->id)
            ->first();
        $rejectRide->status = 'rejected';
        $rejectRide->save();
        $availableDrivers = Drivers::where('status', 'available')
            ->where('location', $ride->location)
            ->whereNotIn('id', function ($query) use ($ride) {
                $query->select('driver_id')
                    ->from('ride_requests')
                    ->where('status', 'rejected')
                    ->where('ride_id', $ride->id)
                    ->get();
            })
            ->whereNotIn('id', function ($query) {
                $query->select('driver_id')
                    ->from('ride_requests')
                    ->where('status', 'requested')
                    ->get();
            })
            ->get();
        if (count($availableDrivers) > 0) {
            $driver_id = $availableDrivers[0]->id;
            $minDistance = 100000000;
            foreach ($availableDrivers as $driver) {
                $temp = \Helper::calculateDistance($driver->latitude, $driver->longitude, $ride->source_latitude, $ride->source_longitude, "K");
                if ($minDistance > $temp) {
                    $minDistance = $temp;
                    $driver_id = $driver->id;
                }
            }
            RideRequest::create([
                'ride_id' => $ride->id,
                'driver_id' => $driver_id,
            ]);
        } else {
            $ride->status = "cancelled";
            $ride->save();
        }
        return back();
    }

    public function rideRequests()
    {
        $rides = Ride::whereIn('id', function ($query) {
            $query->select('ride_id')
                ->from('ride_requests')
                ->where('status', 'requested')
                ->where('driver_id', Auth::guard('driver')->id())
                ->get();
        })->with(['user'])
            ->paginate(5);
        return view('driver.ride.requests', compact('rides'));
    }

    public function showRide(Ride $ride)
    {
        if ($ride->status == 'payment') {
            $ride = Ride::with(['payment'])
                ->find($ride->id);
        }
        return view('driver.ride.show', compact('ride'));
    }

    public function pickup(Ride $ride)
    {
        $this->checkForAccess($ride->driver_id);
        $ride->status = 'picked';
        $ride->save();
        return back()->withMessage("Rider pickup successfully");
    }

    public function complete(Ride $ride)
    {
        $this->checkForAccess($ride->driver_id);
        $this->completeRide($ride);
        return back()->withMessage("Waiting for Payment!");
    }

}
