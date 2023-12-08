<?php

namespace App\Http\Controllers;

use App\Http\Requests\RideFormRequest;
use App\Models\Drivers;
use App\Models\Payments;
use App\Models\Rating;
use App\Models\Ride;
use App\Models\RideRequest;
use App\Traits\RideTrait;
use App\Traits\UserCheckAccessTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;
use function Laravel\Prompts\select;

class RideController extends Controller
{
    use UserCheckAccessTrait, RideTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('user.ride.create');
    }

    public function store(RideFormRequest $request)
    {
        $ride = Ride::where('user_id', Auth::id())
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->first();
        if ($ride != null) {
            return to_route('user.ride.rides')->withError("You have a incomplete ride");
        }
        $availableDrivers = Drivers::where('status', 'available')
            ->where('location', $request->location)
            ->whereNotIn('id', function ($query) {
                $query->select('driver_id')
                    ->from('ride_requests')
                    ->where('status', 'requested')
                    ->get();
            })
            ->get();
        if (count($availableDrivers) > 0) {
            $distance = \Helper::calculateDistance($request->source_latitude, $request->source_longitude, $request->destination_latitude, $request->destination_longitude, "K");
            $driver_id = $availableDrivers[0]->id;
            $minDistance = 100000000;
            foreach ($availableDrivers as $driver) {
                $temp = \Helper::calculateDistance($driver->latitude, $driver->longitude, $request->source_latitude, $request->source_longitude, "K");
                if ($minDistance > $temp) {
                    $minDistance = $temp;
                    $driver_id = $driver->id;
                }
            }
            $minDistance = (int)number_format($minDistance / 100);
            $ride = Ride::create([
                'user_id' => Auth::id(),
                'location' => $request->location,
                'source_latitude' => $request->source_latitude,
                'source_longitude' => $request->source_longitude,
                'destination_latitude' => $request->destination_latitude,
                'distance' => (int)number_format($distance / 100),
                'destination_longitude' => $request->destination_longitude,
                'requested_time' => $request->time,
                'status' => 'pending',
            ]);
            $rideRequest = RideRequest::create([
                "ride_id" => $ride->id,
                "driver_id" => $driver_id,
            ]);
            return to_route('user.ride.show', $ride->id);
        } else {
            return back()->withError("No driver available now");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $ride = Ride::findOrFail($id);
            $this->checkForAccess($ride->user_id);
            if ($ride->driver_id != null) { // means driver accepted the ride
                $ride = Ride::with('driver')->find($id);
            }
            if ($ride->status == 'payment') {
                $ride = Ride::with(['payment', 'driver'])
                    ->find($ride->id);
            } else if ($ride->status == 'completed') {
                $ride = Ride::with(['payment', 'rating'])
                    ->find($ride->id);
            }
            return view('user.ride.show', compact('ride'));
        } catch (Exception $e) {
            Log::error('Error in show of user ride ' . $e);
        }
    }

    public function complete(Ride $ride)
    {
        $this->checkForAccess($ride->user_id);
        $this->completeRide($ride);
        return back()->withMessage("Complete payment");
    }

    public function cancel(Ride $ride)
    {
        $this->checkForAccess($ride->user_id);
        if ($ride->status == "ongoing" || $ride->status == 'picked') {
            return back()->withError("You need to complete your ride!");
        } else {
            $rideRequests = RideRequest::where('ride_id', $ride->id)
                ->where('status', 'requested')
                ->first();
            $rideRequests->status = 'cancelled';
            $rideRequests->save();
            $ride->status = 'cancelled';
            $ride->save();
            return back()->withMessage("Ride cancelled successfully");
        }
    }

    public function pay(Ride $ride)
    {
        $this->checkForAccess($ride->user_id);
        $payment = Payments::where('ride_id', $ride->id)
            ->first();
        $payment->status = 'completed';
        $payment->save();
        $ride->status = 'completed';
        $ride->save();
        $driver = Drivers::find($ride->driver_id);
        $driver->status = "available";
        $driver->save();
        Rating::create([
            'driver_id' => $ride->driver_id,
            'ride_id' => $ride->id,
            'rating' => "0",
        ]);

        return back()->withMessage("Payment completed");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ride $ride)
    {
        $this->checkForAccess($ride->user_id);
        if ($ride->status == 'completed' || $ride->status == 'pending' || $ride->status == 'cancelled') {
            $ride->delete();
            return back()->withMessage("Ride deleted");
        } else {
            return back()->withError("Cancel the ride !");
        }
    }

}
